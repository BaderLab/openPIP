<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`dataset`")
 */
class Dataset
{
	
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToMany(targetEntity="Interaction" , inversedBy="datasets")
	 * @ORM\JoinTable(name="interaction_dataset",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="dataset_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	private $interactions;
	
	/**
	 * @ORM\ManyToMany(targetEntity="File" , inversedBy="datasets")
	 * @ORM\JoinTable(name="dataset_file",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="files_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="dataset_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	private $files;
	
	public function __construct() {
		$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
		$this->files = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $reference;
	
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
     * @return Dataset
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
     * Set reference
     *
     * @param string $reference
     * @return Dataset
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Dataset
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
     * Add interactions
     *
     * @param \AppBundle\Entity\Interaction $interactions
     * @return Dataset
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
     * Add files
     *
     * @param \AppBundle\Entity\File $files
     * @return Dataset
     */
    public function addFile(\AppBundle\Entity\File $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files
     *
     * @param \AppBundle\Entity\File $files
     */
    public function removeFile(\AppBundle\Entity\File $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }
}
