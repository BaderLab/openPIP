import sys
import os

# Make sure imports work from tests/ subfolder
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))

from mitab_parser import parse_mitab27, parse_field
from csv_parser import parse_csv
from validator import validate_file
from models import ParsedInteraction, Protein, Organism, Dataset

# ─────────────────────────────────────────────
# Helpers
# ─────────────────────────────────────────────

SAMPLE_MITAB = os.path.join(os.path.dirname(__file__), "sample.mitab27.txt")


# ─────────────────────────────────────────────
# parse_field tests
# ─────────────────────────────────────────────

def test_parse_field_basic():
    """Standard db:value format"""
    result = parse_field("uniprotkb:P12345")
    assert len(result) == 1
    assert result[0].db == "uniprotkb"
    assert result[0].value == "P12345"
    assert result[0].description is None


def test_parse_field_with_description():
    """db:value(description) format"""
    result = parse_field("uniprotkb:P12345(BRCA1_HUMAN)")
    assert len(result) == 1
    assert result[0].db == "uniprotkb"
    assert result[0].value == "P12345"
    assert result[0].description == "BRCA1_HUMAN"


def test_parse_field_empty_dash():
    """-  means no value in PSI-MI TAB"""
    result = parse_field("-")
    assert result == []


def test_parse_field_empty_string():
    """Empty string also means no value"""
    result = parse_field("")
    assert result == []


def test_parse_field_multiple_values():
    """Multiple values separated by pipe"""
    result = parse_field("uniprotkb:P12345|ensembl:ENSP00000001")
    assert len(result) == 2
    assert result[0].db == "uniprotkb"
    assert result[0].value == "P12345"
    assert result[1].db == "ensembl"
    assert result[1].value == "ENSP00000001"


def test_parse_field_psi_mi_quoted():
    """PSI-MI fields often have quoted values like psi-mi:"MI:0018"(two hybrid)"""
    result = parse_field('psi-mi:"MI:0018"(two hybrid)')
    assert len(result) == 1
    assert result[0].db == "psi-mi"
    assert "MI:0018" in result[0].value
    assert result[0].description == "two hybrid"


# ─────────────────────────────────────────────
# parse_mitab27 file tests
# ─────────────────────────────────────────────

def test_parse_file_row_count():
    """Sample file has 3 data rows (1 header/comment line ignored)"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert len(interactions) == 3


def test_parse_file_protein_a_uniprot():
    """protein_a.uniprot_id correctly extracted from unique_id_a"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].protein_a.uniprot_id == "P12345"


def test_parse_file_protein_b_uniprot():
    """protein_b.uniprot_id correctly extracted from unique_id_b"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].protein_b.uniprot_id == "Q67890"


def test_parse_file_protein_a_ensembl():
    """ensembl_id extracted from alt_id_a"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].protein_a.ensembl_id == "ENSP00000001"


def test_parse_file_protein_b_ensembl():
    """ensembl_id extracted from alt_id_b"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].protein_b.ensembl_id == "ENSP00000002"


def test_parse_file_gene_name_a():
    """gene_name extracted from alias_a description field"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].protein_a.gene_name == "BRCA1_HUMAN"


def test_parse_file_gene_name_b():
    """gene_name extracted from alias_b description field"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].protein_b.gene_name == "TP53_HUMAN"


def test_parse_file_score():
    """confidence score correctly parsed as string for DB storage"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].score == "0.85"


def test_parse_file_score_missing():
    """missing score stored as None"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    # third row has no score
    assert interactions[2].score is None


def test_parse_file_organism_taxid():
    """organism taxid correctly extracted"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].organism_a.taxid_id == "9606"


def test_parse_file_interaction_category():
    """interaction_category.category_name populated from interaction_type"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].category is not None
    assert "physical association" in interactions[0].category.category_name.lower()


def test_parse_file_dataset_pubmed():
    """dataset.pubmed_id extracted from publication_id"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert interactions[0].dataset.pubmed_id == "12345678"


def test_parse_file_dataset_author():
    """dataset.author extracted from author field"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert "Smith" in interactions[0].dataset.author


def test_parse_file_returns_parsed_interaction():
    """Each row returns a ParsedInteraction instance"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    for ix in interactions:
        assert isinstance(ix, ParsedInteraction)


def test_parse_file_protein_objects():
    """protein_a and protein_b are Protein instances"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert isinstance(interactions[0].protein_a, Protein)
    assert isinstance(interactions[0].protein_b, Protein)


def test_parse_file_raw_preserved():
    """Raw row dict is preserved for debugging"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    assert "unique_id_a" in interactions[0].raw
    assert "unique_id_b" in interactions[0].raw


# ─────────────────────────────────────────────
# CSV parser tests
# ─────────────────────────────────────────────

def test_csv_parser_basic(tmp_path):
    """Basic CSV with required columns parses correctly"""
    csv_file = tmp_path / "test.csv"
    csv_file.write_text(
        "protein_a,protein_b,interaction_type,score,publication\n"
        "P12345,Q67890,physical association,0.9,12345678\n"
        "P98765,Q11111,direct interaction,0.5,87654321\n"
    )
    interactions = parse_csv(str(csv_file))
    assert len(interactions) == 2


