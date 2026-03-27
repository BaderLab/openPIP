import pytest

from app.parser import parse_confidence, parse_mitab_line
from app.models import RowValidationError


def test_parse_confidence_normalization_formats():
    assert parse_confidence("intact-miscore:0.43") == 0.43
    assert parse_confidence("score:0.85") == 0.85
    assert parse_confidence("mi-score:0.65") == 0.65
    assert parse_confidence("0.5") == 0.5
    assert parse_confidence("-") is None


def test_parse_mitab_line_valid_and_invalid():
    valid = (
        "uniprotkb:P12345\tuniprotkb:Q99999\t-\t-\tgeneA\tgeneB\t"
        "psi-mi:\"MI:0018\"(two hybrid)\tDoe et al\tpubmed:12345\t"
        "taxid:9606\ttaxid:9606\tpsi-mi:\"MI:0915\"(physical association)\t"
        "psi-mi:\"MI:0469\"(IntAct)\tintact:EBI-1\tintact-miscore:0.78"
    )

    parsed = parse_mitab_line(
        row_no=1,
        line=valid,
        dataset_id=42,
        source_file="demo.tsv",
        parser_version="v1",
    )
    assert parsed.pair_key == "uniprotkb:P12345::uniprotkb:Q99999"
    assert parsed.confidence_score == 0.78

    invalid = valid.replace("uniprotkb:P12345", "P12345")
    with pytest.raises(RowValidationError) as exc:
        parse_mitab_line(
            row_no=2,
            line=invalid,
            dataset_id=42,
            source_file="demo.tsv",
            parser_version="v1",
        )
    assert exc.value.code == "BAD_IDENTIFIER"
