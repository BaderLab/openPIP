<?php
// src/AppBundle/Utils/QueryParameters.php
namespace AppBundle\Utils;

class QueryParameters
{

	protected $search_term_parameter;
	
	protected $search_term_summary;
	
	protected $category_summary;
	
	protected $tissue_expression_summary;
	
	protected $subcellular_location_expression_summary;
	
	protected $search_term_array;

	protected $filter_parameter;
	
	protected $category_array;
	
	/*
	protected $published_parameter;
	
	protected $validated_parameter;
	
	protected $verified_parameter;
	
	protected $literature_parameter;
	*/
	protected $text_output;
	
	protected $score_parameter;
	
	protected $tissue_expression_array;
	
	protected $subcellular_location_expression_array;
	
	protected $annotation_parameter_array;
	
	protected $annotation_parameter_summary;
	
	public function getFilterParameter() {
		return $this->filter_parameter;
	}
	public function setFilterParameter($filter_parameter) {
		$this->filter_parameter = $filter_parameter;
		return $this;
	}
	
	/*
	public function getPublishedParameter() {
		return $this->published_parameter;
	}
	public function setPublishedParameter($published_parameter) {
		$this->published_parameter = $published_parameter;
		return $this;
	}
	public function getValidatedParameter() {
		return $this->validated_parameter;
	}
	public function setValidatedParameter($validated_parameter) {
		$this->validated_parameter = $validated_parameter;
		return $this;
	}
	public function getVerifiedParameter() {
		return $this->verified_parameter;
	}
	public function setVerifiedParameter($verified_parameter) {
		$this->verified_parameter = $verified_parameter;
		return $this;
	}
	public function getLiteratureParameter() {
		return $this->literature_parameter;
	}
	public function setLiteratureParameter($literature_parameter) {
		$this->literature_parameter = $literature_parameter;
		return $this;
	}
	
	*/
	
	public function getScoreParameter() {
		return $this->score_parameter;
	}
	public function setScoreParameter($score_parameter) {
		$this->score_parameter = $score_parameter;
		return $this;
	}
	public function getSearchTermParameter() {
		return $this->search_term_parameter;
	}
	public function setSearchTermParameter($search_term_parameter) {
		$this->search_term_parameter = $search_term_parameter;
		return $this;
	}

	public function getSearchTermArray() {
		return $this->search_term_array;
	}
	public function setSearchTermArray($search_term_array) {
		$this->search_term_array = $search_term_array;
		return $this;
	}
	public function getCategorySummary() {
		return $this->category_summary;
	}
	public function setCategorySummary($category_summary) {
		$this->category_summary = $category_summary;
		return $this;
	}
	public function getSearchTermSummary() {
		return $this->search_term_summary;
	}
	public function setSearchTermSummary($search_term_summary) {
		$this->search_term_summary = $search_term_summary;
		return $this;
	}
	public function getTissueExpressionSummary() {
		return $this->tissue_expression_summary;
	}
	public function setTissueExpressionSummary($tissue_expression_summary) {
		$this->tissue_expression_summary = $tissue_expression_summary;
		return $this;
	}
	public function getSubcellularLocationExpressionSummary() {
		return $this->subcellular_location_expression_summary;
	}
	public function setSubcellularLocationExpressionSummary($subcellular_location_expression_summary) {
		$this->subcellular_location_expression_summary = $subcellular_location_expression_summary;
		return $this;
	}
	public function getTextOutput() {
		return $this->text_output;
	}
	public function setTextOutput($text_output) {
		$this->text_output = $text_output;
		return $this;
	}
	
	public function getCategoryArray() {
		return $this->category_array;
	}
	public function setCategoryArray($category_array) {
		$this->category_array = $category_array;
		return $this;
	}

	public function getTissueExpressionArray() {
		return $this->tissue_expression_array;
	}
	public function setTissueExpressionArray($tissue_expression_array) {
		$this->tissue_expression_array= $tissue_expression_array;
		return $this;
	}
	
	public function getSubcellularLocationExpressionArray() {
		return $this->subcellular_location_expression_array;
	}
	public function setSubcellularLocationExpressionArray($subcellular_location_expression_array) {
		$this->subcellular_location_expression_array= $subcellular_location_expression_array;
		return $this;
	}
	
	public function getAnnotationArray() {
		return $this->annotation_array;
	}
	public function setAnnotationArray($annotation_array) {
		$this->annotation_array= $annotation_array;
		return $this;
	}
	
	public function getAnnotationSummary() {
		return $this->annotation_array_summary;
	}
	public function setAnnotationSummary($annotation_array_summary) {
		$this->annotation_array_summary= $annotation_array_summary;
		return $this;
	}
	
	public function getAnnotationParameterArray(){
		return $this->annotation_parameter_array;
	}
	public function setAnnotatationParameterArray($annotation_parameter_array) {
		$this->annotation_parameter_array = $annotation_parameter_array;
		return $this;
	}
	
}

?>