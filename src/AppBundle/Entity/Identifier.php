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
     * @ORM\ManyToOne(targetEntity="Protein", inversedBy="identifiers")
     * @ORM\JoinColumn(name="protein_id", referencedColumnName="id")
     */
	protected $protein;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $identifier;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $naming_convention;
	
	

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
}
