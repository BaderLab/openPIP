from __future__ import annotations

from dataclasses import dataclass
from typing import Optional


@dataclass
class CanonicalInteraction:
    dataset_id: int
    pair_key: str
    interactor_a_ns: str
    interactor_a_id: str
    interactor_b_ns: str
    interactor_b_id: str
    interaction_type: Optional[str]
    confidence_score: Optional[float]
    publication_id: Optional[str]
    source_file: str
    source_row: int
    parser_version: str


class RowValidationError(Exception):
    def __init__(self, row_no: int, code: str, message: str, raw_payload: Optional[str] = None):
        super().__init__(message)
        self.row_no = row_no
        self.code = code
        self.message = message
        self.raw_payload = raw_payload
