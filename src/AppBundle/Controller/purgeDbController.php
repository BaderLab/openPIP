<?php
namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Announcement;
use AppBundle\Form\AnnouncementType;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * purgeDB controller.
 *
 * @Route("/admin/purgedb")
 */
class purgeDbController extends Controller
{
	
	/**
	 * Lists all Announcement entities.
	 *
	 * @Route("/", name="purge_db")
	 * @Method({"GET", "POST"})
	 */
	public function purgeDbAction(Request $request)
	{
		
		
		
		$em = $this->getDoctrine()->getManager();
	
		// $query = $em->createQuery(
		// 		'DELETE FROM AppBundle\Entity\Protein p WHERE 1'
		// )->execute();


		// $repository = $em->getRepository('AppBundle:Annotation');
		// $entities = $repository->findAll();

		// foreach ($entities as $entity) {
		// 	$em->remove($entity);
		// }
		// $em->flush();

		$repository = $em->getRepository('AppBundle:Identifier');
		$entities = $repository->findAll();

		foreach ($entities as $entity) {
			$em->remove($entity);
		}
		$em->flush();

		$repository = $em->getRepository('AppBundle:Annotation');
		$entities = $repository->findAll();

		foreach ($entities as $entity) {
			$em->remove($entity);
		}
		$em->flush();

		$repository = $em->getRepository('AppBundle:Annotation_Type');
		$entities = $repository->findAll();

		foreach ($entities as $entity) {
			$em->remove($entity);
		}
		$em->flush();

		$repository = $em->getRepository('AppBundle:Interaction');
		$entities = $repository->findAll();

		foreach ($entities as $entity) {
			$em->remove($entity);
		}
		$em->flush();


		$repository = $em->getRepository('AppBundle:External_Link');
		$entities = $repository->findAll();

		foreach ($entities as $entity) {
			$em->remove($entity);
		}
		$em->flush();

		$repository = $em->getRepository('AppBundle:Protein');
		$entities = $repository->findAll();

		foreach ($entities as $entity) {
			$em->remove($entity);
		}
		$em->flush();

    // return new Response('', Response::HTTP_OK);
		
		$this->addFlash(
			'success',
			'Database is now empty!'
		);

		// sleep(5);

		$url_new= $this->generateUrl('data_manager');
		$response = new RedirectResponse($url_new);
		return $response;
		
	}
	
		
}
?>
