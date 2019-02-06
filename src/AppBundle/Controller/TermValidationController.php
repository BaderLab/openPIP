<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Identifier;
use AppBundle\Form\IdentifierType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use AppBundle\Entity\Protein;
use AppBundle\Entity\Interaction;
//use AppBundle\Entity\Interaction_Network;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\ChoiceList\ArrayChoiceList;
use AppBundle\Entity\Dataset_Request;
use AppBundle\Utils\Node;
use AppBundle\Utils\Edge;
use AppBundle\Utils\QueryParameters;
use AppBundle\Utils\PublicationStatus;
use AppBundle\Utils\Functions;
use AppBundle\Entity\Interaction_Category;
use AppBundle\Entity\Interaction_Network;
use AppBundle\Entity\Experiment;

/**
 * Term Validation Controller
 */
class TermValidationController extends Controller
{
	
	/**
	 * Term Validation
	 * @Route("/term_validation/", name="no_term_validation")
	 * @Route("/term_validation/{search_term}", name="term_validation")
	 * @Method({"GET", "POST"})
	 */
	public function termValidationAction($search_term)
	{
		
		$return = array();
		$pattern = '/[;,\s\t\n]/';
		$search_query_array = preg_split( $pattern, $search_term);
		$search_query_array = array_filter($search_query_array, function($value) { return $value !== ''; });
		foreach($search_query_array as $search_query){
			if(self::assertIdentifierExists($search_query) == false){
				$return[] = $search_query;
			}
		}

		$response = new JsonResponse();
		$response->setData($return);
		
		return $response;
		
	}
	
	public function assertIdentifierExists($search_term){
		
		$em = $this->getDoctrine()->getManager();
		

		
		
		$query = $em->createQuery("SELECT i FROM AppBundle:Identifier i WHERE i.identifier = :identifier");
		$query->setParameter('identifier', $search_term);
		$results = $query->getResult();
		$return = false;
		if($results){$return = true;}
		
		
		
		
		return $return;
		
	}
}
?>	