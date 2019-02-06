<?php
// src/AppBundle/Utils/PublicationStatus.php
namespace AppBundle\Utils;

class PublicationStatus
{

	public $highest_publication_status;
	
	public $published;
	
	public $validated;
	
	public $verified;
	
	public $literature;
	
	public function getHighestPublicationStatus() {
		return $this->highest_publication_status;
	}
	public function setHighestPublicationStatus($highest_publication_status) {
		$this->highest_publication_status = $highest_publication_status;
		return $this;
	}
	public function getPublished() {
		return $this->published;
	}
	public function setPublished($published) {
		$this->published = $published;
		return $this;
	}
	public function getValidated() {
		return $this->validated;
	}
	public function setValidated($validated) {
		$this->validated = $validated;
		return $this;
	}
	public function getVerified() {
		return $this->verified;
	}
	public function setVerified($verified) {
		$this->verified = $verified;
		return $this;
	}
	public function getLiterature() {
		return $this->literature;
	}
	public function setLiterature($literature) {
		$this->literature = $literature;
		return $this;
	}
	
	
	
	
}