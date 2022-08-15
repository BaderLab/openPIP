<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`interaction_organism`")
 */
class Interaction_Organism
{
    /**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	

	
	public function __construct() {
		$this->domains = new \Doctrine\Common\Collections\ArrayCollection();
		$this->proteins = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $organism_id;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $interaction_id;
	
    /**
     * Get organism_id
     *
     * @return integer
     */
    public function getOrganismId()
    {
        return $this->organism_id;
    }

    /**
     * Get interaction_id
     * @return integer
     */
    public function getInteractionId()
    {
        return $this->interaction_id;
    }

    /**
     * Set interactionId
     * @param string $interactionId
     * @return Interaction_Organism
     */
    public function setInteractionId($interactionId)
    {
        $this->interaction_id = $interactionId;
        return $this;
    }

    /**
     * Set organism_id
     *
     * @param string $organismId
     *
     * @return Interaction_Organism
     */
    public function setOrganismId($organismId)
    {
        $this->organism_id = $organismId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Interaction_Organism
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


}
