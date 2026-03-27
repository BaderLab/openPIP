"""
Data models for openPIP 2.0 — Python dataclasses that directly mirror
the openpip.sql database schema. These are the target output objects
of the PSI-MI TAB and CSV parsers in this directory.

Table mappings:
    Protein             -> protein table
    Organism            -> organism table
    Dataset             -> dataset table
    InteractionCategory -> interaction_category table
    ParsedInteraction   -> interaction table + interaction_dataset +
                           interaction_interaction_category +
                           interaction_support_information
"""

from dataclasses import dataclass, field
from typing import Optional


@dataclass
class Protein:
    """Maps to the `protein` table in openpip.sql"""
    gene_name: Optional[str] = None
    protein_name: Optional[str] = None
    uniprot_id: Optional[str] = None
    ensembl_id: Optional[str] = None
    entrez_id: Optional[str] = None
    sequence: Optional[str] = None
    description: Optional[str] = None


@dataclass
class Organism:
    """Maps to the `organism` table in openpip.sql"""
    taxid_id: Optional[str] = None
    common_name: Optional[str] = None
    scientific_name: Optional[str] = None


@dataclass
class Dataset:
    """Maps to the `dataset` table in openpip.sql"""
    name: Optional[str] = None
    pubmed_id: Optional[str] = None
    author: Optional[str] = None
    year: Optional[str] = None
    interaction_status: Optional[str] = None
    description: Optional[str] = None


@dataclass
class InteractionCategory:
    """Maps to the `interaction_category` table in openpip.sql"""
    category_name: Optional[str] = None


@dataclass
class ParsedInteraction:
    """
    Maps to the `interaction` table plus related junction tables:
    interaction_dataset, interaction_interaction_category,
    interaction_support_information
    """
    protein_a: Protein = field(default_factory=Protein)
    protein_b: Protein = field(default_factory=Protein)
    organism_a: Organism = field(default_factory=Organism)
    organism_b: Organism = field(default_factory=Organism)
    score: Optional[str] = None
    category: Optional[InteractionCategory] = None
    dataset: Optional[Dataset] = None
    support_info: dict = field(default_factory=dict)
    raw: dict = field(default_factory=dict)