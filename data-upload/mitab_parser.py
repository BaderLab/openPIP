"""
PSI-MI TAB v2.7 Parser for openPIP 2.0
Replaces the PHP upload parsing logic with a clean Python implementation.
Spec: https://psicquic.github.io/MITAB27Format.html

Output maps directly to openpip.sql schema via models.py
"""

import csv
import re
import io
from dataclasses import dataclass
from typing import Optional
from models import ParsedInteraction, Protein, Organism, Dataset, InteractionCategory


MITAB27_COLUMNS = [
    "unique_id_a", "unique_id_b",
    "alt_id_a", "alt_id_b",
    "alias_a", "alias_b",
    "interaction_detection_method",
    "author",
    "publication_id",
    "taxid_a", "taxid_b",
    "interaction_type",
    "source_database",
    "interaction_id",
    "confidence_score",
    "complex_expansion",
    "bio_role_a", "bio_role_b",
    "exp_role_a", "exp_role_b",
    "interactor_type_a", "interactor_type_b",
    "xref_a", "xref_b", "xref_interaction",
    "annotation_a", "annotation_b", "annotation_interaction",
    "host_organism_taxid",
    "parameters",
    "creation_date",
    "update_date",
    "checksum_a", "checksum_b", "checksum_interaction",
    "negative",
    "features_a", "features_b",
    "stoichiometry_a", "stoichiometry_b",
    "participant_identification_a", "participant_identification_b",
]

MITAB27_COLUMN_COUNT = 42


@dataclass
class MITABField:
    """Represents a parsed db:value(description) field."""
    db: str
    value: str
    description: Optional[str] = None


class MITABParseError(Exception):
    pass


# ─────────────────────────────────────────────────────────────
# Field-level parsing
# ─────────────────────────────────────────────────────────────

def parse_field(raw: str) -> list:
    """
    Parse one PSI-MI TAB cell into a list of MITABField objects.
    Handles: db:value(description) | db:value | - (empty)
    """
    if raw.strip() in ("-", ""):
        return []

    results = []
    entries = _split_pipe(raw)

    for entry in entries:
        entry = entry.strip()
        if not entry or entry == "-":
            continue
        # Remove surrounding quotes from value if present
        match = re.match(
            r'^([^:(]+):"?([^"(|]+?)"?(?:\((.+)\))?$',
            entry
        )
        if match:
            db, value, desc = match.groups()
            results.append(MITABField(
                db=db.strip(),
                value=value.strip(),
                description=desc.strip() if desc else None
            ))
        else:
            results.append(MITABField(db="unknown", value=entry))
    return results


def _split_pipe(s: str) -> list:
    """Split by | while respecting quoted strings."""
    parts = []
    current = []
    in_quotes = False
    for char in s:
        if char == '"':
            in_quotes = not in_quotes
            current.append(char)
        elif char == '|' and not in_quotes:
            parts.append(''.join(current))
            current = []
        else:
            current.append(char)
    if current:
        parts.append(''.join(current))
    return parts


# ─────────────────────────────────────────────────────────────
# Extraction helpers — map MITABFields to openpip.sql columns
# ─────────────────────────────────────────────────────────────

def _extract_id(fields: list, db_names: tuple) -> Optional[str]:
    """Extract value from MITABFields matching any of the given db names."""
    for f in fields:
        if f.db.lower() in db_names:
            return f.value
    return None


def _extract_description(fields: list) -> Optional[str]:
    """
    Extract gene name from alias fields.
    In PSI-MI TAB alias fields, the VALUE is the gene name
    and the description tells us the type e.g. (gene name).
    We return the value only when description confirms it is a gene name.
    """
    for f in fields:
        if f.description and "gene name" in f.description.lower():
            return f.value
    # fallback — return first value if no gene name type found
    for f in fields:
        if f.value:
            return f.value
    return None


def _extract_taxid(fields: list) -> Optional[str]:
    """Extract numeric taxid from taxid:9606(human) format."""
    for f in fields:
        if f.db.lower() == "taxid":
            return f.value
    return None


def _extract_common_name(fields: list) -> Optional[str]:
    """Extract organism common name from taxid field description."""
    for f in fields:
        if f.db.lower() == "taxid" and f.description:
            return f.description
    return None


