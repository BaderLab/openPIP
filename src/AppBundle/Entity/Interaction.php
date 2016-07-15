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
     * @var \Doctrine\Common\Collections\ArrayCollection|Dataset[]
     * @ORM\ManyToMany(targetEntity="Dataset", mappedBy="interactions")
     */
    private $datasets;
    
    /**
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="interactions")
     * @ORM\JoinColumn(name="domain", referencedColumnName="id")
     */
    protected $domain;
    
    /**
     * @ORM\ManyToOne(targetEntity="Protein", inversedBy="interactions")
     * @ORM\JoinColumn(name="interactor_A", referencedColumnName="id")
     */
    protected $interactor_A;
    
    /**
     * @ORM\ManyToOne(targetEntity="Protein", inversedBy="interactions")
     * @ORM\JoinColumn(name="interactor_B", referencedColumnName="id")
     */
    protected $interactor_B;
    

    
    public function __construct()
    {
    	$this->support_informations = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->datasets = new \Doctrine\Common\Collections\ArrayCollection();

    }
    
	/**
	 * @ORM\Column(type="float", length=100, nullable=true)
	 */
	protected $score;
	
	/**
	 * @ORM\Column(type="integer", length=100, nullable=true)
	 */
	protected $binding_start;
	
	/**
	 * @ORM\Column(type="integer", length=100, nullable=true)
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
     * @return double 
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
     * Set interactorA
     *
     * @param \AppBundle\Entity\Protein $interactorA
     *
     * @return Interaction
     */
    public function setInteractorA(\AppBundle\Entity\Protein $interactorA = null)
    {
        $this->interactor_A = $interactorA;

        return $this;
    }

    /**
     * Get interactorA
     *
     * @return \AppBundle\Entity\Protein
     */
    public function getInteractorA()
    {
        return $this->interactor_A;
    }

    /**
     * Set interactorB
     *
     * @param \AppBundle\Entity\Protein $interactorB
     *
     * @return Interaction
     */
    public function setInteractorB(\AppBundle\Entity\Protein $interactorB = null)
    {
        $this->interactor_B = $interactorB;

        return $this;
    }

    /**
     * Get interactorB
     *
     * @return \AppBundle\Entity\Protein
     */
    public function getInteractorB()
    {
        return $this->interactor_B;
    }

    /**
     * Set domain
     *
     * @param \AppBundle\Entity\Domain $domain
     *
     * @return Interaction
     */
    public function setDomain(\AppBundle\Entity\Domain $domain = null)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \AppBundle\Entity\Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
