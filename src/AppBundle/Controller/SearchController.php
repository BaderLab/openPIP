<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Identifier;
use AppBundle\Form\IdentifierType;
use AppBundle\Entity\Protein;
use AppBundle\Entity\Interaction;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Search controller.
 *
 * @Route("/admin/search")
 */
class SearchController extends Controller
{

	/**
	 * Search Home
	 *
	 * @Route("/", name="search")
	 * @Method({"GET", "POST"})
	 */
	public function searchAction(Request $request)
	{
		
		$identifier = new Identifier();
		$form = $this->createForm('AppBundle\Form\IdentifierType', $identifier);
		$form->handleRequest($request);
		

		
		
		if ($form->isSubmitted() && $form->isValid()) {

		
			$search_query = $form["identifier"]->getData();

			
			
			$identifier_repository = $this->getDoctrine()
			->getRepository('AppBundle:Identifier');
			
			$identifier = $identifier_repository->findOneByIdentifier($search_query);
			$identifier_identifier = $identifier->getIdentifier();
			$identifier_naming_convention = $identifier->getNamingConvention();
			$protein = $identifier->getProtein();

			$protein_protein_id = $protein->getId();
			$protein_name = $protein->getName();
			$protein_sequence = $protein->getSequence();
			$protein_description = $protein->getDescription();

			
			//$handle = fopen("C:/Users/Miles/Desktop/test.txt", 'w');
			//fwrite($handle, "$search_query      ");
			//fwrite($handle, "$identifier_identifier      ");
			//fwrite($handle, "$identifier_naming_convention      ");
			//fwrite($handle, "$protein_protein_id      ");
			//fwrite($handle, "$protein_name      ");
			//fwrite($handle, "$protein_sequence      ");
			//fwrite($handle, "$protein_description      ");

			
			
			$em = $this->getDoctrine()->getManager();
			$interaction_repository = $em->getRepository('AppBundle:Interaction');
			
			
			$query_builder = $interaction_repository->createQueryBuilder('i')
			->innerJoin('i.proteins', 'p')
			->where('p.id = :protein_id');
			
			$query_builder->setParameter('protein_id', $protein_protein_id);
			$query = $query_builder->getQuery();
			$interaction_results = $query->getResult();
			
			$interaction_array = array();
			
			$json_domains = '';
			$json_protein_of_intrest = '';
			
			
			foreach($interaction_results as $interaction_result){
				$interaction_id = $interaction_result->getId();
				
				$em = $this->getDoctrine()->getManager();
				$interaction_repository = $em->getRepository('AppBundle:Protein');
					
					
				$query_builder = $interaction_repository->createQueryBuilder('p')
				->innerJoin('p.interactions', 'i')
				->where('i.id = :interaction_id');
					
				$query_builder->setParameter('interaction_id', $interaction_id);
				$query = $query_builder->getQuery();
				$protein_results = $query->getResult();
				
				$protein_array = array();
				
				foreach($protein_results as $protein_result){
					
					$protein_id = $protein_result->getId();
					$protein_name = $protein_result->getName();
					//fwrite($handle, "$protein_name      ");
					
					$protein_array[] = $protein_name;
				}
				
				$interaction_array[] = $protein_array;
				
				$score = $interaction_result->getScore();

				//fwrite($handle, "$score      ");
			
			}
			


			//fclose($handle);
			$json_data = '{';
			
			$json_data .= '}';
			
			return $this->render('search_result.html.twig', array(
				'interaction_array' => $interaction_array,
				'json_data' => $json_data,
				));
			
		}

		return $this->render('search.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	
	
	
	/**
	 * Search Home
	 *
	 * @Route("/autocomplete/{search_term}", name="autocomplete_search")
	 * @Method({"GET", "POST"})
	 */
	public function autocompleteAction($search_term)
	{
		
		
		$em = $this->getDoctrine()->getManager();
		$identifier_repository = $em->getRepository('AppBundle:Identifier');
		


		$query_builder = $identifier_repository->createQueryBuilder('i')
		->where('i.identifier LIKE :identifier_keyword');
			
		$query_builder->setParameter('identifier_keyword', "%$search_term%");
		$query = $query_builder->getQuery();
		$identifier_results = $query->getResult();
		
		$return = array();
		
		foreach($identifier_results as $identifier_result){
			
			$name = $identifier_result->getIdentifier();
			$return[] = $name;
		}
		
		
		$response = new JsonResponse();
		$response->setData($return);
		
		return $response;
		
	}

}

?>
