<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`annotation`")
 */
class Annotation
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	
	/**
	 * @ORM\ManyToMany(targetEntity="Protein" , inversedBy="annotations")
	 * @ORM\JoinTable(name="annotation_protein",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="annotation_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="protein_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	protected $proteins;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Interaction" , inversedBy="annotations")
	 * @ORM\JoinTable(name="annotation_interaction",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="annotation_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	protected $interactions;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $identifier;

	/**
	 * @ORM\Column(type="string", length=5000, nullable=true)
	 */
	protected $annotation;
	
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $type_name;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Annotation_Type", inversedBy="annotations")
	 * @ORM\JoinColumn(name="annotation_type", referencedColumnName="id")
	 */
	protected $annotation_type;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->proteins = new \Doctrine\Common\Collections\ArrayCollection();
        $this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set annotation
     *
     * @param string $annotation
     *
     * @return Annotation
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * Get annotation
     *
     * @return string
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * Add protein
     *
     * @param \AppBundle\Entity\Protein $protein
     *
     * @return Annotation
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

    /**
     * Add interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     *
     * @return Annotation
     */
    public function addInteraction(\AppBundle\Entity\Interaction $interaction)
    {
        $this->interactions[] = $interaction;
        
        return $this;
    }
    
    /**
     * Remove interaction
     *
     * @param \AppBundle\Entity\Protein $interaction
     */
    public function removeInteraction(\AppBundle\Entity\Interaction $interaction)
    {
        $this->interactions->removeElement($interaction);
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
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Annotation
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
     * Set annotationType
     *
     * @param \AppBundle\Entity\Annotation_Type $annotationType
     *
     * @return Annotation
     */
    public function setAnnotationType(\AppBundle\Entity\Annotation_Type $annotationType = null)
    {
        $this->annotation_type = $annotationType;

        return $this;
    }

    /**
     * Get annotationType
     *
     * @return \AppBundle\Entity\Annotation_Type
     */
    public function getAnnotationType()
    {
        return $this->annotation_type;
    }

    /**
     * Set typeName
     *
     * @param string $typeName
     *
     * @return Annotation
     */
    public function setTypeName($typeName)
    {
        $this->type_name = $typeName;

        return $this;
    }

    /**
     * Get typeName
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->type_name;
    }
}
