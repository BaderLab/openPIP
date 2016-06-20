<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Home controller.
 *
 * @Route("/admin/home")
 */
class HomeController extends Controller
{

	/**
	 * Admin Home
	 *
	 * @Route("/", name="home")
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
		$hello = 'hello';


		
		return $this->render('home.html.twig', array(
				'hello' => $hello,
				'announcements' => $announcements,
				'protein_count' => $protein_count,
				'organism_count' => $organism_count,
				'interaction_count' => $interaction_count,
				'domain_count' => $domain_count
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