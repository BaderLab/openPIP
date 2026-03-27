"""
Validation layer for openPIP 2.0
Validates ParsedInteraction objects before DB insertion.
Works for both PSI-MI TAB and CSV parsed data since both
produce the same ParsedInteraction model.
"""

from dataclasses import dataclass
from models import ParsedInteraction


@dataclass
class ValidationResult:
    is_valid: bool
    errors: list
    warnings: list


def validate_interaction(ix: ParsedInteraction, line_num: int) -> ValidationResult:
    """
    Validate a single ParsedInteraction.
    Errors block DB insertion. Warnings are logged but allowed.
    """
    errors = []
    warnings = []

    # At least one identifier required for each interactor
    has_a = (
        ix.protein_a.uniprot_id or
        ix.protein_a.gene_name or
        ix.protein_a.ensembl_id
    )
    has_b = (
        ix.protein_b.uniprot_id or
        ix.protein_b.gene_name or
        ix.protein_b.ensembl_id
    )

    if not has_a:
        errors.append(
            f"Line {line_num}: Interactor A has no identifier "
            f"(uniprot_id, gene_name, or ensembl_id required)"
        )
    if not has_b:
        errors.append(
            f"Line {line_num}: Interactor B has no identifier "
            f"(uniprot_id, gene_name, or ensembl_id required)"
        )

    # Warn if no UniProt ID — UniProt REST annotation will be skipped
    if has_a and not ix.protein_a.uniprot_id:
        warnings.append(
            f"Line {line_num}: No UniProt ID for interactor A "
            f"— UniProt annotation fetch will be skipped"
        )
    if has_b and not ix.protein_b.uniprot_id:
        warnings.append(
            f"Line {line_num}: No UniProt ID for interactor B "
            f"— UniProt annotation fetch will be skipped"
        )

    # Warn if score present but not numeric
    if ix.score is not None:
        try:
            float(ix.score)
        except ValueError:
            warnings.append(
                f"Line {line_num}: Score '{ix.score}' is not numeric"
            )

    return ValidationResult(
        is_valid=len(errors) == 0,
        errors=errors,
        warnings=warnings,
    )


def validate_file(interactions: list) -> list:
    """Validate all interactions from a parsed file."""
    return [
        validate_interaction(ix, i + 1)
        for i, ix in enumerate(interactions)
    ]