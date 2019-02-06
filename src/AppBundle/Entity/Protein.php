<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`protein`")
 */
class Protein
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	public $id;
	

	
	/**
	 * @ORM\ManyToMany(targetEntity="Protein", mappedBy="isoforms")
	 */
	private $proteins;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Protein", inversedBy="proteins")
	 * @ORM\JoinTable(name="protein_isoform",
	 *      joinColumns={@ORM\JoinColumn(name="protein_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="isoform_id", referencedColumnName="id")}
	 *      )
	 */
	private $isoforms;
	
	
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Organism[]
     * @ORM\ManyToMany(targetEntity="Organism", mappedBy="proteins")
     */
	public $organisms;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Identifier[]
	 * @ORM\ManyToMany(targetEntity="Annotation", mappedBy="proteins")
	 */
	public $annotations;
	
   /**
     * @ORM\OneToMany(targetEntity="Domain", mappedBy="protein")
     */
	public $domains;
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|Identifier[]
	 * @ORM\ManyToMany(targetEntity="Identifier", mappedBy="proteins")
	 */
    public $identifiers;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Identifier[]
     * @ORM\ManyToMany(targetEntity="Complex", mappedBy="proteins")
     */
    public $complexes;
	
   /**
     * @ORM\OneToMany(targetEntity="Interaction", mappedBy="protein")
     */
    public $interactions;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="External_Link", mappedBy="protein", cascade={"persist"})
     */
    public $external_links;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="User" , inversedBy="proteins")
     * @ORM\JoinTable(name="user_protein",
     *      joinColumns={
     *      		@ORM\JoinColumn(name="protein_id", referencedColumnName="id")
     *      	},
     *      inverseJoinColumns={
     *      		@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *      	}
     * 		)
     */
    public $users;
    
    
	public function __construct() {
		$this->users= new \Doctrine\Common\Collections\ArrayCollection();
		$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
		$this->domains = new \Doctrine\Common\Collections\ArrayCollection();
		$this->identifiers = new \Doctrine\Common\Collections\ArrayCollection();
		$this->organisms = new \Doctrine\Common\Collections\ArrayCollection();
		$this->external_links = new \Doctrine\Common\Collections\ArrayCollection();
		$this->isoforms = new \Doctrine\Common\Collections\ArrayCollection();
		$this->complexes= new \Doctrine\Common\Collections\ArrayCollection();
		$this->annotations = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $uniprot_id;
	
	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $protein_name;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $ensembl_id;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $entrez_id;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $gene_name;
	
	/**
	 * @ORM\Column(type="string", length=10000, nullable=true)
	 */
	protected $sequence;
	
	
	/**
	 * @ORM\Column(type="string", length=10000, nullable=true)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(type="string", length=10, nullable=true)
	 */
	protected $number_of_interactions_in_database;

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
     * Set uniprotId
     *
     * @param string $uniprotId
     *
     * @return Protein
     */
    public function setUniprotId($uniprotId)
    {
        $this->uniprot_id = $uniprotId;

        return $this;
    }

    /**
     * Get uniprotId
     *
     * @return string
     */
    public function getUniprotId()
    {
        return $this->uniprot_id;
    }
    
    /**
     * Set uniprotIdCorrect
     *
     * @param string $uniprotId
     *
     * @return Protein
     */
    public function setUniprotIdCorrect($uniprotIdCorrect)
    {
        $this->uniprot_id_correct = $uniprotIdCorrect;
        
        return $this;
    }
    
    /**
     * Get uniprotIdCorrect
     *
     * @return string
     */
    public function getUniprotIdCorrect()
    {
        return $this->uniprot_id_correct;
    }
    

    /**
     * Set ensemblId
     *
     * @param string $ensemblId
     *
     * @return Protein
     */
    public function setEnsemblId($ensemblId)
    {
        $this->ensembl_id = $ensemblId;

        return $this;
    }

    /**
     * Get ensemblId
     *
     * @return string
     */
    public function getEnsemblId()
    {
        return $this->ensembl_id;
    }

    /**
     * Set entrezId
     *
     * @param string $entrezId
     *
     * @return Protein
     */
    public function setEntrezId($entrezId)
    {
        $this->entrez_id = $entrezId;

        return $this;
    }

    /**
     * Get entrezId
     *
     * @return string
     */
    public function getEntrezId()
    {
        return $this->entrez_id;
    }

    /**
     * Set geneName
     *
     * @param string $geneName
     *
     * @return Protein
     */
    public function setGeneName($geneName)
    {
        $this->gene_name = $geneName;

        return $this;
    }

    /**
     * Get geneName
     *
     * @return string
     */
    public function getGeneName()
    {
        return $this->gene_name;
    }

    /**
     * Set sequence
     *
     * @param string $sequence
     *
     * @return Protein
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Protein
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
     * Get number_of_interactions_in_database
     *
     * @return string
     */
    public function getNumberOfInteractionsInDatabase()
    {
        return $this->number_of_interactions_in_database;
    }
    
    /**
     * Set number_of_interactions_in_database
     *
     * @param string $number_of_interactions_in_database
     *
     * @return Protein
     */
    public function setNumberOfInteractionsInDatabase($number_of_interactions_in_database)
    {
        $this->number_of_interactions_in_database = $number_of_interactions_in_database;
        
        return $this;
    }
    
    /**
     * Add protein
     *
     * @param \AppBundle\Entity\Protein $protein
     *
     * @return Protein
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
     * Add isoform
     *
     * @param \AppBundle\Entity\Protein $isoform
     *
     * @return Protein
     */
    public function addIsoform(\AppBundle\Entity\Protein $isoform)
    {
        $this->isoforms[] = $isoform;

        return $this;
    }

    /**
     * Remove isoform
     *
     * @param \AppBundle\Entity\Protein $isoform
     */
    public function removeIsoform(\AppBundle\Entity\Protein $isoform)
    {
        $this->isoforms->removeElement($isoform);
    }

    /**
     * Get isoforms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIsoforms()
    {
        return $this->isoforms;
    }

    /**
     * Add organism
     *
     * @param \AppBundle\Entity\Organism $organism
     *
     * @return Protein
     */
    public function addOrganism(\AppBundle\Entity\Organism $organism)
    {
        $this->organisms[] = $organism;

        return $this;
    }

    /**
     * Remove organism
     *
     * @param \AppBundle\Entity\Organism $organism
     */
    public function removeOrganism(\AppBundle\Entity\Organism $organism)
    {
        $this->organisms->removeElement($organism);
    }

    /**
     * Get organisms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrganisms()
    {
        return $this->organisms;
    }

    /**
     * Add annotation
     *
     * @param \AppBundle\Entity\Annotation $annotation
     *
     * @return Protein
     */
    public function addAnnotation(\AppBundle\Entity\Annotation $annotation)
    {
        $this->annotations[] = $annotation;

        return $this;
    }

    /**
     * Remove annotation
     *
     * @param \AppBundle\Entity\Annotation $annotation
     */
    public function removeAnnotation(\AppBundle\Entity\Annotation $annotation)
    {
        $this->annotations->removeElement($annotation);
    }

    /**
     * Get annotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * Add domain
     *
     * @param \AppBundle\Entity\Domain $domain
     *
     * @return Protein
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
     * Add identifier
     *
     * @param \AppBundle\Entity\Identifier $identifier
     *
     * @return Protein
     */
    public function addIdentifier(\AppBundle\Entity\Identifier $identifier)
    {
        $this->identifiers[] = $identifier;

        return $this;
    }

    /**
     * Remove identifier
     *
     * @param \AppBundle\Entity\Identifier $identifier
     */
    public function removeIdentifier(\AppBundle\Entity\Identifier $identifier)
    {
        $this->identifiers->removeElement($identifier);
    }

    /**
     * Get identifiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdentifiers()
    {
        return $this->identifiers;
    }

    /**
     * Add complex
     *
     * @param \AppBundle\Entity\Complex $complex
     *
     * @return Protein
     */
    public function addComplex(\AppBundle\Entity\Complex $complex)
    {
        $this->complexes[] = $complex;

        return $this;
    }

    /**
     * Remove complex
     *
     * @param \AppBundle\Entity\Complex $complex
     */
    public function removeComplex(\AppBundle\Entity\Complex $complex)
    {
        $this->complexes->removeElement($complex);
    }

    /**
     * Get complexes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComplexes()
    {
        return $this->complexes;
    }

    /**
     * Add interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     *
     * @return Protein
     */
    public function addInteraction(\AppBundle\Entity\Interaction $interaction)
    {
        $this->interactions[] = $interaction;

        return $this;
    }

    /**
     * Remove interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
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
     * Add externalLink
     *
     * @param \AppBundle\Entity\External_Link $externalLink
     *
     * @return Protein
     */
    public function addExternalLink(\AppBundle\Entity\External_Link $externalLink)
    {
        $this->external_links[] = $externalLink;

        return $this;
    }

    /**
     * Remove externalLink
     *
     * @param \AppBundle\Entity\External_Link $externalLink
     */
    public function removeExternalLink(\AppBundle\Entity\External_Link $externalLink)
    {
        $this->external_links->removeElement($externalLink);
    }

    /**
     * Get externalLinks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExternalLinks()
    {
        return $this->external_links;
    }



    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Protein
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
