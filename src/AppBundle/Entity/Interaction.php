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
	 * @ORM\OneToMany(targetEntity="Interaction_Support_Information", mappedBy="interaction")
	 */
	private $interaction_support_informations;
	
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Dataset[]
     * @ORM\ManyToMany(targetEntity="Dataset", mappedBy="interactions")
     */
    private $datasets;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Interaction_Category[]
     * @ORM\ManyToMany(targetEntity="Interaction_Category", mappedBy="interactions")
     */
    private $interaction_categories;
    
   /**
    * @var \Doctrine\Common\Collections\ArrayCollection|Interaction_Network[]
    * @ORM\ManyToMany(targetEntity="Interaction_Network", mappedBy="interactions")
    */
    private $interaction_networks;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Interaction", inversedBy="domains")
     * @ORM\JoinTable(name="interaction_domain",
     *      joinColumns={@ORM\JoinColumn(name="domain_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")}
     *      )
     */
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Domain[]
     * @ORM\ManyToMany(targetEntity="Domain", mappedBy="interactions")
     */
    protected $domains;
    
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
    
    /**
     * @ORM\OneToMany(targetEntity="Experiment", mappedBy="interaction")
     * @ORM\JoinColumn(name="experiment_id", referencedColumnName="id")
     */
    protected $experiments;

    
    public function __construct()
    {
    	
    	$this->interaction_networks = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->interaction_categories= new \Doctrine\Common\Collections\ArrayCollection();
    	$this->interaction_support_informations = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->experiments= new \Doctrine\Common\Collections\ArrayCollection();
    	$this->domains= new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $score;
    
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $binding_start;
    
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
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
     * @param string $score
     *
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
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set bindingStart
     *
     * @param string $bindingStart
     *
     * @return Interaction
     */
    public function setBindingStart($bindingStart)
    {
        $this->binding_start = $bindingStart;

        return $this;
    }

    /**
     * Get bindingStart
     *
     * @return string
     */
    public function getBindingStart()
    {
        return $this->binding_start;
    }

    /**
     * Set bindingEnd
     *
     * @param string $bindingEnd
     *
     * @return Interaction
     */
    public function setBindingEnd($bindingEnd)
    {
        $this->binding_end = $bindingEnd;

        return $this;
    }

    /**
     * Get bindingEnd
     *
     * @return string
     */
    public function getBindingEnd()
    {
        return $this->binding_end;
    }

    /**
     * Add interactionSupportInformation
     *
     * @param \AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation
     *
     * @return Interaction
     */
    public function addInteractionSupportInformation(\AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation)
    {
        $this->interaction_support_informations[] = $interactionSupportInformation;

        return $this;
    }

    /**
     * Remove interactionSupportInformation
     *
     * @param \AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation
     */
    public function removeInteractionSupportInformation(\AppBundle\Entity\Interaction_Support_Information $interactionSupportInformation)
    {
        $this->interaction_support_informations->removeElement($interactionSupportInformation);
    }

    /**
     * Get interactionSupportInformations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInteractionSupportInformations()
    {
        return $this->interaction_support_informations;
    }

    /**
     * Add dataset
     *
     * @param \AppBundle\Entity\Dataset $dataset
     *
     * @return Interaction
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
     * Add interactionCategory
     *
     * @param \AppBundle\Entity\Interaction_Category $interactionCategory
     *
     * @return Interaction
     */
    public function addInteractionCategory(\AppBundle\Entity\Interaction_Category $interactionCategory)
    {
        $this->interaction_categories[] = $interactionCategory;

        return $this;
    }

    /**
     * Remove interactionCategory
     *
     * @param \AppBundle\Entity\Interaction_Category $interactionCategory
     */
    public function removeInteractionCategory(\AppBundle\Entity\Interaction_Category $interactionCategory)
    {
        $this->interaction_categories->removeElement($interactionCategory);
    }

    /**
     * Get interactionCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInteractionCategories()
    {
        return $this->interaction_categories;
    }

    /**
     * Add interactionNetwork
     *
     * @param \AppBundle\Entity\Interaction_Network $interactionNetwork
     *
     * @return Interaction
     */
    public function addInteractionNetwork(\AppBundle\Entity\Interaction_Network $interactionNetwork)
    {
        $this->interaction_networks[] = $interactionNetwork;

        return $this;
    }

    /**
     * Remove interactionNetwork
     *
     * @param \AppBundle\Entity\Interaction_Network $interactionNetwork
     */
    public function removeInteractionNetwork(\AppBundle\Entity\Interaction_Network $interactionNetwork)
    {
        $this->interaction_networks->removeElement($interactionNetwork);
    }

    /**
     * Get interactionNetworks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInteractionNetworks()
    {
        return $this->interaction_networks;
    }

    /**
     * Add domain
     *
     * @param \AppBundle\Entity\Domain $domain
     *
     * @return Interaction
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
     * Add experiment
     *
     * @param \AppBundle\Entity\Experiment $experiment
     *
     * @return Interaction
     */
    public function addExperiment(\AppBundle\Entity\Experiment $experiment)
    {
        $this->experiments[] = $experiment;

        return $this;
    }

    /**
     * Remove experiment
     *
     * @param \AppBundle\Entity\Experiment $experiment
     */
    public function removeExperiment(\AppBundle\Entity\Experiment $experiment)
    {
        $this->experiments->removeElement($experiment);
    }

    /**
     * Get experiments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExperiments()
    {
        return $this->experiments;
    }
}
