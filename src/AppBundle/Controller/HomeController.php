<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Home controller.
 *

 */
class HomeController extends Controller
{

	/**
	 * Admin Home
	 *
	 * @Route("/admin/home/", name="admin_home")
	 * @Route ("/")
	 * @Method({"GET", "POST"})
	 */
	public function adminHomeAction(Request $request)
	{

		$em = $this->getDoctrine()->getManager();
		
		$protein_query = $em->createQuery('SELECT COUNT(p.id) FROM AppBundle:Protein p');
		
		$protein_count = $protein_query->getSingleScalarResult();
		
		$organism_query = $em->createQuery('SELECT COUNT(o.id) FROM AppBundle:Organism o');
		
		$organism_count = $organism_query->getSingleScalarResult();
		
		$interaction_query = $em->createQuery('SELECT COUNT(i.id) FROM AppBundle:Interaction i');
		
		$interaction_count = $interaction_query->getSingleScalarResult();
		
		$domain_instance_query = $em->createQuery('SELECT COUNT(d.id) FROM AppBundle:Domain d');
		
		$domain_instance_count = $domain_instance_query->getSingleScalarResult();
		
		$domain_query = $em->createQuery('SELECT COUNT(DISTINCT d.type) FROM AppBundle:Domain d');
		
		$domain_count = $domain_query->getSingleScalarResult();
		

		$announcement_query = $em->createQuery(
				'SELECT a
			    FROM AppBundle:Announcement a
			    WHERE a.show_on_home_page = :show_on_home_page
			    ORDER BY a.show_on_home_page ASC'
				)->setParameter('show_on_home_page', '1');
		
		$announcements = $announcement_query->getResult();

		$announcements = array_reverse($announcements);

		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		
		$title = $admin_settings->getTitle();
		$home_page = $admin_settings->getHomePage();
		
		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$home_page = $admin_settings->getHomePage();
		$color_scheme = $admin_settings->getColorScheme();
		
		
		return $this->render('admin_home.html.twig', array(
				'announcements' => $announcements,
				'protein_count' => $protein_count,
				'organism_count' => $organism_count,
				'interaction_count' => $interaction_count,
				'domain_count' => $domain_count,
				'domain_instance_count' => $domain_instance_count,
		        'title' => $title,
		        'home_page' => $home_page,
		        'color_scheme' => $color_scheme,
		        'short_title' => $short_title
		));
	}
	
	
	/**
	 * Home
	 *
	 * @Route("/home/", name="home")
	 * @Method({"GET", "POST"})
	 */
	public function homeAction(Request $request)
	{
	
		$em = $this->getDoctrine()->getManager();
	
		$protein_query = $em->createQuery('SELECT COUNT(p.id) FROM AppBundle:Protein p');
	
		$protein_count = $protein_query->getSingleScalarResult();
	
		$organism_query = $em->createQuery('SELECT COUNT(o.id) FROM AppBundle:Organism o');
	
		$organism_count = $organism_query->getSingleScalarResult();
	
		$interaction_query = $em->createQuery('SELECT COUNT(i.id) FROM AppBundle:Interaction i');
	
		$interaction_count = $interaction_query->getSingleScalarResult();
		
		$domain_instance_query = $em->createQuery('SELECT COUNT(d.id) FROM AppBundle:Domain d');
		
		$domain_instance_count = $domain_instance_query->getSingleScalarResult();
	
		$domain_query = $em->createQuery('SELECT COUNT(d.id) FROM AppBundle:Domain d');
	
		$domain_count = $domain_query->getSingleScalarResult();
	
		$announcement_query = $em->createQuery(
				'SELECT a
			    FROM AppBundle:Announcement a
			    WHERE a.show_on_home_page = :show_on_home_page
			    ORDER BY a.show_on_home_page ASC'
				)->setParameter('show_on_home_page', '1');
	
		$announcements = $announcement_query->getResult();

		$announcements = array_reverse($announcements);

		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		
		$title = $admin_settings->getTitle();
		$home_page = $admin_settings->getHomePage();
		$color_scheme = $admin_settings->getColorScheme();
		$short_title = $admin_settings->getShortTitle();
		
		return $this->render('home.html.twig', array(
		        'announcements' => $announcements,
		        'protein_count' => $protein_count,
		        'organism_count' => $organism_count,
		        'interaction_count' => $interaction_count,
		        'domain_count' => $domain_count,
		        'domain_instance_count' => $domain_instance_count,
		        'title' => $title,
		        'home_page' => $home_page,
		        'color_scheme' => $color_scheme,
		        'short_title' => $short_title
		));
	

	}
	
	public function count($entity){
		
		$sql = 'SELECT COUNT(i.id) FROM AppBundle:' . $entity . ' i';
		
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery($sql);
		
		$count = $query->getSingleScalarResult();
		
		return $count;
		
	}

}

?>