<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="`announcement`")
 */
class Announcement
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $title;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $date;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $show;


	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $show_on_home_page;




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
	 * Set table
	 *
	 * @param string $table
	 * @return Announcement
	 */
	public function setTable($table)
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Get table
	 *
	 * @return string
	 */
	public function getTable()
	{
		return $this->table;
	}

	/**
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Announcement
	 */
	public function setDate(\DateTime $date)
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * Get date
	 *
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set show
	 *
	 * @param boolean $show
	 * @return Announcement
	 */
	public function setShow($show)
	{
		$this->show = $show;

		return $this;
	}

	/**
	 * Get show
	 *
	 * @return boolean
	 */
	public function getShow()
	{
		return $this->show;
	}

	/**
	 * Set show_on_home_page
	 *
	 * @param boolean $showOnHomePage
	 * @return Announcement
	 */
	public function setShowOnHomePage($showOnHomePage)
	{
		$this->show_on_home_page = $showOnHomePage;

		return $this;
	}

	/**
	 * Get show_on_home_page
	 *
	 * @return boolean
	 */
	public function getShowOnHomePage()
	{
		return $this->show_on_home_page;
	}
}
?>