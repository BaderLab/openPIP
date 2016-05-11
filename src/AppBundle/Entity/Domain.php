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
	 * @ORM\ManyToMany(targetEntity="interaction" , inversedBy="domains")
	 * @ORM\JoinTable(name="interaction_domain",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="domain_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	private $interactions;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|File[]
	 * @ORM\ManyToMany(targetEntity="File", mappedBy="domains")
	 */
	private $files;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Organism[]
	 * @ORM\ManyToMany(targetEntity="Organism", mappedBy="domains")
	 */
	private $organisms;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Protein[]
	 * @ORM\ManyToMany(targetEntity="Protein", mappedBy="domains")
	 */
	private $proteins;
	
	public function __construct() {
		$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
		$this->files = new \Doctrine\Common\Collections\ArrayCollection();
		$this->organisms = new \Doctrine\Common\Collections\ArrayCollection();
		$this->proteins = new \Doctrine\Common\Collections\ArrayCollection();
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
	protected $start;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $end;
	
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
}
