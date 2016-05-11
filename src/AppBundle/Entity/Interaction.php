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
     * @var \Doctrine\Common\Collections\ArrayCollection|Protein[]
     * @ORM\ManyToMany(targetEntity="Protein", mappedBy="interactions")
     */
    private $proteins;
	
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
     * @var \Doctrine\Common\Collections\ArrayCollection|Domain[]
     * @ORM\ManyToMany(targetEntity="Dataset", mappedBy="interactions")
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
}
