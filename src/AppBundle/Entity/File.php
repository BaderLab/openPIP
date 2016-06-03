<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="`file`")
 */
class File
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Domain" , inversedBy="files")
	 * @ORM\JoinTable(name="domain_file",
	 *      joinColumns={
	 *      		@ORM\JoinColumn(name="domain_id", referencedColumnName="id")
	 *      	},
	 *      inverseJoinColumns={
	 *      		@ORM\JoinColumn(name="file_id", referencedColumnName="id")
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
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;
	

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
     * @return File
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

    
    public function getAbsolutePath()
    {
    	return null === $this->path
    	? null
    	: $this->getUploadRootDir().'/'.$this->path;
    }
    
    public function getWebPath()
    {
    	return null === $this->path
    	? null
    	: $this->getUploadDir().'/'.$this->path;
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
    
    
    
    /**
     * Set method
     *
     * @param string $method
     * @return File
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
     * @return File
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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
    	$this->file = $file;
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
    	return $this->file;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
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
     * Add domains
     *
     * @param \AppBundle\Entity\Domain $domains
     * @return File
     */
    public function addDomain(\AppBundle\Entity\Domain $domains)
    {
        $this->domains[] = $domains;

        return $this;
    }

    /**
     * Remove domains
     *
     * @param \AppBundle\Entity\Domain $domains
     */
    public function removeDomain(\AppBundle\Entity\Domain $domains)
    {
        $this->domains->removeElement($domains);
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
     * Add datasets
     *
     * @param \AppBundle\Entity\Dataset $datasets
     * @return File
     */
    public function addDataset(\AppBundle\Entity\Dataset $datasets)
    {
        $this->datasets[] = $datasets;

        return $this;
    }

    /**
     * Remove datasets
     *
     * @param \AppBundle\Entity\Dataset $datasets
     */
    public function removeDataset(\AppBundle\Entity\Dataset $datasets)
    {
        $this->datasets->removeElement($datasets);
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
}
