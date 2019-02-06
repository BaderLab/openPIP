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
 * Autocomplete controller.
 */
class AutoCompleteController extends Controller
{
	/**
	 * Autocomplete
	 *
	 * @Route("/autocomplete/{search_term}", name="autocomplete_search")
	 * @Method({"GET", "POST"})
	 */
	public function autocompleteAction($search_term)
	{
		
		$return = array();
		$return['invalid_terms'] = array();
		$pattern = '/[;,\s\t\n]/';
		$search_query_array = preg_split( $pattern, $search_term);
		$search_query_array = array_filter($search_query_array, function($value) { return $value !== ''; });

		foreach($search_query_array as $search_query){
			if(self::assertIdentifierExists($search_query) == false){	
				$return['invalid_terms'][] = $search_query;
			}	
		}

		$query = array_pop($search_query_array);

		$return_string = join(",", $search_query_array);
		
		$em = $this->getDoctrine()->getManager();
		$identifier_repository = $em->getRepository('AppBundle:Identifier');
		
		$query_builder = $identifier_repository->createQueryBuilder('i')
		->where('i.identifier LIKE :identifier_keyword');
		
		$query_builder->setParameter('identifier_keyword', "%$query%");
		$query = $query_builder->getQuery();
		$identifier_results = $query->getResult();
		
		$identifier_array = array();
		

		foreach($identifier_results as $identifier_result){
			
			$return_2 = array();	
			$name = $identifier_result->getIdentifier();
			$proteins = $identifier_result->getProteins();
			$protein = $proteins[0];
			$num_interactions = $protein->getNumberOfInteractionsInDatabase();
			
			
			if(!in_array($name, $identifier_array)){
			
    			$identifier_array[] = $name;
    			
    			$return_string_2 = $return_string . "," . $name;
    			$return_string_2 = preg_replace("/^[;,\s\t\n]/", '', $return_string_2);		
    			$return_2['value'] = $return_string_2;
    			$return_2['label'] = $name;	
    			$return_2['num_interactions'] = $num_interactions;	
    			$return['autocomplete'][] = $return_2;
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