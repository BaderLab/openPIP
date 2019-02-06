<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`interaction_category`")
 */
class Interaction_Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Interaction" , inversedBy="interaction_categories")
     * @ORM\JoinTable(name="interaction_interaction_category",
     *      joinColumns={
     *      		@ORM\JoinColumn(name="interaction_category_id", referencedColumnName="id")
     *      	},
     *      inverseJoinColumns={
     *      		@ORM\JoinColumn(name="interaction_id", referencedColumnName="id")
     *      	}
     * 		)
     */
    public $interactions;
    
    /**
     * @ORM\ManyToOne(targetEntity="Admin_Settings", inversedBy="interaction_categories")
     * @ORM\JoinColumn(name="admin_settings_id", referencedColumnName="id")
     */
    protected $admin_settings;
    
    public function __construct() {
        $this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     *
     * @ORM\Column(name="`category_name`", type="string", length=200, nullable=true)
     */
    protected $category_name;
    
    
    /**
     *
     * @ORM\Column(name="`order`", type="string", length=200, nullable=true)
     */
    protected $order;
    
    
    /**
     *
     * @ORM\Column(name="`color_scheme`", type="string", length=200, nullable=true)
     */
    protected $color_scheme;
    
    
    /**
     *
     * @ORM\Column(name="`description`", type="string", length=	1000, nullable=true)
     */
    protected $description;
    
    
    /**
     *
     * @ORM\Column(name="`selected_by_default`", type="string", length=	10, nullable=true)
     */
    protected $selected_by_default;
    
    /**
     *
     * @ORM\Column(name="`include_in_home_page_count`", type="string", length=	10, nullable=true)
     */
    protected $include_in_home_page_count;
    
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
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Interaction_Category
     */
    public function setCategoryName($categoryName)
    {
        $this->category_name = $categoryName;
        
        return $this;
    }
    
    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }
    
    /**
     * Set order
     *
     * @param string $order
     *
     * @return Interaction_Category
     */
    public function setOrder($order)
    {
        $this->order = $order;
        
        return $this;
    }
    
    /**
     * Get order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * Set colorScheme
     *
     * @param string $colorScheme
     *
     * @return Interaction_Category
     */
    public function setColorScheme($colorScheme)
    {
        $this->color_scheme = $colorScheme;
        
        return $this;
    }
    
    /**
     * Get colorScheme
     *
     * @return string
     */
    public function getColorScheme()
    {
        return $this->color_scheme;
    }
    
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Interaction_Category
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
     * Set selected_by_default
     *
     * @param string $selected_by_default
     *
     * @return Interaction_Category
     */
    public function setSelectedByDefault($selected_by_default)
    {
        $this->selected_by_default = $selected_by_default;
        
        return $this;
    }
    
    /**
     * Get selected_by_default
     *
     * @return string
     */
    public function getSelectedByDefault()
    {
        return $this->selected_by_default;
    }
    
    
    /**
     * Set include_in_home_page_count
     *
     * @param string $include_in_home_page_count
     *
     * @return Interaction_Category
     */
    public function setIncludeInHomePageCount($include_in_home_page_count)
    {
        $this->include_in_home_page_count = $include_in_home_page_count;
        
        return $this;
    }
    
    /**
     * Get include_in_home_page_count
     *
     * @return string
     */
    public function getIncludeInHomePageCount()
    {
        return $this->include_in_home_page_count;
    }
    
    
    /**
     * Add interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     *
     * @return Interaction_Category
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
     * Set adminSettings
     *
     * @param \AppBundle\Entity\Admin_Settings $adminSettings
     *
     * @return Interaction_Category
     */
    public function setAdminSettings(\AppBundle\Entity\Admin_Settings $adminSettings = null)
    {
        $this->admin_settings = $adminSettings;
        
        return $this;
    }
    
    /**
     * Get adminSettings
     *
     * @return \AppBundle\Entity\Admin_Settings
     */
    public function getAdminSettings()
    {
        return $this->admin_settings;
    }
    
    
    
}
