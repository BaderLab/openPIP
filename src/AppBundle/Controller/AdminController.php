<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Announcement;
use AppBundle\Form\AnnouncementType;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
	
	/**
	 * Lists all Announcement entities.
	 *
	 * @Route("/", name="admin")
	 * @Method("GET")
	 */
	public function adminAction()
	{	
		return $this->render('admin/admin.html.twig');
	}
}
?>