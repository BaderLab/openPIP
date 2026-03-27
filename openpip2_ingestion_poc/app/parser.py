from __future__ import annotations

from typing import Iterator
from typing import Optional

from .models import CanonicalInteraction, RowValidationError

MITAB_MIN_COLUMNS = 15


def split_multivalue(value: str) -> list[str]:
    if not value or value == "-":
        return []
    return [v.strip() for v in value.split("|") if v.strip() and v.strip() != "-"]


def extract_identifier(raw: str, row_no: int) -> tuple[str, str]:
    tokens = split_multivalue(raw)
    token = tokens[0] if tokens else ""
    if ":" not in token:
        raise RowValidationError(
            row_no=row_no,
            code="BAD_IDENTIFIER",
            message=f"Missing namespace:value identifier in token: {raw}",
            raw_payload=raw,
        )

    ns, value = token.split(":", 1)
    ns = ns.strip().lower()
    value = value.strip()
    if not ns or not value:
        raise RowValidationError(
            row_no=row_no,
            code="BAD_IDENTIFIER",
            message=f"Invalid namespace:value identifier in token: {raw}",
            raw_payload=raw,
        )

    return ns, value


def parse_confidence(raw: str) -> Optional[float]:
    """Parse confidence from PSI-MI TAB column 15.
    
    Handles multiple formats per PSI-MI 2.7 spec:
    - intact-miscore:0.85 (MiScore, most canonical)
    - score:0.85 (generic score prefix)
    - mi-score:0.85 (alternate spelling)
    - 0.85 (bare float, least preferred but valid)
    Returns None for '-' or missing values.
    """
    if not raw or raw == "-":
        return None
    
    for token in split_multivalue(raw):
        # Try typed formats first (most reliable)
        if ":" in token:
            prefix, val = token.split(":", 1)
            if prefix.lower() in ("intact-miscore", "mi-score", "miscore", "score"):
                try:
                    return float(val.strip())
                except ValueError:
                    continue
        
        # Try bare float if no prefix
        try:
            return float(token.strip())
        except ValueError:
            continue
    
    return None


def parse_mitab_line(
    row_no: int,
    line: str,
    dataset_id: int,
    source_file: str,
    parser_version: str,
) -> CanonicalInteraction:
    cols = line.rstrip("\n").split("\t")
    if len(cols) < MITAB_MIN_COLUMNS:
        raise RowValidationError(
            row_no=row_no,
            code="SHORT_ROW",
            message=f"Expected >= 15 columns, found {len(cols)}",
            raw_payload=line.rstrip("\n"),
        )

    id_a = cols[0]
    id_b = cols[1]
    detection_method = cols[6]
    publication_id = cols[8]
    interaction_type = cols[11]
    confidence = cols[14]

    ns_a, val_a = extract_identifier(id_a, row_no)
    ns_b, val_b = extract_identifier(id_b, row_no)

    pair_key = "::".join(sorted([f"{ns_a}:{val_a}", f"{ns_b}:{val_b}"]))
    methods = split_multivalue(detection_method)

    if not methods:
        raise RowValidationError(
            row_no=row_no,
            code="MISSING_METHOD",
            message="No interaction detection method found in column 7",
            raw_payload=line.rstrip("\n"),
        )

    return CanonicalInteraction(
        dataset_id=dataset_id,
        pair_key=pair_key,
        interactor_a_ns=ns_a,
        interactor_a_id=val_a,
        interactor_b_ns=ns_b,
        interactor_b_id=val_b,
        interaction_type=interaction_type if interaction_type != "-" else None,
        confidence_score=parse_confidence(confidence),
        publication_id=publication_id if publication_id != "-" else None,
        source_file=source_file,
        source_row=row_no,
        parser_version=parser_version,
    )


def parse_mitab_stream(
    lines: Iterator[str],
    dataset_id: int,
    source_file: str,
    parser_version: str,
) -> Iterator[CanonicalInteraction]:
    for row_no, line in enumerate(lines, start=1):
        if not line.strip() or line.startswith("#"):
            continue
        yield parse_mitab_line(
            row_no=row_no,
            line=line,
            dataset_id=dataset_id,
            source_file=source_file,
            parser_version=parser_version,
        )
