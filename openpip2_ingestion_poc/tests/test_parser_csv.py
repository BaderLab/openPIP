import pytest

from app.models import RowValidationError
from app.parsers import parse_csv_line


def test_parse_csv_line_valid():
    line = "101,202,coexp,0.77,pmid:1234"
    parsed = parse_csv_line(
        row_no=2,
        line=line,
        dataset_id=7,
        source_file="demo.csv",
        parser_version="v1",
    )
    assert parsed.interactor_a_id == "101"
    assert parsed.interactor_b_id == "202"
    assert parsed.confidence_score == 0.77


def test_parse_csv_line_invalid_columns():
    with pytest.raises(RowValidationError) as exc:
        parse_csv_line(
            row_no=3,
            line="101",
            dataset_id=7,
            source_file="demo.csv",
            parser_version="v1",
        )
    assert exc.value.code == "CSV_SHORT_COLS"
