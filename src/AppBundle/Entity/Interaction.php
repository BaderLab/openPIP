<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`interaction`")
 */
class Interaction
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;


	
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Support_Information[]
     * @ORM\ManyToMany(targetEntity="Support_Information", mappedBy="interactions")
     */
    private $support_informations;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Protein[]
     * @ORM\ManyToMany(targetEntity="Protein", mappedBy="interactions")
     */
    private $proteins;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Dataset[]
     * @ORM\ManyToMany(targetEntity="Dataset", mappedBy="interactions")
     */
    private $datasets;
    
    /**
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="interactions")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     */
    private $domains;
    
    public function __construct()
    {
    	$this->proteins = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->support_informations = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->domains = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
	/**
	 * @ORM\Column(type="integer", length=100)
	 */
	protected $score;
	
	/**
	 * @ORM\Column(type="integer", length=100)
	 */
	protected $binding_start;
	
	/**
	 * @ORM\Column(type="integer", length=100)
	 */
	protected $binding_end;

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
     * Set protein_id_1
     *
     * @param integer $proteinId1
     * @return Interaction
     */
    public function setProteinId1($proteinId1)
    {
        $this->protein_id_1 = $proteinId1;

        return $this;
    }

    /**
     * Get protein_id_1
     *
     * @return integer 
     */
    public function getProteinId1()
    {
        return $this->protein_id_1;
    }

    /**
     * Set protein_id_2
     *
     * @param integer $proteinId2
     * @return Interaction
     */
    public function setProteinId2($proteinId2)
    {
        $this->protein_id_2 = $proteinId2;

        return $this;
    }

    /**
     * Get protein_id_2
     *
     * @return integer 
     */
    public function getProteinId2()
    {
        return $this->protein_id_2;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Interaction
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set binding_start
     *
     * @param integer $bindingStart
     * @return Interaction
     */
    public function setBindingStart($bindingStart)
    {
        $this->binding_start = $bindingStart;

        return $this;
    }

    /**
     * Get binding_start
     *
     * @return integer 
     */
    public function getBindingStart()
    {
        return $this->binding_start;
    }

    /**
     * Set binding_end
     *
     * @param integer $bindingEnd
     * @return Interaction
     */
    public function setBindingEnd($bindingEnd)
    {
        $this->binding_end = $bindingEnd;

        return $this;
    }

    /**
     * Get binding_end
     *
     * @return integer 
     */
    public function getBindingEnd()
    {
        return $this->binding_end;
    }

    /**
     * Add support_informations
     *
     * @param \AppBundle\Entity\Support_Information $supportInformations
     * @return Interaction
     */
    public function addSupportInformation(\AppBundle\Entity\Support_Information $supportInformations)
    {
        $this->support_informations[] = $supportInformations;

        return $this;
    }

    /**
     * Remove support_informations
     *
     * @param \AppBundle\Entity\Support_Information $supportInformations
     */
    public function removeSupportInformation(\AppBundle\Entity\Support_Information $supportInformations)
    {
        $this->support_informations->removeElement($supportInformations);
    }

    /**
     * Get support_informations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupportInformations()
    {
        return $this->support_informations;
    }

    /**
     * Add proteins
     *
     * @param \AppBundle\Entity\Protein $proteins
     * @return Interaction
     */
    public function addProtein(\AppBundle\Entity\Protein $proteins)
    {
        $this->proteins[] = $proteins;

        return $this;
    }

    /**
     * Remove proteins
     *
     * @param \AppBundle\Entity\Protein $proteins
     */
    public function removeProtein(\AppBundle\Entity\Protein $proteins)
    {
        $this->proteins->removeElement($proteins);
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
     * Add datasets
     *
     * @param \AppBundle\Entity\Dataset $datasets
     * @return Interaction
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

    /**
     * Set domains
     *
     * @param \AppBundle\Entity\Domain $domains
     * @return Interaction
     */
    public function setDomains(\AppBundle\Entity\Domain $domains = null)
    {
        $this->domains = $domains;

        return $this;
    }

    /**
     * Get domains
     *
     * @return \AppBundle\Entity\Domain 
     */
    public function getDomains()
    {
        return $this->domains;
    }
}
