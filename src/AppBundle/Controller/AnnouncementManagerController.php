<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Announcement;
use AppBundle\Form\AnnouncementType;

/**
 * Announcement controller.
 *
 * @Route("/admin/announcement_manager")
 */
class AnnouncementManagerController extends Controller
{
	
	/**
	 * Lists all Announcement entities.
	 *
	 * @Route("/", name="announcement_manager")
	 * @Method({"GET", "POST"})
	 */
	public function announcement_managerAction(Request $request)
	{
		
		$announcement = new Announcement();
		$form = $this->createForm('AppBundle\Form\AnnouncementType', $announcement);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($announcement);
			$em->flush();
		
			return $this->redirectToRoute('announcement_manager');
		}
		
		$em = $this->getDoctrine()->getManager();
	
		$announcements = $em->getRepository('AppBundle:Announcement')->findAll();
		$announcements = array_reverse($announcements);
		
		
		
		return $this->render('announcement_manager.html.twig', array(
				'announcements' => $announcements,
				'form' => $form->createView(),
		));
	}
	
}

?>