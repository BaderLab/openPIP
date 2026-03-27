from __future__ import annotations

"""Parser plugin contract and implementations.

Each parser must implement:
  - sniff(file_path: Path) -> (confidence: float, hints: dict)
  - validate(lines: Iterator[str]) -> Iterator[ValidationError]
  - parse(lines: Iterator[str]) -> Iterator[CanonicalInteraction]
  - transform(canonical: CanonicalInteraction) -> dict (for storage/serialization)
"""

from typing import Iterator, Optional, Protocol
from pathlib import Path
from .models import CanonicalInteraction, RowValidationError
from .parser import split_multivalue
from .parser import parse_mitab_line
from .config import get_parser_version


class InteractionParser(Protocol):
    """Contract for pluggable parsers."""

    def sniff(self, file_path: Path) -> tuple[float, dict]:
        """Guess file format; return (confidence 0-1, metadata hints)."""
        ...

    def validate(
        self, lines: Iterator[str], dataset_id: int
    ) -> Iterator[RowValidationError]:
        """Yield validation errors without parsing."""
        ...

    def parse(
        self, lines: Iterator[str], dataset_id: int, source_file: str
    ) -> Iterator[CanonicalInteraction]:
        """Yield canonical interactions from lines."""
        ...

    def transform(self, canonical: CanonicalInteraction) -> dict:
        """Serialize canonical to JSON-safe dict."""
        ...


class PSIMITabParser:
    """PSI-MI TAB 2.5/2.7 parser with column 15 confidence normalization."""

    def sniff(self, file_path: Path) -> tuple[float, dict]:
        """Check for MITAB signatures (15+ tab-delimited columns, confidence patterns)."""
        try:
            with file_path.open() as f:
                for line in f:
                    if line.startswith("#"):
                        continue
                    cols = line.split("\t")
                    if len(cols) >= 15:
                        # Look for PSI-MI signatures (namespace:value patterns)
                        if ":" in cols[0] and ":" in cols[1]:
                            return 0.95, {"format": "psi_mitab", "columns": len(cols)}
                    break
        except Exception:
            pass
        return 0.0, {}

    def validate(
        self, lines: Iterator[str], dataset_id: int
    ) -> Iterator[RowValidationError]:
        """Scan for validation errors without full parsing."""
        for row_no, line in enumerate(lines, start=1):
            if not line.strip() or line.startswith("#"):
                continue
            cols = line.split("\t")
            if len(cols) < 15:
                yield RowValidationError(
                    row_no=row_no,
                    code="SHORT_ROW",
                    message=f"Expected >= 15 columns, found {len(cols)}",
                    raw_payload=line.rstrip("\n"),
                )

    def parse(
        self, lines: Iterator[str], dataset_id: int, source_file: str
    ) -> Iterator[CanonicalInteraction]:
        """Parse PSI-MI TAB with confidence normalization."""
        from .parser import (
            parse_mitab_line,
            parse_mitab_stream,
        )
        from .config import get_parser_version

        yield from parse_mitab_stream(
            lines=lines,
            dataset_id=dataset_id,
            source_file=source_file,
            parser_version=get_parser_version(),
        )

    def transform(self, canonical: CanonicalInteraction) -> dict:
        """Serialize to JSON."""
        return {
            "dataset_id": canonical.dataset_id,
            "pair_key": canonical.pair_key,
            "interactor_a": f"{canonical.interactor_a_ns}:{canonical.interactor_a_id}",
            "interactor_b": f"{canonical.interactor_b_ns}:{canonical.interactor_b_id}",
            "interaction_type": canonical.interaction_type,
            "confidence": canonical.confidence_score,
            "publication": canonical.publication_id,
            "source_file": canonical.source_file,
            "source_row": canonical.source_row,
            "parser_version": canonical.parser_version,
        }


