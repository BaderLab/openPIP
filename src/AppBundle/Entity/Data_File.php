<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="`data_file`")
 */
class Data_File
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Domain" , inversedBy="data_files")
	 * @ORM\JoinTable(name="domain_data_file",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="domain_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="data_file_id", referencedColumnName="id")
	 *      	}
	 * 		)
	 */
	public $domains;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Dataset[]
	 * @ORM\ManyToMany(targetEntity="Dataset", mappedBy="files")
	 */
	public $datasets;
	
	public function __construct()
	{
		$this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
		$this->domains = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * @ORM\Column(type="string", length=1000, nullable=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $path;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $method;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $file_type;

	/**
	 * @Assert\File(maxSize="200000000")
	 */
	private $data_file;

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
     *
     * @return Data_File
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
     * Set path
     *
     * @param string $path
     *
     * @return Data_File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set method
     *
     * @param string $method
     *
     * @return Data_File
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Data_File
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
    
    public function getDataFile()
    {
    	return $this->data_file;
    }
    
    public function setDataFile($data_file)
    {
    	$this->data_file = $data_file;
    
    	return $this;
    }

    protected function getUploadRootDir()
    {
    	// the absolute directory path where uploaded
    	// documents should be saved
    	return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	// get rid of the __DIR__ so it doesn't screw up
    	// when displaying uploaded doc/image in the view.
    	return 'uploads';
    }
    
    public function upload()
    {
    	// the file property can be empty if the field is not required
    	if (null === $this->getFile()) {
    		return;
    	}
    
    	// use the original file name here but you should
    	// sanitize it at least to avoid any security issues
    
    	// move takes the target directory and then the
    	// target filename to move to
    	$this->getFile()->move(
    			$this->getUploadRootDir(),
    			$this->getFile()->getClientOriginalName()
    			);
    
    	// set the path property to the filename where you've saved the file
    	$this->path = $this->getFile()->getClientOriginalName();
    	$this->name = $this->getUploadRootDir();
    	// clean up the file property as you won't need it anymore
    	$this->file = null;
    }
    

    /**
     * Add domain
     *
     * @param \AppBundle\Entity\Domain $domain
     *
     * @return Data_File
     */
    public function addDomain(\AppBundle\Entity\Domain $domain)
    {
        $this->domains[] = $domain;

        return $this;
    }

    /**
     * Remove domain
     *
     * @param \AppBundle\Entity\Domain $domain
     */
    public function removeDomain(\AppBundle\Entity\Domain $domain)
    {
        $this->domains->removeElement($domain);
    }

    /**
     * Get domains
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Add dataset
     *
     * @param \AppBundle\Entity\Dataset $dataset
     *
     * @return Data_File
     */
    public function addDataset(\AppBundle\Entity\Dataset $dataset)
    {
        $this->datasets[] = $dataset;

        return $this;
    }

    /**
     * Remove dataset
     *
     * @param \AppBundle\Entity\Dataset $dataset
     */
    public function removeDataset(\AppBundle\Entity\Dataset $dataset)
    {
        $this->datasets->removeElement($dataset);
    }

    /**
     * Get datasets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDatasets()
    {
        return $this->datasets;
    }

    /**
     * Set fileType
     *
     * @param string $fileType
     *
     * @return Data_File
     */
    public function setFileType($fileType)
    {
        $this->file_type = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string
     */
    public function getFileType()
    {
        return $this->file_type;
    }
}
