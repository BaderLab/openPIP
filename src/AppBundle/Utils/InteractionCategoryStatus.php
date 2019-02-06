<?php

// src/AppBundle/Utils/InteractionCategoryStatus.php
namespace AppBundle\Utils;

class InteractionCategoryStatus
{


	public $highest_category_status;
	
	public $category_array;
	
	public $tissue_expression_array;
	
	public function getHighestCategoryStatus() {
		return $this->highest_category_status;
	}
	public function setHighestCategoryStatus($highest_category_status) {
		$this->highest_category_status = $highest_category_status;
		return $this;
	}
	public function getCategoryArray() {
		return $this->category_array;
	}
	public function setCategoryArray($category_array) {
		$this->category_array= $category_array;
		return $this;
	}
	public function getTissueExpressionArray() {
		return $this->tissue_expression_array;
	}
	public function setTissueExpressionArray($tissue_expression_array) {
		$this->tissue_expression_array= $tissue_expression_array;
		return $this;
	}

}


?>