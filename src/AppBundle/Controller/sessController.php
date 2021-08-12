<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;



/**
 * sess controller.
 *

 */
class sessController extends Controller
{
	
	/**
	 * about
	 * @Route("/sess/", name="sess")
	 * @Route("/admin/sess/", name="admin_sess")
	 * @Method({"GET", "POST"})
	 */
	public function sessAction(Request $request)
	{
		$session = $request->getSession();
		// $session->set('products', 'banana');
		$progress=$session->get('products');
		dump($session);die;	
		$output='aniket';
		return new JsonResponse($output);

	}


}

?>
