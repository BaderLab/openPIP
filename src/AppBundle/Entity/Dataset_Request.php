<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`dataset_request`")
 */
class Dataset_Request
{
	
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $email;
	
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $md5;
	
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $request;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $date;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Dataset[]
	 * @ORM\ManyToMany(targetEntity="Dataset", mappedBy="dataset_requests")
	 */
	private $datasets;
	
	public function __construct() {
	    $this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return Dataset_Request
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set request
     *
     * @param string $request
     *
     * @return Dataset_Request
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set md5
     *
     * @param string $md5
     *
     * @return Dataset_Request
     */
    public function setMd5($md5)
    {
        $this->md5 = $md5;

        return $this;
    }

    /**
     * Get md5
     *
     * @return string
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * Add dataset
     *
     * @param \AppBundle\Entity\Dataset $dataset
     *
     * @return Dataset_Request
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Dataset_Request
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
