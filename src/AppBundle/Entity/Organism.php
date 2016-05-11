<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`organism`")
 */
class Organism
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Domain" , inversedBy="organisms")
	 * @ORM\JoinTable(name="domain_organism",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="domain_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="organism_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	private $domains;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Master_Table" , inversedBy="organisms")
	 * @ORM\JoinTable(name="master_table_organism",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="master_table_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="organism_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	private $master_tables;
	
	public function __construct() {
		$this->domains = new \Doctrine\Common\Collections\ArrayCollection();
		$this->master_tables = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $class;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $scientfic_name;
	
	/**
	 * @ORM\Column(type="string", length=100)
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
     * @return Organism
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
     * Set class
     *
     * @param string $class
     * @return Organism
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set scientfic_name
     *
     * @param string $scientficName
     * @return Organism
     */
    public function setScientficName($scientficName)
    {
        $this->scientfic_name = $scientficName;

        return $this;
    }

    /**
     * Get scientfic_name
     *
     * @return string 
     */
    public function getScientficName()
    {
        return $this->scientfic_name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Organism
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
}
