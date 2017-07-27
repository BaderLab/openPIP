<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`identifier`")
 */
class Identifier
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	
	/**
	 * @ORM\ManyToMany(targetEntity="Protein", inversedBy="identifiers")
	 * @ORM\JoinTable(name="protein_identifier",
	 *      joinColumns={@ORM\JoinColumn(name="identifier_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="protein_id", referencedColumnName="id")}
	 *      )
	 */
	protected $proteins;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $identifier;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $naming_convention;
	
	public function __construct() {
		$this->proteins = new \Doctrine\Common\Collections\ArrayCollection();
	
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
     * Set identifier
     *
     * @param string $identifier
     * @return Identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set naming_convention
     *
     * @param string $namingConvention
     * @return Identifier
     */
    public function setNamingConvention($namingConvention)
    {
        $this->naming_convention = $namingConvention;

        return $this;
    }

    /**
     * Get naming_convention
     *
     * @return string 
     */
    public function getNamingConvention()
    {
        return $this->naming_convention;
    }

    /**
     * Set protein
     *
     * @param \AppBundle\Entity\Protein $protein
     * @return Identifier
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
     * Add protein
     *
     * @param \AppBundle\Entity\Protein $protein
     *
     * @return Identifier
     */
    public function addProtein(\AppBundle\Entity\Protein $protein)
    {
        $this->proteins[] = $protein;

        return $this;
    }

    /**
     * Remove protein
     *
     * @param \AppBundle\Entity\Protein $protein
     */
    public function removeProtein(\AppBundle\Entity\Protein $protein)
    {
        $this->proteins->removeElement($protein);
    }

    /**
     * Get proteins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProteins()
    {
        return $this->proteins;
    }
}
