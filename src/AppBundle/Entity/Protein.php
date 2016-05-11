<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`protein`")
 */
class Protein
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="interaction" , inversedBy="proteins")
	 * @ORM\JoinTable(name="interaction_protein",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
	 *      	},
     *      inverseJoinColumns={
     *      		@ORM\JoinColumn(name="protein_id", referencedColumnName="id")
     *      	}
     * 		)
	 */
	private $interactions;
	
	/**
	 * @ORM\ManyToMany(targetEntity="domain" , inversedBy="proteins")
	 * @ORM\JoinTable(name="domain_protein",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="domain_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="protein_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	private $domains;
	
	public function __construct() {
		$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
		$this->domains = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $sequence;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $gene_name;
	
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
     * @return Protein
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
     * Set sequence
     *
     * @param string $sequence
     * @return Protein
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
     * Set gene_name
     *
     * @param string $geneName
     * @return Protein
     */
    public function setGeneName($geneName)
    {
        $this->gene_name = $geneName;

        return $this;
    }

    /**
     * Get gene_name
     *
     * @return string 
     */
    public function getGeneName()
    {
        return $this->gene_name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Protein
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
