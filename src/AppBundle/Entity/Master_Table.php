<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`master_table`")
 */
class Master_Table
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Dataset[]
     * @ORM\ManyToMany(targetEntity="Protein", mappedBy="master_tables")
     */
    private $proteins;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Dataset[]
     * @ORM\ManyToMany(targetEntity="Organism", mappedBy="master_tables")
     */
    private $organisms;
	
	
	public function __construct() {
		$this->proteins = new \Doctrine\Common\Collections\ArrayCollection();
		$this->organisms = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $source;
}	
	
	
	?>