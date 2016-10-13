<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`domain`")
 */
class Domain
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

   /**
     * @ORM\OneToMany(targetEntity="Interaction", mappedBy="domain")
     */
	private $interactions;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Organism[]
	 * @ORM\ManyToMany(targetEntity="Organism", mappedBy="domains")
	 */
	private $organisms;
	
    /**
     * @ORM\ManyToOne(targetEntity="Protein", inversedBy="identifiers")
     * @ORM\JoinColumn(name="protein_id", referencedColumnName="id")
     */
	protected $protein;
	
	public function __construct() {

		$this->data_files = new \Doctrine\Common\Collections\ArrayCollection();
		$this->organisms = new \Doctrine\Common\Collections\ArrayCollection();

	}
	
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $type;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $start_position;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $end_position;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $sequence;

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
     * Set type
     *
     * @param string $type
     * @return Domain
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Domain
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
     * Set start
     *
     * @param string $start
     * @return Domain
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return string 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param string $end
     * @return Domain
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return string 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Domain
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
     * Set sequence
     *
     * @param string $sequence
     * @return Domain
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return string 
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Add interactions
     *
     * @param \AppBundle\Entity\Interaction $interactions
     * @return Domain
     */
    public function addInteraction(\AppBundle\Entity\Interaction $interactions)
    {
        $this->interactions[] = $interactions;

        return $this;
    }

    /**
     * Remove interactions
     *
     * @param \AppBundle\Entity\Interaction $interactions
     */
    public function removeInteraction(\AppBundle\Entity\Interaction $interactions)
    {
        $this->interactions->removeElement($interactions);
    }

    /**
     * Get interactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInteractions()
    {
        return $this->interactions;
    }

 

    /**
     * Add organisms
     *
     * @param \AppBundle\Entity\Organism $organisms
     * @return Domain
     */
    public function addOrganism(\AppBundle\Entity\Organism $organisms)
    {
        $this->organisms[] = $organisms;

        return $this;
    }

    /**
     * Remove organisms
     *
     * @param \AppBundle\Entity\Organism $organisms
     */
    public function removeOrganism(\AppBundle\Entity\Organism $organisms)
    {
        $this->organisms->removeElement($organisms);
    }

    /**
     * Get organisms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganisms()
    {
        return $this->organisms;
    }

    /**
     * Set protein
     *
     * @param \AppBundle\Entity\Protein $protein
     * @return Domain
     */
    public function setProtein(\AppBundle\Entity\Protein $protein = null)
    {
        $this->protein = $protein;

        return $this;
    }

    /**
     * Get protein
     *
     * @return \AppBundle\Entity\Protein 
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * Set startPosition
     *
     * @param string $startPosition
     *
     * @return Domain
     */
    public function setStartPosition($startPosition)
    {
        $this->start_position = $startPosition;

        return $this;
    }

    /**
     * Get startPosition
     *
     * @return string
     */
    public function getStartPosition()
    {
        return $this->start_position;
    }

    /**
     * Set endPosition
     *
     * @param string $endPosition
     *
     * @return Domain
     */
    public function setEndPosition($endPosition)
    {
        $this->end_position = $endPosition;

        return $this;
    }

    /**
     * Get endPosition
     *
     * @return string
     */
    public function getEndPosition()
    {
        return $this->end_position;
    }
    

}
