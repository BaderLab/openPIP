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
	

		

		$query = $em->createQuery(
				'SELECT i
			    FROM AppBundle:Announcement i
			    WHERE i.show = :show
			    ORDER BY i.show ASC'
		)->setParameter('show', '1');

		$announcements = $query->getResult();
		
		$announcements = array_reverse($announcements);
		
		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		
		$color_scheme = $admin_settings->getColorScheme();
		$short_title = $admin_settings->getShortTitle();
		return $this->render('admin_announcement_manager.html.twig', array(
				'announcements' => $announcements,
				'form' => $form->createView(),
		        'color_scheme' => $color_scheme,
		        'short_title' => $short_title
		));
	}
	
}

?>