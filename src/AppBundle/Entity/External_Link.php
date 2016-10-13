<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`external_link`")
 */
class External_Link
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Protein", inversedBy="external_links")
	 * @ORM\JoinColumn(name="protein_id", referencedColumnName="id")
	 */
	protected $protein;
	
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $database_name;
	
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $link_id;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $link;
	



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
     * Set databaseName
     *
     * @param string $databaseName
     *
     * @return External_Link
     */
    public function setDatabaseName($databaseName)
    {
        $this->database_name = $databaseName;

        return $this;
    }

    /**
     * Get databaseName
     *
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->database_name;
    }

    /**
     * Set linkId
     *
     * @param string $linkId
     *
     * @return External_Link
     */
    public function setLinkId($linkId)
    {
        $this->link_id = $linkId;

        return $this;
    }

    /**
     * Get linkId
     *
     * @return string
     */
    public function getLinkId()
    {
        return $this->link_id;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return External_Link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set protein
     *
     * @param \AppBundle\Entity\Protein $protein
     *
     * @return External_Link
     */
    public function setProtein(\AppBundle\Entity\Protein $protein = null)
    {
        $this->protein = $protein;

        return $this;
    }

    /**
     * Get protein
     *
     * @return \AppBundle\Entity\Protein
     */
    public function getProtein()
    {
        return $this->protein;
    }
}
