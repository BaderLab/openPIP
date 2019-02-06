<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`interaction_network`")
 */
class Interaction_Network
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;


    
    /**
     * @ORM\ManyToMany(targetEntity="Interaction" , inversedBy="interaction_networks")
     * @ORM\JoinTable(name="interaction_interaction_networks",
     *      joinColumns={
     *      		@ORM\JoinColumn(name="interaction_network_id", referencedColumnName="id")
     *      	},
     *      inverseJoinColumns={
     *      		@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
     *      	}
     * 		)
     */
    private $interactions;
    
    /**
     * @ORM\ManyToMany(targetEntity="User" , inversedBy="interaction_networks")
     * @ORM\JoinTable(name="user_interaction_networks",
     *      joinColumns={
     *      		@ORM\JoinColumn(name="interaction_network_id", referencedColumnName="id")
     *      	},
     *      inverseJoinColumns={
     *      		@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *      	}
     * 		)
     */
    private $users;
    
  
    

    public function __construct()
    {
    	$this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->users = new \Doctrine\Common\Collections\ArrayCollection();


    }
    
    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $interactor_query_string;
    
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */    
    protected $score_parameter;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */     
    protected $category_array;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */   
    protected $tissue_expression_array;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $query;
    

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
     * Add interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     *
     * @return Interaction
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
     * Add user
     *
     * @param \AppBundle\Entity\Users $user
     *
     * @return Interaction_Network
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

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Interaction_Network
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
     * Set interactorQueryString
     *
     * @param string $interactorQueryString
     *
     * @return Interaction_Network
     */
    public function setInteractorQueryString($interactorQueryString)
    {
        $this->interactor_query_string = $interactorQueryString;

        return $this;
    }

    /**
     * Get interactorQueryString
     *
     * @return string
     */
    public function getInteractorQueryString()
    {
        return $this->interactor_query_string;
    }

    /**
     * Set scoreParameter
     *
     * @param string $scoreParameter
     *
     * @return Interaction_Network
     */
    public function setScoreParameter($scoreParameter)
    {
        $this->score_parameter = $scoreParameter;

        return $this;
    }

    /**
     * Get scoreParameter
     *
     * @return string
     */
    public function getScoreParameter()
    {
        return $this->score_parameter;
    }

    /**
     * Set categoryArray
     *
     * @param string $categoryArray
     *
     * @return Interaction_Network
     */
    public function setCategoryArray($categoryArray)
    {
        $this->category_array = $categoryArray;

        return $this;
    }

    /**
     * Get categoryArray
     *
     * @return string
     */
    public function getCategoryArray()
    {
        return $this->category_array;
    }

    /**
     * Set tissueExpressionArray
     *
     * @param string $tissueExpressionArray
     *
     * @return Interaction_Network
     */
    public function setTissueExpressionArray($tissueExpressionArray)
    {
        $this->tissue_expression_array = $tissueExpressionArray;

        return $this;
    }

    /**
     * Get tissueExpressionArray
     *
     * @return string
     */
    public function getTissueExpressionArray()
    {
        return $this->tissue_expression_array;
    }

    /**
     * Set query
     *
     * @param string $query
     *
     * @return Interaction_Network
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }
}