# ─────────────────────────────────────────────────────────────
# Core builder — maps one parsed row to openpip.sql schema
# ─────────────────────────────────────────────────────────────

def _build_interaction(row: list, raw: dict) -> ParsedInteraction:
    """
    Build a ParsedInteraction from a raw tab-separated row.
    Maps PSI-MI TAB 2.7 columns directly to openpip.sql schema fields.
    """
    uid_a    = parse_field(row[0])
    uid_b    = parse_field(row[1])
    alt_a    = parse_field(row[2])
    alt_b    = parse_field(row[3])
    alias_a  = parse_field(row[4])
    alias_b  = parse_field(row[5])
    author   = parse_field(row[7])
    pub_id   = parse_field(row[8])
    taxid_a  = parse_field(row[9])
    taxid_b  = parse_field(row[10])
    int_type = parse_field(row[11])
    conf     = parse_field(row[14])

    # protein table
    protein_a = Protein(
        uniprot_id=_extract_id(uid_a + alt_a, ("uniprotkb", "uniprot")),
        ensembl_id=_extract_id(uid_a + alt_a, ("ensembl",)),
        entrez_id=_extract_id(uid_a + alt_a, ("entrez", "entrezgene")),
        gene_name=_extract_description(alias_a),
    )
    protein_b = Protein(
        uniprot_id=_extract_id(uid_b + alt_b, ("uniprotkb", "uniprot")),
        ensembl_id=_extract_id(uid_b + alt_b, ("ensembl",)),
        entrez_id=_extract_id(uid_b + alt_b, ("entrez", "entrezgene")),
        gene_name=_extract_description(alias_b),
    )

    # organism table
    organism_a = Organism(
        taxid_id=_extract_taxid(taxid_a),
        common_name=_extract_common_name(taxid_a),
    )
    organism_b = Organism(
        taxid_id=_extract_taxid(taxid_b),
        common_name=_extract_common_name(taxid_b),
    )

    # interaction_category table
    category = None
    if int_type:
        category = InteractionCategory(
            category_name=int_type[0].description or int_type[0].value
        )

    # dataset table
    pubmed    = _extract_id(pub_id, ("pubmed",))
    author_str = author[0].value if author else None
    dataset = Dataset(
        pubmed_id=pubmed,
        author=author_str,
    ) if (pubmed or author_str) else None

    # interaction.score — varchar(10) in DB, keep as string
    score = None
    if conf:
        try:
            score = str(round(float(conf[0].value), 6))[:10]
        except ValueError:
            score = None

    return ParsedInteraction(
        protein_a=protein_a,
        protein_b=protein_b,
        organism_a=organism_a,
        organism_b=organism_b,
        score=score,
        category=category,
        dataset=dataset,
        raw=raw,
    )


# ─────────────────────────────────────────────────────────────
# Public API
# ─────────────────────────────────────────────────────────────

def parse_mitab27(filepath: str) -> list:
    """
    Parse a PSI-MI TAB 2.7 file.
    Returns a list of ParsedInteraction objects.
    """
    interactions = []
    with open(filepath, 'r', encoding='utf-8') as f:
        reader = csv.reader(f, delimiter='\t')
        for line_num, row in enumerate(reader, start=1):
            if not row or row[0].startswith('#'):
                continue
            if len(row) < 15:
                raise MITABParseError(
                    f"Line {line_num}: Expected at least 15 columns, "
                    f"got {len(row)}."
                )
            while len(row) < MITAB27_COLUMN_COUNT:
                row.append('-')
            raw = dict(zip(MITAB27_COLUMNS, row))
            interactions.append(_build_interaction(row, raw))
    return interactions


def parse_mitab27_from_string(content: str) -> list:
    """
    Parse PSI-MI TAB 2.7 from a raw string.
    Useful for API upload endpoints that receive file content directly.
    """
    interactions = []
    reader = csv.reader(io.StringIO(content), delimiter='\t')
    for line_num, row in enumerate(reader, start=1):
        if not row or row[0].startswith('#'):
            continue
        if len(row) < 15:
            raise MITABParseError(
                f"Line {line_num}: Too few columns ({len(row)})"
            )
        while len(row) < MITAB27_COLUMN_COUNT:
            row.append('-')
        raw = dict(zip(MITAB27_COLUMNS, row))
        interactions.append(_build_interaction(row, raw))
    return interactions