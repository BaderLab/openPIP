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
			return $this->redirectToRoute('search_results', array('search_term' => $search_query));
			
		}
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT o
				FROM AppBundle:Organism o"
				);
					
		$organism_result_array = $query->getResult();
		

		
		

		return $this->render('search.html.twig', array(
				'form' => $form->createView(),
				'organism_result_array' => $organism_result_array,
				
		));
	}
	
	
	
	/**
	 * Search Results
	 *
	 * @Route("/search_results/{search_term}", name="search_results")
	 * @Method({"GET", "POST"})
	 */
	public function searchResultsAction($search_term)
	{
	
		$search_query = $search_term;
			
			
			
		
		$identifier_repository = $this->getDoctrine()
		->getRepository('AppBundle:Identifier');
			
		$identifier = $identifier_repository->findOneByIdentifier($search_query);
		$identifier_identifier = $identifier->getIdentifier();
		$identifier_naming_convention = $identifier->getNamingConvention();
		$protein = $identifier->getProtein();
		
		$protein_id = $protein->getId();
		$protein_name = $protein->getName();
		$protein_sequence = $protein->getSequence();
		$protein_description = $protein->getDescription();
			
			
			
			
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT i
				FROM AppBundle:Interaction i
				WHERE i.interactor_A = :interactor_A"
				);
		
		$query->setParameter('interactor_A', $protein_id);
			
		$interaction_result_array = $query->getResult();
			
		$interaction_array = array();
			
		$domain_array = array();
		$protein_of_intrest_array = array();
		$interacting_protein_nodes_array = array();
		$edge_array = array();
			
		$domain_array[] = array($protein_name);
			
		foreach($interaction_result_array as $interaction_result){
		
			$interaction_id = $interaction_result->getId();
			$interactor_A = $interaction_result->getInteractorA();
			$interactor_B = $interaction_result->getInteractorB();
			$binding_start = $interaction_result->getBindingStart();
			$binding_end = $interaction_result->getBindingEnd();
			$score = $interaction_result->getScore();
			$domain_id = $interaction_result->getDomain();
		
		
		
		
			$query = $em->createQuery(
					"SELECT p
				FROM AppBundle:Protein p
				WHERE p.id = :interactor_A"
					);
		
			$query->setParameter('interactor_A', $interactor_A);
				
			$interactor_A_array = $query->getResult();
		
			$_interactor_A = $interactor_A_array[0];
		
			$interactor_A_gene_name = $_interactor_A->getGeneName();
		
			$interactor_A_name = $_interactor_A->getName();
		
			$interactor_A_id = $_interactor_A->getId();
		
			if($domain_id){
				$domain = $this->getDoctrine()
				->getRepository('AppBundle:Domain')
				->find($domain_id);
		
		
		
				if($domain){
					$domain_name = $domain->getName();
					$domain_id = $domain->getId();
					$domain_array[] = array($domain_name);
						
				}else{
					$domain_id = $interactor_A_id;
					$domain_name = $interactor_A_name;
						
				}
			}else{
					
				$domain_id = $interactor_A_id;
				$domain_name = $interactor_A_name;
			}
		
		
		
			$protein_of_intrest_array[] = array($interactor_A_id, $interactor_A_name, $domain_id, $domain_name);
		
		
		
		
		
		
		
			$query = $em->createQuery(
					"SELECT p
				FROM AppBundle:Protein p
				WHERE p.id = :interactor_B"
					);
		
			$query->setParameter('interactor_B', $interactor_B);
				
			$interactor_B_array = $query->getResult();
		
			$_interactor_B = $interactor_B_array[0];
		
			$interactor_B_gene_name = $_interactor_B->getGeneName();
		
			$interactor_B_name = $_interactor_B->getName();
		
			$interactor_B_id  = $_interactor_B->getId();
		
			$interacting_protein_nodes_array[] = array($interactor_B_id, $interactor_B_name);
		
		
			$edge_array[] = array($domain_id, $domain_name, $interactor_B_id, $interactor_A_name, $interactor_B_name, $score);
				
		
			$_interaction = array();
		
			if($interactor_A_name){
				$_interaction['interactor_A_id'] = $interactor_A_name;
			}else{
				$_interaction['interactor_A_id'] = 'N/A';
			}
		
			if($interactor_A_gene_name){
				$_interaction['interactor_A_gene_name'] = $interactor_A_gene_name;
			}else{
				$_interaction['interactor_A_gene_name'] = 'N/A';
			}
		
			if($interactor_B_name){
				$_interaction['interactor_B_id'] = $interactor_B_name;
			}else{
				$_interaction['interactor_B_id'] = 'N/A';
			}
		
			if($interactor_B_gene_name){
				$_interaction['interactor_B_gene_name'] = $interactor_B_gene_name;
			}else{
				$_interaction['interactor_B_gene_name'] = 'N/A';
			}
		
			if($binding_start){
				$_interaction['binding_start'] = $binding_start;
			}else{
				$_interaction['binding_start'] = 'N/A';
			}
		
			if($binding_end){
				$_interaction['binding_end'] = $binding_end;
			}else{
				$_interaction['binding_end'] = 'N/A';
			}
		
			if($score){
				$_interaction['score'] = $score;
			}else{
				$_interaction['score'] = 'N/A';
			}
		
			$interaction_array[] = $_interaction;
		
		
		
		}
			
			
		$json_domain = array('1', '3', '2');
		$json_protein_of_intrest = array(array('4', 'FKBP4', '1', 'SH2'), array('4', 'FKBP4', '3', 'PWZ'), array('4', 'FKBP4', '2', 'SH3'));
		$json_interacting_protein_nodes = array(array('4', 'FKBP4'), array('234', 'FAP'), array('310', 'ESR1'), array('341', 'SIRT1'), array('354', '02-Mar'), array('423', 'TXN2'), array('442', 'RIPK3'), array('511', 'CSNK2A1'), array('598', 'PDIA2'), array('640', 'AGO2'), array('657', 'GML'), array('736', 'RPL18A'), array('801', 'RPA3'), array('824', 'RLN1'), array('940', 'HSPA8'));
		$json_edge = array(array('1', 'SH2', '4', 'FKBP4', 'FKBP4', 'binding', '190'), array('1', 'SH2', '234', 'FKBP4', 'FAP', 'catalysis', '190'), array('1', 'SH2', '310', 'FKBP4', 'ESR1', 'inhibition', '190'), array('1', 'SH2', '341', 'FKBP4', 'SIRT1', 'ptmod', '190'), array('3', 'PWZ', '354', 'FKBP4', '02-Mar', 'reaction', '190'), array('3', 'PWZ', '423', 'FKBP4', 'TXN2', 'activation', '190'), array('3', 'PWZ', '442', 'FKBP4', 'RIPK3', 'binding', '190'), array('3', 'PWZ', '511', 'FKBP4', 'CSNK2A1', 'catalysis', '190'), array('2', 'SH3', '598', 'FKBP4', 'PDIA2', 'inhibition', '190'), array('2', 'SH3', '640', 'FKBP4', 'AGO2', 'ptmod', '190'), array('1', 'SH2', '657', 'FKBP4', 'GML', 'reaction', '190'), array('2', 'SH3', '736', 'FKBP4', 'RPL18A', 'activation', '199'), array('2', 'SH3', '801', 'FKBP4', 'RPA3', 'binding', '199'), array('3', 'PWZ', '824', 'FKBP4', 'RLN1', 'catalysis', '199'), array('1', 'SH2', '940', 'FKBP4', 'HSPA8', 'reaction', '199'));
			
		$json0 = json_encode(array('domain' => $json_domain, 'protein_of_intrest' => $json_protein_of_intrest, 'interacting_protein_nodes' => $json_interacting_protein_nodes, 'edge' => $json_edge));
		
			
		$json1 = json_encode(array('domain' => $domain_array));
		$json2 = json_encode(array('protein_of_intrest' => $protein_of_intrest_array));
		
		$json3 = json_encode(array('interacting_protein_nodes' => $interacting_protein_nodes_array));
			
		$json4 = json_encode(array('edge' => $edge_array));
		
			
			
			
		$handle = fopen("C:/Users/Miles/Desktop/test.txt", 'w');
			
			
			
		
		$json = json_encode(array('domain' => $domain_array, 'protein_of_intrest' => $protein_of_intrest_array, 'interacting_protein_nodes' => $interacting_protein_nodes_array, 'edge' => $edge_array));
			
			
		fwrite($handle, "$json");
			
		return $this->render('search_result.html.twig', array(
				'interaction_array' => $interaction_array,
				'json' => $json,
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
	
	/**
	 * Search Home
	 *
	 * @Route("/json", name="json_search")
	 * @Method({"GET", "POST"})
	 */
	public function jsonResponseAction($search_term)
	{
	
	
		$json_domain = array('1', '3', '2');
		$json_protein_of_intrest = array(array('4', 'FKBP4', '1', 'SH2'), array('4', 'FKBP4', '3', 'PWZ'), array('4', 'FKBP4', '2', 'SH3'));
		$json_interacting_protein_nodes = array(array('4', 'FKBP4'), array('234', 'FAP'), array('310', 'ESR1'), array('341', 'SIRT1'), array('354', '02-Mar'), array('423', 'TXN2'), array('442', 'RIPK3'), array('511', 'CSNK2A1'), array('598', 'PDIA2'), array('640', 'AGO2'), array('657', 'GML'), array('736', 'RPL18A'), array('801', 'RPA3'), array('824', 'RLN1'), array('940', 'HSPA8'));
		$json_edges = array(array('1', 'SH2', '4', 'FKBP4', 'FKBP4', 'binding', '190'), array('1', 'SH2', '234', 'FKBP4', 'FAP', 'catalysis', '190'), array('1', 'SH2', '310', 'FKBP4', 'ESR1', 'inhibition', '190'), array('1', 'SH2', '341', 'FKBP4', 'SIRT1', 'ptmod', '190'), array('3', 'PWZ', '354', 'FKBP4', '02-Mar', 'reaction', '190'), array('3', 'PWZ', '423', 'FKBP4', 'TXN2', 'activation', '190'), array('3', 'PWZ', '442', 'FKBP4', 'RIPK3', 'binding', '190'), array('3', 'PWZ', '511', 'FKBP4', 'CSNK2A1', 'catalysis', '190'), array('2', 'SH3', '598', 'FKBP4', 'PDIA2', 'inhibition', '190'), array('2', 'SH3', '640', 'FKBP4', 'AGO2', 'ptmod', '190'), array('1', 'SH2', '657', 'FKBP4', 'GML', 'reaction', '190'), array('2', 'SH3', '736', 'FKBP4', 'RPL18A', 'activation', '199'), array('2', 'SH3', '801', 'FKBP4', 'RPA3', 'binding', '199'), array('3', 'PWZ', '824', 'FKBP4', 'RLN1', 'catalysis', '199'), array('1', 'SH2', '940', 'FKBP4', 'HSPA8', 'reaction', '199'));
		
		$json = json_encode(array('domain' => $json_domain, 'protein_of_intrest' => $json_protein_of_intrest, 'interacting_protein_nodes' => $json_interacting_protein_nodes, 'edges' => $json_edges));

		$response = new JsonResponse();
		$response->setData($json);

		return $response;
	
	}

}

?>
