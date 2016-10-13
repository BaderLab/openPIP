<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`support_information`")
 */
class Support_Information
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="Interaction_Support_Information", mappedBy="support_information")
	 */
	private $interaction_support_informations;
	
	
	public function __construct() {
		$this->interaction_support_informations = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $description;
	

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
     * Set name
     *
     * @param string $name
     * @return Support_Information
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Support_Information
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }



    /**
     * Add interactionSupportInformation
     *
     * @param \AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation
     *
     * @return Support_Information
     */
    public function addInteractionSupportInformation(\AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation)
    {
        $this->interaction_support_informations[] = $interactionSupportInformation;

        return $this;
    }

    /**
     * Remove interactionSupportInformation
     *
     * @param \AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation
     */
    public function removeInteractionSupportInformation(\AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation)
    {
        $this->interaction_support_informations->removeElement($interactionSupportInformation);
    }

    /**
     * Get interactionSupportInformations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInteractionSupportInformations()
    {
        return $this->interaction_support_informations;
    }
}
