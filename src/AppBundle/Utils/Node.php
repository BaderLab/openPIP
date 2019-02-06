<?php
// src/AppBundle/Utils/Node.php
namespace AppBundle\Utils;

class Node 
{
	

	public $protein_id;
	
	public $protein_uniprot_id;
	
	public $protein_gene_name;
	
	public $protein_description;
	
	public $protein_external_links;
	
	public $tissue_expression_array;
	
	public function getProteinId() {
		return $this->protein_id;
	}
	
	public function setProteinId($protein_id) {
		$this->protein_id = $protein_id;
		return $this;
	}
	
	public function getProteinUniprotId() {
		return $this->protein_uniprot_id;
	}
	
	public function setProteinUniprotId($protein_uniprot_id) {
		$this->protein_uniprot_id = $protein_uniprot_id;
		return $this;
	}
	
	public function getProteinGeneName() {
		return $this->protein_gene_name;
	}
	
	public function setProteinGeneName($protein_gene_name) {
		$this->protein_gene_name = $protein_gene_name;
		return $this;
	}
	
	public function getProteinDescription() {
		return $this->protein_description;
	}
	
	public function setProteinDescription($protein_description) {
		$this->protein_description = $protein_description;
		return $this;
	}
	
	public function getProteinExternalLinks() {
		return $this->protein_external_links;
	}
	
	public function setProteinExternalLinks($protein_external_links) {
		$this->protein_external_links = $protein_external_links;
		return $this;
	}
	
	
	public function getTissueExpressionArray() {
		return $this->tissue_expression_array;
	}
	
	public function setTissueExpressionArray($tissue_expression_array) {
		$this->tissue_expression_array = $tissue_expression_array;
		return $this;
	}

}
?>

