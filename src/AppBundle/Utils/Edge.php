<?php
// src/AppBundle/Utils/Edge.php
namespace AppBundle\Utils;

class Edge 
{


	public $protein_A;
	
	public $protein_B;

	public $score;

	public $publication_status;
	
	public $datasets;
	
	public function getProteinA() {
		return $this->protein_A;
	}
	public function setProteinA($protein_A) {
		$this->protein_A = $protein_A;
		return $this;
	}

	public function getProteinB() {
		return $this->protein_B;
	}
	public function setProteinB($protein_B) {
		$this->protein_B = $protein_B;
		return $this;
	}
	

	public function getScore() {
		return $this->score;
	}
	public function setScore($score) {
		$this->score = $score;
		return $this;
	}
	public function getPublicationStatus() {
		return $this->publication_status;
	}
	public function setPublicationStatus($publication_status) {
		$this->publication_status = $publication_status;
		return $this;
	}
	public function getDatasets() {
		return $this->datasets;
	}
	public function setDatasets($datasets) {
		$this->datasets = $datasets;
		return $this;
	}
	
	
	
	
}

?>

        	         