def test_csv_parser_protein_a(tmp_path):
    """protein_a uniprot_id correctly set"""
    csv_file = tmp_path / "test.csv"
    csv_file.write_text(
        "protein_a,protein_b\n"
        "P12345,Q67890\n"
    )
    interactions = parse_csv(str(csv_file))
    assert interactions[0].protein_a.uniprot_id == "P12345"


def test_csv_parser_protein_b(tmp_path):
    """protein_b uniprot_id correctly set"""
    csv_file = tmp_path / "test.csv"
    csv_file.write_text(
        "protein_a,protein_b\n"
        "P12345,Q67890\n"
    )
    interactions = parse_csv(str(csv_file))
    assert interactions[0].protein_b.uniprot_id == "Q67890"


def test_csv_parser_score(tmp_path):
    """score correctly extracted"""
    csv_file = tmp_path / "test.csv"
    csv_file.write_text(
        "protein_a,protein_b,score\n"
        "P12345,Q67890,0.95\n"
    )
    interactions = parse_csv(str(csv_file))
    assert interactions[0].score == "0.95"


def test_csv_parser_missing_required_columns(tmp_path):
    """Missing protein_a or protein_b raises ValueError"""
    csv_file = tmp_path / "test.csv"
    csv_file.write_text(
        "gene,score\n"
        "BRCA1,0.9\n"
    )
    try:
        parse_csv(str(csv_file))
        assert False, "Should have raised ValueError"
    except ValueError as e:
        assert "protein_a" in str(e) or "protein_b" in str(e)


def test_csv_parser_returns_parsed_interaction(tmp_path):
    """CSV parser returns ParsedInteraction instances"""
    csv_file = tmp_path / "test.csv"
    csv_file.write_text(
        "protein_a,protein_b\n"
        "P12345,Q67890\n"
    )
    interactions = parse_csv(str(csv_file))
    assert isinstance(interactions[0], ParsedInteraction)


def test_csv_parser_pubmed(tmp_path):
    """publication column maps to dataset.pubmed_id"""
    csv_file = tmp_path / "test.csv"
    csv_file.write_text(
        "protein_a,protein_b,publication\n"
        "P12345,Q67890,12345678\n"
    )
    interactions = parse_csv(str(csv_file))
    assert interactions[0].dataset.pubmed_id == "12345678"


# ─────────────────────────────────────────────
# Validator tests
# ─────────────────────────────────────────────

def test_validator_valid_file():
    """All rows in sample file pass validation"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    results = validate_file(interactions)
    assert all(r.is_valid for r in results)


def test_validator_missing_protein_a():
    """Row with no protein_a identifier fails validation"""
    ix = ParsedInteraction(
        protein_a=Protein(),  # no uniprot_id, no gene_name
        protein_b=Protein(uniprot_id="Q67890")
    )
    from validator import validate_interaction
    result = validate_interaction(ix, line_num=1)
    assert not result.is_valid
    assert len(result.errors) > 0


def test_validator_missing_protein_b():
    """Row with no protein_b identifier fails validation"""
    ix = ParsedInteraction(
        protein_a=Protein(uniprot_id="P12345"),
        protein_b=Protein()
    )
    from validator import validate_interaction
    result = validate_interaction(ix, line_num=1)
    assert not result.is_valid


def test_validator_warns_no_uniprot():
    """Row with non-UniProt identifier generates warning"""
    ix = ParsedInteraction(
        protein_a=Protein(gene_name="BRCA1"),  # has gene_name but no uniprot_id
        protein_b=Protein(gene_name="TP53")
    )
    from validator import validate_interaction
    result = validate_interaction(ix, line_num=1)
    assert result.is_valid  # not an error, just a warning
    assert len(result.warnings) > 0


def test_validator_returns_list():
    """validate_file returns a list of results"""
    interactions = parse_mitab27(SAMPLE_MITAB)
    results = validate_file(interactions)
    assert isinstance(results, list)
    assert len(results) == len(interactions)


# ─────────────────────────────────────────────
# Run all tests manually if needed
# ─────────────────────────────────────────────

if __name__ == "__main__":
    # parse_field tests
    test_parse_field_basic()
    test_parse_field_with_description()
    test_parse_field_empty_dash()
    test_parse_field_empty_string()
    test_parse_field_multiple_values()
    test_parse_field_psi_mi_quoted()

    # mitab parser tests
    test_parse_file_row_count()
    test_parse_file_protein_a_uniprot()
    test_parse_file_protein_b_uniprot()
    test_parse_file_protein_a_ensembl()
    test_parse_file_protein_b_ensembl()
    test_parse_file_gene_name_a()
    test_parse_file_gene_name_b()
    test_parse_file_score()
    test_parse_file_score_missing()
    test_parse_file_organism_taxid()
    test_parse_file_interaction_category()
    test_parse_file_dataset_pubmed()
    test_parse_file_dataset_author()
    test_parse_file_returns_parsed_interaction()
    test_parse_file_protein_objects()
    test_parse_file_raw_preserved()

    # CSV tests need tmp_path — skip in manual run
    print("CSV and validator tests require pytest — run: pytest tests/")

    print("\nAll manual tests passed.")