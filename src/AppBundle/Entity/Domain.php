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
	 * @ORM\ManyToMany(targetEntity="Interaction", inversedBy="domains")
	 * @ORM\JoinTable(name="interaction_domain",
	 *      joinColumns={@ORM\JoinColumn(name="domain_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")}
	 *      )
	 */
	protected $interactions;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Organism[]
	 * @ORM\ManyToMany(targetEntity="Organism", mappedBy="domains")
	 */
	protected $organisms;
	
    /**
     * @ORM\ManyToOne(targetEntity="Protein", inversedBy="domains")
     * @ORM\JoinColumn(name="protein_id", referencedColumnName="id")
     */
	protected $protein;
	
	public function __construct() {

		$this->data_files = new \Doctrine\Common\Collections\ArrayCollection();
		$this->organisms = new \Doctrine\Common\Collections\ArrayCollection();
		$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $type;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $start_position;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $end_position;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(type="string", length=1000, nullable=true)
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
     *
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
     *
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

    /**
     * Set description
     *
     * @param string $description
     *
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
     *
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
     * Set interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     *
     * @return Domain
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
     * Add organism
     *
     * @param \AppBundle\Entity\Organism $organism
     *
     * @return Domain
     */
    public function addOrganism(\AppBundle\Entity\Organism $organism)
    {
        $this->organisms[] = $organism;

        return $this;
    }

    /**
     * Remove organism
     *
     * @param \AppBundle\Entity\Organism $organism
     */
    public function removeOrganism(\AppBundle\Entity\Organism $organism)
    {
        $this->organisms->removeElement($organism);
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
     *
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
}
