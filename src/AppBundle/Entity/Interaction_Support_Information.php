<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`interaction_support_information`")
 */
class Interaction_Support_Information
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Interaction", inversedBy="interaction_support_informations")
     * @ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
     */
	protected $interaction;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Support_Information", inversedBy="interaction_support_informations")
	 * @ORM\JoinColumn(name="support_information_id", referencedColumnName="id")
	 */
	protected $support_information;
	
	
	
	public function __construct() {
		$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $value;

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
     * Set value
     *
     * @param string $value
     *
     * @return Interaction_Support_Information
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     *
     * @return Interaction_Support_Information
     */
    public function setInteraction(\AppBundle\Entity\Interaction $interaction = null)
    {
        $this->interaction = $interaction;

        return $this;
    }

    /**
     * Get interaction
     *
     * @return \AppBundle\Entity\Interaction
     */
    public function getInteraction()
    {
        return $this->interaction;
    }

    /**
     * Set supportInformation
     *
     * @param \AppBundle\Entity\Support_Information $supportInformation
     *
     * @return Interaction_Support_Information
     */
    public function setSupportInformation(\AppBundle\Entity\Support_Information $supportInformation = null)
    {
        $this->support_information = $supportInformation;

        return $this;
    }

    /**
     * Get supportInformation
     *
     * @return \AppBundle\Entity\Support_Information
     */
    public function getSupportInformation()
    {
        return $this->support_information;
    }
}
