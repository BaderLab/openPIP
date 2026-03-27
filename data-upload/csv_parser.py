"""
CSV Parser for openPIP 2.0
Accepts a simplified flat CSV and normalizes it to the same
ParsedInteraction model used by the PSI-MI TAB parser so that
the same validation and DB insertion pipeline handles both formats.

Minimum required CSV columns: protein_a, protein_b
Optional columns: interaction_type, score, publication,
                  author, dataset, year
"""

import csv
import re
from models import ParsedInteraction, Protein, Dataset, InteractionCategory


REQUIRED_CSV_COLUMNS = {"protein_a", "protein_b"}


def parse_csv(filepath: str) -> list:
    """
    Parse a CSV file and return a list of ParsedInteraction objects.
    """
    interactions = []

    with open(filepath, 'r', encoding='utf-8') as f:
        reader = csv.DictReader(f)
        headers = set(reader.fieldnames or [])

        missing = REQUIRED_CSV_COLUMNS - headers
        if missing:
            raise ValueError(
                f"CSV is missing required columns: {missing}. "
                f"At minimum 'protein_a' and 'protein_b' are required."
            )

        for row in reader:
            protein_a_raw = row.get("protein_a", "").strip()
            protein_b_raw = row.get("protein_b", "").strip()

            if not protein_a_raw or not protein_b_raw:
                continue

            is_uniprot_a = _looks_like_uniprot(protein_a_raw)
            is_uniprot_b = _looks_like_uniprot(protein_b_raw)

            protein_a = Protein(
                uniprot_id=protein_a_raw if is_uniprot_a else None,
                gene_name=None if is_uniprot_a else protein_a_raw,
            )
            protein_b = Protein(
                uniprot_id=protein_b_raw if is_uniprot_b else None,
                gene_name=None if is_uniprot_b else protein_b_raw,
            )

            score_raw = row.get("score", "").strip()
            score = score_raw if score_raw else None

            interaction_type_raw = row.get("interaction_type", "").strip()
            category = InteractionCategory(
                category_name=interaction_type_raw
            ) if interaction_type_raw else None

            dataset = Dataset(
                pubmed_id=row.get("publication", "").strip() or None,
                author=row.get("author", "").strip() or None,
                name=row.get("dataset", "").strip() or None,
                year=row.get("year", "").strip() or None,
            )

            interactions.append(ParsedInteraction(
                protein_a=protein_a,
                protein_b=protein_b,
                score=score,
                category=category,
                dataset=dataset,
                raw=dict(row),
            ))

    return interactions


def _looks_like_uniprot(s: str) -> bool:
    """
    Rough check for UniProt accession format.
    Examples: P12345, Q67890, A0A000
    """
    return bool(re.match(
        r'^[OPQ][0-9][A-Z0-9]{3}[0-9]$|^[A-NR-Z][0-9]([A-Z][A-Z0-9]{2}[0-9]){1,2}$',
        s
    ))