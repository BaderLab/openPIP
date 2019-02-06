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
class AnnouncementController extends Controller
{
	
	/**
	 * Lists all Announcement entities.
	 *
	 * @Route("/", name="announcement_manager")
	 * @Method({"GET", "POST"})
	 */
	public function announcementAction(Request $request)
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
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
		$short_title = $admin_settings->getShortTitle();
		$title = $admin_settings->getTitle();
		
		return $this->render('announcement_manager.html.twig', array(
				'announcements' => $announcements,
				'form' => $form->createView(),
		        'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
		        'short_title' => $short_title,
		        'title' => $title,
		        'footer' => $footer,
		));
	}
	
	/**
	 * Displays a form to edit an existing Announcement entity.
	 *
	 * @Route("/{id}/edit", name="admin_announcement_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Announcement $announcement)
	{
	    $deleteForm = $this->createDeleteForm($announcement);
	    $editForm = $this->createForm('AppBundle\Form\AnnouncementType', $announcement);
	    $editForm->handleRequest($request);
	
	    if ($editForm->isSubmitted() && $editForm->isValid()) {
	        $em = $this->getDoctrine()->getManager();
	        $em->persist($announcement);
	        $em->flush();
	
	        return $this->redirectToRoute('admin_announcement_edit', array('id' => $announcement->getId()));
	    }
	    
	    $admin_settings = $this->getDoctrine()
	    ->getRepository('AppBundle:Admin_Settings')
	    ->find(1);
	    
	    $main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
	    $short_title = $admin_settings->getShortTitle();
	    $title = $admin_settings->getTitle();
	    
	    return $this->render('announcement_edit.html.twig', array(
	            'announcement' => $announcement,
	            'edit_form' => $editForm->createView(),
	            'delete_form' => $deleteForm->createView(),
		        'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
	    		'title' => $title,
		        'short_title' => $short_title
	    ));
	}
	
	/**
	 * Deletes a Announcement entity.
	 *
	 * @Route("/{id}", name="admin_announcement_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, Announcement $announcement)
	{
	    $form = $this->createDeleteForm($announcement);
	    $form->handleRequest($request);
	
	    if ($form->isSubmitted() && $form->isValid()) {
	        $em = $this->getDoctrine()->getManager();
	        $em->remove($announcement);
	        $em->flush();
	    }
	
	    return $this->redirectToRoute('announcement_manager');
	}
	
	/**
	 * Creates a form to delete a Announcement entity.
	 *
	 * @param Announcement $announcement The Announcement entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Announcement $announcement)
	{
	    return $this->createFormBuilder()
	    ->setAction($this->generateUrl('admin_announcement_delete', array('id' => $announcement->getId())))
	    ->setMethod('DELETE')
	    ->getForm()
	    ;
	}
	
}
?>