class CSVGeneInteractionParser:
    """Minimal CSV parser: gene_a, gene_b, method, confidence, publication."""

    def sniff(self, file_path: Path) -> tuple[float, dict]:
        """Check for CSV with gene pair columns."""
        try:
            with file_path.open() as f:
                line = f.readline()
                if not line:
                    return 0.0, {}
                if "gene" in line.lower() or "entrez" in line.lower():
                    return 0.8, {"format": "csv", "columns": len(line.split(","))}
        except Exception:
            pass
        return 0.0, {}

    def validate(
        self, lines: Iterator[str], dataset_id: int
    ) -> Iterator[RowValidationError]:
        """Scan for CSV errors."""
        for row_no, line in enumerate(lines, start=1):
            if not line.strip():
                continue
            cols = line.split(",")
            if len(cols) < 2:
                yield RowValidationError(
                    row_no=row_no,
                    code="CSV_SHORT_COLS",
                    message=f"Expected >= 2 columns, found {len(cols)}",
                    raw_payload=line.rstrip("\n"),
                )

    def parse(
        self, lines: Iterator[str], dataset_id: int, source_file: str
    ) -> Iterator[CanonicalInteraction]:
        """Parse CSV gene interactions."""
        from .config import get_parser_version

        parser_version = get_parser_version()
        for row_no, line in enumerate(lines, start=1):
            if row_no == 1 or not line.strip():
                continue  # Skip header
            cols = [c.strip() for c in line.split(",")]
            if len(cols) < 2:
                continue

            gene_a = cols[0]
            gene_b = cols[1]
            method = cols[2] if len(cols) > 2 else "unknown"
            confidence = None
            if len(cols) > 3:
                try:
                    confidence = float(cols[3])
                except ValueError:
                    pass
            publication = cols[4] if len(cols) > 4 else None

            pair_key = "::".join(sorted([gene_a, gene_b]))
            yield CanonicalInteraction(
                dataset_id=dataset_id,
                pair_key=pair_key,
                interactor_a_ns="entrez_id",
                interactor_a_id=gene_a,
                interactor_b_ns="entrez_id",
                interactor_b_id=gene_b,
                interaction_type="genetic",
                confidence_score=confidence,
                publication_id=publication,
                source_file=source_file,
                source_row=row_no,
                parser_version=parser_version,
            )

    def transform(self, canonical: CanonicalInteraction) -> dict:
        """Serialize to JSON."""
        return {
            "dataset_id": canonical.dataset_id,
            "pair_key": canonical.pair_key,
            "interactor_a": f"{canonical.interactor_a_ns}:{canonical.interactor_a_id}",
            "interactor_b": f"{canonical.interactor_b_ns}:{canonical.interactor_b_id}",
            "confidence": canonical.confidence_score,
            "publication": canonical.publication_id,
        }


def parse_csv_line(
    row_no: int,
    line: str,
    dataset_id: int,
    source_file: str,
    parser_version: str,
) -> CanonicalInteraction:
    cols = [c.strip() for c in line.rstrip("\n").split(",")]
    if len(cols) < 2:
        raise RowValidationError(
            row_no=row_no,
            code="CSV_SHORT_COLS",
            message=f"Expected >= 2 columns, found {len(cols)}",
            raw_payload=line.rstrip("\n"),
        )

    gene_a = cols[0]
    gene_b = cols[1]
    if not gene_a or not gene_b:
        raise RowValidationError(
            row_no=row_no,
            code="CSV_MISSING_INTERACTOR",
            message="CSV row must include interactor_a and interactor_b",
            raw_payload=line.rstrip("\n"),
        )

    confidence = None
    if len(cols) > 3 and cols[3] not in ("", "-"):
        try:
            confidence = float(cols[3])
        except ValueError as exc:
            raise RowValidationError(
                row_no=row_no,
                code="CSV_BAD_CONFIDENCE",
                message=f"Invalid confidence value: {cols[3]}",
                raw_payload=line.rstrip("\n"),
            ) from exc

    publication = cols[4] if len(cols) > 4 and cols[4] not in ("", "-") else None
    pair_key = "::".join(sorted([gene_a, gene_b]))

    return CanonicalInteraction(
        dataset_id=dataset_id,
        pair_key=pair_key,
        interactor_a_ns="entrez_id",
        interactor_a_id=gene_a,
        interactor_b_ns="entrez_id",
        interactor_b_id=gene_b,
        interaction_type="genetic",
        confidence_score=confidence,
        publication_id=publication,
        source_file=source_file,
        source_row=row_no,
        parser_version=parser_version,
    )


def parse_line(
    parser_hint: str,
    row_no: int,
    line: str,
    dataset_id: int,
    source_file: str,
) -> CanonicalInteraction:
    parser_version = get_parser_version()
    if parser_hint == "csv":
        return parse_csv_line(
            row_no=row_no,
            line=line,
            dataset_id=dataset_id,
            source_file=source_file,
            parser_version=parser_version,
        )

    return parse_mitab_line(
        row_no=row_no,
        line=line,
        dataset_id=dataset_id,
        source_file=source_file,
        parser_version=parser_version,
    )


def get_parser(hint: Optional[str]) -> InteractionParser:
    """Select parser by hint or raise."""
    if hint == "csv":
        return CSVGeneInteractionParser()
    if hint in ("psi_mitab", None):
        return PSIMITabParser()
    raise ValueError(f"Unknown parser hint: {hint}")
