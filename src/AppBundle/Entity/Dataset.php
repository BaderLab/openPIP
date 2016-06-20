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
	 *      		@ORM\JoinColumn(name="dataset_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	public $interactions;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Data_File" , inversedBy="datasets")
	 * @ORM\JoinTable(name="dataset_data_file",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="data_file_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="dataset_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	public $data_files;
	
	public function __construct() {
		$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
		$this->data_files = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $reference;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
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
     * Add data_files
     *
     * @param \AppBundle\Entity\Data_File $data_files
     * @return Dataset
     */
    public function addDataFile(\AppBundle\Entity\Data_File $data_files)
    {
        $this->data_files[] = $data_files;

        return $this;
    }

    /**
     * Remove data_files
     *
     * @param \AppBundle\Entity\Data_File $data_files
     */
    public function removeDataFile(\AppBundle\Entity\Data_File $data_files)
    {
        $this->data_files->removeElement($data_files);
    }

    /**
     * Get data_files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDataFiles()
    {
        return $this->data_files;
    }
}
