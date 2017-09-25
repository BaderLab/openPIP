<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`admin_settings`")
 */
class Admin_Settings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(name="`title`", type="string", length=200, nullable=true)
     */
    protected $title;

    /**
     *
     * @ORM\Column(name="`short_title`", type="string", length=200, nullable=true)
     */
    protected $short_title;
    
    /**
     *
     * @ORM\Column(name="`url`", type="string", length=200, nullable=true)
     */
    protected $url;
    
    /**
     *
     * @ORM\Column(name="`version`", type="string", length=200, nullable=true)
     */
    protected $version;

    /**
     * @ORM\Column(name="`home_page`", type="text", length=8000, nullable=true)
     */
    protected $home_page;

    /**
     * @ORM\Column(name="`about`", type="text", length=5000, nullable=true)
     */
    protected $about;

    /**
     * @ORM\Column(name="`faq`", type="text", length=5000, nullable=true)
     */
    protected $faq;
    
    /**
     * @ORM\Column(name="`download`", type="text", length=8000, nullable=true)
     */
    protected $download;


    /**
     * @ORM\Column(name="`contact`", type="text", length=8000, nullable=true)
     */
    protected $contact;

    /**
     * @ORM\Column(name="`show_downloads`", type="boolean")
     */
    protected $show_downloads;

    /**
     * @ORM\Column(name="`show_download_all`", type="boolean")
     */
    protected $show_download_all;

    /**
     * @ORM\Column(name="`footer`", type="text", length=2000, nullable=true)
     */
    protected $footer;

    /**
     * @ORM\Column(name="`main_color_scheme`", type="string", length=10, nullable=true)
     */
    protected $main_color_scheme;

    /**
     * @ORM\Column(name="`header_color_scheme`", type="string", length=10, nullable=true)
     */
    protected $header_color_scheme;

    /**
     * @ORM\Column(name="`logo_color_scheme`", type="string", length=10, nullable=true)
     */
    protected $logo_color_scheme;

    /**
     * @ORM\Column(name="`button_color_scheme`", type="string", length=10, nullable=true)
     */
    protected $button_color_scheme;

    /**
     * @ORM\Column(name="`example_1`", type="string", length=100, nullable=true)
     */
    protected $example_1;

    /**
     * @ORM\Column(name="`example_2`", type="string", length=100, nullable=true)
     */
    protected $example_2;

    /**
     * @ORM\Column(name="`example_3`", type="string", length=100, nullable=true)
     */
    protected $example_3;


    /**
     * @ORM\Column(name="`query_node_color`", type="string", length=20, nullable=true)
     */
    protected $query_node_color;
    
    /**
     * @ORM\Column(name="`interactor_node_color`", type="string", length=20, nullable=true)
     */
    protected $interactor_node_color;
    
    /**
     * @ORM\Column(name="`published_edge_color`", type="string", length=20, nullable=true)
     */
    protected $published_edge_color;
    
    
    /**
     * @ORM\Column(name="`validated_edge_color`", type="string", length=20, nullable=true)
     */
    protected $validated_edge_color;
    
    /**
     * @ORM\Column(name="`verified_edge_color`", type="string", length=20, nullable=true)
     */
    protected $verified_edge_color;
    
    /**
     * @ORM\Column(name="`literature_edge_color`", type="string", length=20, nullable=true)
     */
    protected $literature_edge_color;
    
  
    /**
     * @ORM\OneToMany(targetEntity="Interaction_Category", mappedBy="admin_settings")
     */
    public $interaction_categories;
    

    
    
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
     * Set title
     *
     * @param string $title
     *
     * @return Admin_Settings
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set shortTitle
     *
     * @param string $shortTitle
     *
     * @return Admin_Settings
     */
    public function setShortTitle($shortTitle)
    {
        $this->short_title = $shortTitle;

        return $this;
    }

    /**
     * Get shortTitle
     *
     * @return string
     */
    public function getShortTitle()
    {
        return $this->short_title;
    }

    /**
     * Set homePage
     *
     * @param string $homePage
     *
     * @return Admin_Settings
     */
    public function setHomePage($homePage)
    {
        $this->home_page = $homePage;

        return $this;
    }

    /**
     * Get homePage
     *
     * @return string
     */
    public function getHomePage()
    {
        return $this->home_page;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return Admin_Settings
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set download
     *
     * @param string $download
     *
     * @return Admin_Settings
     */
    public function setDownload($download)
    {
        $this->download = $download;

        return $this;
    }

    /**
     * Get download
     *
     * @return string
     */
    public function getDownload()
    {
        return $this->download;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Admin_Settings
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set showDownloads
     *
     * @param boolean $showDownloads
     *
     * @return Admin_Settings
     */
    public function setShowDownloads($showDownloads)
    {
        $this->show_downloads = $showDownloads;

        return $this;
    }

    /**
     * Get showDownloads
     *
     * @return boolean
     */
    public function getShowDownloads()
    {
        return $this->show_downloads;
    }

    /**
     * Set showDownloadAll
     *
     * @param boolean $showDownloadAll
     *
     * @return Admin_Settings
     */
    public function setShowDownloadAll($showDownloadAll)
    {
        $this->show_download_all = $showDownloadAll;

        return $this;
    }

    /**
     * Get showDownloadAll
     *
     * @return boolean
     */
    public function getShowDownloadAll()
    {
        return $this->show_download_all;
    }

    /**
     * Set footer
     *
     * @param string $footer
     *
     * @return Admin_Settings
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get footer
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set mainColorScheme
     *
     * @param string $mainColorScheme
     *
     * @return Admin_Settings
     */
    public function setMainColorScheme($mainColorScheme)
    {
        $this->main_color_scheme = $mainColorScheme;

        return $this;
    }

    /**
     * Get mainColorScheme
     *
     * @return string
     */
    public function getMainColorScheme()
    {
        return $this->main_color_scheme;
    }

    /**
     * Set headerColorScheme
     *
     * @param string $headerColorScheme
     *
     * @return Admin_Settings
     */
    public function setHeaderColorScheme($headerColorScheme)
    {
        $this->header_color_scheme = $headerColorScheme;

        return $this;
    }

    /**
     * Get headerColorScheme
     *
     * @return string
     */
    public function getHeaderColorScheme()
    {
        return $this->header_color_scheme;
    }

    /**
     * Set logoColorScheme
     *
     * @param string $logoColorScheme
     *
     * @return Admin_Settings
     */
    public function setLogoColorScheme($logoColorScheme)
    {
        $this->logo_color_scheme = $logoColorScheme;

        return $this;
    }

    /**
     * Get logoColorScheme
     *
     * @return string
     */
    public function getLogoColorScheme()
    {
        return $this->logo_color_scheme;
    }

    /**
     * Set buttonColorScheme
     *
     * @param string $buttonColorScheme
     *
     * @return Admin_Settings
     */
    public function setButtonColorScheme($buttonColorScheme)
    {
        $this->button_color_scheme = $buttonColorScheme;

        return $this;
    }

    /**
     * Get buttonColorScheme
     *
     * @return string
     */
    public function getButtonColorScheme()
    {
        return $this->button_color_scheme;
    }

    /**
     * Set example1
     *
     * @param string $example1
     *
     * @return Admin_Settings
     */
    public function setExample1($example1)
    {
        $this->example_1 = $example1;

        return $this;
    }

    /**
     * Get example1
     *
     * @return string
     */
    public function getExample1()
    {
        return $this->example_1;
    }

    /**
     * Set example2
     *
     * @param string $example2
     *
     * @return Admin_Settings
     */
    public function setExample2($example2)
    {
        $this->example_2 = $example2;

        return $this;
    }

    /**
     * Get example2
     *
     * @return string
     */
    public function getExample2()
    {
        return $this->example_2;
    }

    /**
     * Set example3
     *
     * @param string $example3
     *
     * @return Admin_Settings
     */
    public function setExample3($example3)
    {
        $this->example_3 = $example3;

        return $this;
    }

    /**
     * Get example3
     *
     * @return string
     */
    public function getExample3()
    {
        return $this->example_3;
    }

    /**
     * Set queryNodeColor
     *
     * @param string $queryNodeColor
     *
     * @return Admin_Settings
     */
    public function setQueryNodeColor($queryNodeColor)
    {
        $this->query_node_color = $queryNodeColor;

        return $this;
    }

    /**
     * Get queryNodeColor
     *
     * @return string
     */
    public function getQueryNodeColor()
    {
        return $this->query_node_color;
    }

    /**
     * Set interactorNodeColor
     *
     * @param string $interactorNodeColor
     *
     * @return Admin_Settings
     */
    public function setInteractorNodeColor($interactorNodeColor)
    {
        $this->interactor_node_color = $interactorNodeColor;

        return $this;
    }

    /**
     * Get interactorNodeColor
     *
     * @return string
     */
    public function getInteractorNodeColor()
    {
        return $this->interactor_node_color;
    }

    /**
     * Set publishedEdgeColor
     *
     * @param string $publishedEdgeColor
     *
     * @return Admin_Settings
     */
    public function setPublishedEdgeColor($publishedEdgeColor)
    {
        $this->published_edge_color = $publishedEdgeColor;

        return $this;
    }

    /**
     * Get publishedEdgeColor
     *
     * @return string
     */
    public function getPublishedEdgeColor()
    {
        return $this->published_edge_color;
    }

    /**
     * Set validatedEdgeColor
     *
     * @param string $validatedEdgeColor
     *
     * @return Admin_Settings
     */
    public function setValidatedEdgeColor($validatedEdgeColor)
    {
        $this->validated_edge_color = $validatedEdgeColor;

        return $this;
    }

    /**
     * Get validatedEdgeColor
     *
     * @return string
     */
    public function getValidatedEdgeColor()
    {
        return $this->validated_edge_color;
    }

    /**
     * Set verifiedEdgeColor
     *
     * @param string $verifiedEdgeColor
     *
     * @return Admin_Settings
     */
    public function setVerifiedEdgeColor($verifiedEdgeColor)
    {
        $this->verified_edge_color = $verifiedEdgeColor;

        return $this;
    }

    /**
     * Get verifiedEdgeColor
     *
     * @return string
     */
    public function getVerifiedEdgeColor()
    {
        return $this->verified_edge_color;
    }

    /**
     * Set literatureEdgeColor
     *
     * @param string $literatureEdgeColor
     *
     * @return Admin_Settings
     */
    public function setLiteratureEdgeColor($literatureEdgeColor)
    {
        $this->literature_edge_color = $literatureEdgeColor;

        return $this;
    }

    /**
     * Get literatureEdgeColor
     *
     * @return string
     */
    public function getLiteratureEdgeColor()
    {
        return $this->literature_edge_color;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interaction_categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add interactionCategory
     *
     * @param \AppBundle\Entity\Interaction_Category $interactionCategory
     *
     * @return Admin_Settings
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
     * Set url
     *
     * @param string $url
     *
     * @return Admin_Settings
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set faq
     *
     * @param string $faq
     *
     * @return Admin_Settings
     */
    public function setFaq($faq)
    {
        $this->faq = $faq;

        return $this;
    }

    /**
     * Get faq
     *
     * @return string
     */
    public function getFaq()
    {
        return $this->faq;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Admin_Settings
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
