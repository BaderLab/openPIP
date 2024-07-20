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
use AppBundle\Entity\Annotation_Type;

/**
 * Search controller.

 */
class SearchController extends Controller
{
	/**
	 * Search Results
	 * @Route("/search/{search_term}", defaults={"search_term"="no_search"}), name="search", options={"expose": true})
	 * @Route("/search_results/{search_term}", defaults={"search_term"="no_search"}), name="search_results", options={"expose": true})
	 * @Route("/admin/search/{search_term}", name="admin_search", options={"expose": true})
	 * @Method({"GET", "POST"})
	 */
	public function searchAction($search_term, Request $request)
	{

		$interaction_categories_array = self::getInteractionCategories();
		$query_parameters = '';
		$found_protein_array = '';
		$unfound_protein_summary = '';
		$found_protein_summary = '';
		$json = '';
		
		if($search_term == "no_search"){
    		$query_parameters = self::getQueryParameters($search_term, $request);
    		$found_protein_array = self::getFoundProteins($query_parameters);
    		$unfound_protein_summary = $found_protein_array['unfound_protein_array'];
    		$found_protein_summary = $found_protein_array['found_protein_array'];
    		$json = json_encode(array('all_proteins' => [], 'all_interactions' => [],
    		    'domains' => '', 'complexes' => '','query_protein_id_array' => [],
    		    'search_term' => "no_search", 'unfound_protein_summary' => $unfound_protein_summary,
    		    'found_protein_summary' => $found_protein_summary ), JSON_HEX_QUOT);
		}else{
		    $query_parameters = self::getQueryParameters($search_term, $request);
		    $interaction_data_array = self::getInteractionData($query_parameters);
		    $all_proteins = $interaction_data_array[0];
		    $all_interactions = $interaction_data_array[1];
		    $query_array = $interaction_data_array[2];
		    $query_protein_array = $query_array[0];
		    $query_protein_id_array = $query_array[1];
		    $found_proteins_string = $query_array[2];
		    $not_found_proteins_string = $query_array[3];
		    $domains='';
		    $complexes='';
		    
		    $json = json_encode(array('all_proteins' => $all_proteins, 'all_interactions' => $all_interactions,
		        'domains' => $domains, 'complexes' => $complexes,'query_protein_id_array' => $query_protein_id_array,
		        'search_term' => $search_term, 'unfound_protein_summary' => $not_found_proteins_string,
		        'found_protein_summary' => $found_proteins_string), JSON_HEX_QUOT);
		}
    		
		$annotation_types = self::getAnnotationTypes();
		$annotation_form_array = self::getAnnotationFormArray($annotation_types);
		$annotation_types_array = self::getAnnotationTypesArray();
		
		$admin_settings = self::getAdminSettings();
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
		$header_color_scheme = $admin_settings->getHeaderColorScheme();
		$logo_color_scheme = $admin_settings->getLogoColorScheme();
		$button_color_scheme = $admin_settings->getButtonColorScheme();
		$query_node_color = $admin_settings->getQueryNodeColor();
		$interactor_node_color = $admin_settings->getInteractorNodeColor();
		$published_edge_color = $admin_settings->getPublishedEdgeColor();
		$validated_edge_color = $admin_settings->getValidatedEdgeColor();
		$verified_edge_color = $admin_settings->getVerifiedEdgeColor();
		$literature_edge_color = $admin_settings->getLiteratureEdgeColor();
		$url = $admin_settings->getUrl();
		$version = $admin_settings->getVersion();
		$login_status = self::checkLoginStatus();
		$admin_status = self::checkAdminStatus();
		$form = $this->createFormBuilder()
		->add('add_interaction_network', CheckboxType::class, array(
				'label' => 'Recieve Updates on Interaction Network',
				'required' => false,
				'attr' => array('value' => 'add_interaction_network', 'checked' => false)))
				->add('type', TextType::class)
				->add('data', TextType::class)
				->getForm();
				
		$form->handleRequest($request);

		return $this->render('search_result.html.twig', array(
				'form' => $form->createView(),
                'json' => $json,
				'annotation_types' => $annotation_types,
				'annotation_types_array' => $annotation_types_array,
				'annotation_form_array' => $annotation_form_array,				
				'search_query' => $search_term,
				'unfound_protein_summary' => $unfound_protein_summary,
				'found_protein_summary' => $found_protein_summary,
				'main_color_scheme' => $main_color_scheme,
				'header_color_scheme' => $header_color_scheme,
				'logo_color_scheme' => $logo_color_scheme,
				'button_color_scheme' => $button_color_scheme,
				'query_node_color' => $query_node_color,
				'interactor_node_color' => $interactor_node_color,
				'interaction_categories_array' => $interaction_categories_array,
				'published_edge_color' => $published_edge_color,
				'validated_edge_color' => $validated_edge_color,
				'verified_edge_color' => $verified_edge_color,
				'literature_edge_color' => $literature_edge_color,
				'url' => $url,
				'version' => $version,
				'short_title' => $short_title,
				'title' => $title,
				'footer' => $footer,
				'query_parameters' => $query_parameters,
				'login_status' => $login_status,
				'admin_status' => $admin_status,
				'page' => 'search'
				
		));
		
	}
	
	/**
	 * Search Results
	 *
	 * @Route("/search_results_interactions", name="search_results_interactions", options={"expose": true})
	 * @Method({"GET", "POST"})
	 */
	public function searchResultsInteractionsAction(Request $request)
	{
	    $query_interactor = $request->get('query_interactor');
		$search_term = $request->get('search_term_parameter');
		$filter_parameter = $request->get('filter_parameter');
		$search_term_array = $request->get('search_term_array');


		
		//$search_term = "BAD,BAK1,BMF,MCL1";
		//$filter_parameter = "query_query";
		//$filter_parameter = "None";
		//$search_term_array = array("BAD","BAK1","BMF","MCL1");
		
		//$search_term = "COA7";
		//$filter_parameter = "query_interactor";
		//$filter_parameter = "None";
		//$search_term_array = array("COA7");
		
		//$search_term = "BAD,BCL2L1,BCL2L2,BAK1,BMF,MCL1,BCL2L11,BCL2A1,BIK,REL";
		//$filter_parameter = "query_query";
		//$filter_parameter = "None";
		//$search_term_array = array("BAD", "BCL2L1","BCL2L2","BAK1","BMF","MCL1","BCL2L11","BCL2A1","BIK","REL");


		$query_parameters = $this->get('app.query_parameters');
		$query_parameters->setSearchTermParameter($search_term);
		$query_parameters->setFilterParameter($filter_parameter);
		$query_parameters->setSearchTermArray($search_term_array);
		
		if($query_interactor == 'interactor'){	    
		    $query_parameters->setFilterParameter("query_query");    
		}
		

		
		$interaction_data_array = self::getInteractionData($query_parameters);
		$all_proteins = $interaction_data_array[0];
		$all_interactions = $interaction_data_array[1];
		$query_array = $interaction_data_array[2];
		
		$query_protein_array = $query_array[0];
		$query_protein_id_array = $query_array[1];
		$found_proteins_string = $query_array[2];
		$not_found_proteins_string = $query_array[3];
		
	
		//$query_protein_id_array = self::getQueryIsoformArray($all_proteins, $query_protein_id_array);
		//$domains = self::getDomainForInteractions($all_interactions);
		//$complexes = self::getComplexesForInteractors($all_proteins);
		//$annotations = self::getAnnotationsForInteractions($all_interactions);
	    //$found_protein_array = self::getFoundProteins($query_parameters);
	    //$unfound_protein_summary = $found_protein_array['unfound_protein_array'];
	    //$found_protein_summary = $found_protein_array['found_protein_array'];
		//$unfound_protein_summary = '';
		//$found_protein_summary = '';
	    $domains='';
	    $complexes='';
		
	    $json = json_encode(array('all_proteins' => $all_proteins, 'all_interactions' => $all_interactions, 
	        'domains' => $domains, 'complexes' => $complexes,'query_protein_id_array' => $query_protein_id_array, 
	        'search_term' => $search_term, 'unfound_protein_summary' => $not_found_proteins_string, 
	        'found_protein_summary' => $found_proteins_string), JSON_HEX_QUOT);
		
		if($query_interactor == 'interactor'){
		    $query_id_array = $request->get('query_id_array');
		    $json = json_encode(array('all_proteins' => $all_proteins, 'all_interactions' => $all_interactions, 'domains' => $domains, 'complexes' => $complexes,'query_protein_id_array' => $query_protein_id_array, 'search_term' => $search_term, 'unfound_protein_summary' => $not_found_proteins_string, 'found_protein_summary' => $found_proteins_string), JSON_HEX_QUOT);
		}
		
		$response = new JsonResponse();
		$response->setData($json);
		
		return $response;
	}
	
	/**
	 * Save Interaction Network
	 *
	 * @Route("/save_interaction_network", name="save_interaction_network", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function save_interaction_networkAction(Request $request)
	{
	    
	    $json_data = $request->get('json_data');  
	    $interaction_data = json_decode($json_data);
	    $user = $this->get('security.token_storage')->getToken()->getUser();
	    $em = $this->getDoctrine()->getManager();
	    //$handle = fopen('/home/mmee/Desktop/test_1.txt', 'w');
	    //fwrite($handle, json_encode($interaction_data));
	    $network = new Interaction_Network();
	    foreach ($interaction_data as $data){ 
	        $interaction_id =  $data->interaction_id;
	        $repository = $em->getRepository('AppBundle:Interaction');
	        $interaction =$repository->find($interaction_id);	       
	        $network->addInteraction($interaction);
	        $interaction->addInteractionNetwork();	        
	        $em->persist($interaction);
	    }
	    
	    $interaction_network->addUser($user);
	    
	    $user->addInteractionNetwork($interaction_network);	    
	    $em->persist($user);
	    $em->persist($network);
	    $em->flush();
	    
	    $response = new Response();
	    return $response;
	    
	}
	
	
	public function getInteractionData($query_parameters){
	    
	    $filter_parameter = $query_parameters->getFilterParameter();
	    $search_term_array = $query_parameters->getSearchTermArray();
	    
	    $node_array = array();
	    $edge_array = array();
	    
	    
	    $query_array = self::getProteinQueryArray($search_term_array); 
	    $query_protein_array = $query_array[0];
	    $query_protein_id_array = $query_array[1];
	    
	    $interactor_array = self::getInteractorArray($query_protein_id_array, $filter_parameter);   
	    $interaction_array = self::getInteractionArray($interactor_array, $query_protein_array, $filter_parameter);

	    $node_array = self::interactorNodeHandeler($interactor_array, $query_protein_array);
	    
	    $edge_array = self::interactionEdgeHandeler($interaction_array, $node_array, $query_protein_array);
	    $node_array = array_values($node_array);
	    $edge_array = array_values($edge_array);
	    
	    return array($node_array, $edge_array, $query_array);
	    
	}
	
	
	public function getProteinQueryArray($search_term_array){    
	    $query_protein_array = array();
	    
	    $functions = $this->get('app.functions');
	    $connection =  $functions->mysql_connect();
	    $query_protein_identifier_string = join(',', $search_term_array);
	    $query_protein_identifier_string = "'" . str_replace(",", "','", $query_protein_identifier_string) . "'";
	    
	    $query = "SELECT * FROM `identifier` WHERE `identifier` IN ($query_protein_identifier_string)";
	    $result = $connection->query($query);
	    $repository = $this->getDoctrine()->getRepository('AppBundle:Protein');
	    
	    
	    if($result){
	        $identifier_id_array = array();
	        while($row = $result->fetch_assoc()){
	            $identifier_id = $row['id'];
	            $identifier_id_array[] = $identifier_id;
	        }
	        $identifier_id_string = join(',', $identifier_id_array);
	        $identifier_id_string = "'" . str_replace(",", "','", $identifier_id_string) . "'";
	        
	        $query2 = "SELECT * FROM `protein_identifier` WHERE `identifier_id` IN ($identifier_id_string)";
	        $result2 = $connection->query($query2);
	        if($result2){
	            $protein_id_array = array();
	            while($row2 = $result2->fetch_assoc()){
	                $protein_id = $row2['protein_id'];
	                $protein_id_array[] = $protein_id;
	            }
	            $query_proteins = $repository->findBy(array('id' => $protein_id_array));
	        }
	        foreach($query_proteins as $query_protein){
	            $id = $query_protein->getId();
	            $gene_name = $query_protein->getGeneName();
	            
	            $query_protein_array[$id] = $gene_name;
	            
	        }
	        
	    }
	    
	    $found_proteins_array = array();
	    $not_found_proteins_array = array();
	    
	    foreach($search_term_array as $search_term){
	        if(in_array($search_term, $query_protein_array)){
	            $found_proteins_array[] = $search_term;
	        }else{
	            $not_found_proteins_array[] = $search_term;
	        }
	    }
	    
	    $found_proteins_string = join("</br>", $found_proteins_array);
	    $not_found_proteins_string = join("</br>", $not_found_proteins_array);
	    
	    $query_protein_id_array = array_keys($query_protein_array);

	    return array($query_protein_array, $query_protein_id_array, $found_proteins_string, $not_found_proteins_string);
	}
	
	public function getInteractorArray($query_protein_id_array, $filter_parameter){
	    $interactor_array = array();

	    $functions = $this->get('app.functions');

	    if($filter_parameter == 'None' || $filter_parameter == 'query_interactor'){
	        $interactions = self::getInteractionsForList($query_protein_id_array);
	        
	        if($interactions){
	            foreach($interactions as $interaction){
	                $interactor_array[] = $interaction['interactor_A'];
	                $interactor_array[] = $interaction['interactor_B'];
	            }
	        } 
	        $interactor_array = $functions->removeDuplicates($interactor_array);
	    }elseif($filter_parameter == "query_query"){
	        foreach($query_protein_id_array as $query_protein_id){
	            $interactor_array[] = $query_protein_id;
	        }
	    }

	    return $interactor_array; 
	}
	
	
	public function getInteractionArray($interactor_array, $query_protein_array, $filter_parameter){
	    
	    $interaction_array = false;
	    
	    if($filter_parameter == 'query_interactor'){
	        $interaction_array = self::getQueryInteractorInteractionsAmongList($query_protein_array, $interactor_array);
	    }else{
	        $interaction_array = self::getInteractionsAmongList($interactor_array);        
	    }
	    
	    return $interaction_array;
	}
	
	
	public function getInteractionsAmongList($interactor_array){
		
		$functions = $this->get('app.functions');		
		$connection =  $functions->mysql_connect();
		
		$interactor_id_string = join(',', $interactor_array);
		$interactor_id_string = "'" . str_replace(",", "','", $interactor_id_string) . "'";
		
		$query = "SELECT * FROM `interaction` WHERE `removed` = 0 AND (interactor_A IN ($interactor_id_string) AND interactor_B IN ($interactor_id_string))";
		
		$result = $connection->query($query);
		mysqli_close($connection);
		$interaction_array = array();
		if($result){
			while($row = $result->fetch_assoc()) {
				$interaction_array[] = $row;
			}
		}
		
		if($interaction_array){
			return $interaction_array;
		}else{
			return false;
		}
	}
		
	public function getQueryInteractorInteractionsAmongList($query_protein_array, $interactor_array){
		
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		
		$query_protein_id_array = array_keys($query_protein_array);

		
		$interactor_id_string = join(',', $interactor_array);
		$interactor_id_string = "'" . str_replace(",", "','", $interactor_id_string) . "'";
		$query_protein_id_string = join(',', $query_protein_id_array);
		$query_protein_id_string = "'" . str_replace(",", "','", $query_protein_id_string) . "'";
		
		$query = "SELECT * FROM `interaction` WHERE removed = 0 AND (`interactor_A` IN ($interactor_id_string) AND `interactor_B` IN ($query_protein_id_string)) OR (`interactor_A` IN ($query_protein_id_string) AND `interactor_B` IN ($interactor_id_string))";
		
		$result = $connection->query($query);
		mysqli_close($connection);
		
		$interaction_array = array();
		if($result){
			while($row = $result->fetch_assoc()) {
				$interaction_array[] = $row;
			}
		}
		
		if($interaction_array){
			return $interaction_array;
		}else{
			return false;
		}
	}
	
	public function getInteractionsForList($interactor_array){
		
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		
		$interactor_id_string = join(',', $interactor_array);
		$interactor_id_string = "'" . str_replace(",", "','", $interactor_id_string) . "'";
		
		$query = "SELECT * FROM `interaction` WHERE  removed = 0 AND (`interactor_A` IN ($interactor_id_string)) OR (`interactor_B` IN ($interactor_id_string))";
		$result = $connection->query($query);
		mysqli_close($connection);
		
		$interaction_array = array();
		if($result){
			while($row = $result->fetch_assoc()) {
				$interaction_array[] = $row;
			}
		}
		
		if($interaction_array){
			return $interaction_array;
		}else{
			return false;
		}
		
	}
	
	public function getAnnotationTypeArray(){
		/*
		 $annotation_type = $this->getDoctrine()
		 ->getRepository('AppBundle:Annotation_Type')
		 ->findAll();
		 
		 $annotation_type_array = array();
		 
		 foreach($annotation_type as $annotation){
		 
		 $id = $annotation->getId();
		 $type = $annotation->getType();
		 $annotation_type_array[$id] = $type;
		 }
		 */
		
		$annotation_type_array = array('1' => 'tissue_expression','2' => 'subcellular_location');
		
		return $annotation_type_array;
	}

	public function interactorNodeHandeler($interactor_array, $query_protein_gene_name_array){
	    
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		
		$interactor_id_string = join(',', $interactor_array);
		$interactor_id_string = "'" . str_replace(",", "','", $interactor_id_string) . "'";
		
		$query_annotation = "SELECT * FROM `annotation` INNER JOIN `annotation_protein` ON `annotation`.`id` = `annotation_protein`.`annotation_id` WHERE `annotation_protein`.`protein_id` IN ($interactor_id_string)";		
		$result_annotation = $connection->query($query_annotation);
		
		$annotation_array = array();
		if($result_annotation){
    		while($row_annotation = $result_annotation->fetch_assoc()) {
    			$type = $row_annotation['type_name'];
    			$annotation_json = $row_annotation['annotation'];
    			$protein_id = $row_annotation['protein_id'];
    			//fwrite($h, json_encode($protein_id));
    			
    			$annotation_array[$protein_id][$type] = $annotation_json;
    		}
		}
		$query = "SELECT * FROM `protein` WHERE id IN ($interactor_id_string)";
		$result = $connection->query($query);
		mysqli_close($connection);
		$node_array = array();
		
		//$h=fopen('/home/mmee/Desktop/test.txt', 'w');
		
		
		if($result){
		    $query_node_array = array();
		    $interactor_node_array = array();
		    
			while($row = $result->fetch_assoc()) {
				
				$protein_id = $row['id'];
				$protein_uniprot_id = $row['uniprot_id'];
				$protein_ensembl_id = $row['ensembl_id'];
				$protein_entrez_id = $row['entrez_id'];
				$protein_gene_name = $row['gene_name'];
				$protein_protein_name = $row['protein_name'];
				$protein_description = $row['description'];
				$protein_sequence = $row['sequence'];
				$number_of_interactions_in_database = $row['number_of_interactions_in_database'];
				$node_annotation_array = array();
				if(array_key_exists($protein_id, $annotation_array)){
				    $node_annotation_array = $annotation_array[$protein_id];
				}
				
				$node = array();
				$node['protein_id'] = $protein_id;
				$node['protein_uniprot_id'] = $protein_uniprot_id;
				$node['protein_ensembl_id'] = $protein_ensembl_id;
				$node['protein_gene_name'] = $protein_gene_name;
				$node['protein_protein_name'] = $protein_protein_name;
				$node['protein_entrez_id'] = $protein_entrez_id;
				$node['protein_gene_name'] = $protein_gene_name;
				$node['protein_description'] = $protein_description;
				$node['protein_sequence'] = $protein_sequence;
				$node['number_of_interactions_in_database'] = $number_of_interactions_in_database;
				$node['annotation_array'] = $node_annotation_array;
				
				$in_array = in_array($protein_gene_name, $query_protein_gene_name_array);
				
				if($in_array){
				    $query_node_array[$protein_id] = $node;
				}else{
				    $interactor_node_array[$protein_id] = $node;
				}	
				
			}
			
			$node_array = $interactor_node_array + $query_node_array;
		}
		
		return $node_array;
	}
	
	public function interactionEdgeHandeler($interaction_array, $node_array, $query_protein_gene_name_array){

		$edge_array = array();

		if($interaction_array){
		    $query_edge_array = array();
		    $interactor_edge_array = array();
		    $multi_query_edge_array = array();
		    
			foreach($interaction_array as $interaction){

			    $interaction_id_array[] = $interaction['id'];
			    
			    $interactor_A_id = $interaction['interactor_A'];
			    $interactor_B_id = $interaction['interactor_B'];
			    	
			    $interactor_A = $node_array[$interactor_A_id];
			    	
			    $interactor_A_id = $interactor_A['protein_id'];
			    $interactor_A_uniprot_id = $interactor_A['protein_uniprot_id'];
			    $interactor_A_gene_name = $interactor_A['protein_gene_name'];
			    $interactor_A_ensembl_id = $interactor_A['protein_ensembl_id'];
			    	
			    $interactor_A_array = array();
			    $interactor_A_array['protein_id'] = $interactor_A_id;
			    $interactor_A_array['protein_uniprot_id'] = $interactor_A_uniprot_id;
			    $interactor_A_array['protein_gene_name'] = $interactor_A_gene_name;
			    $interactor_A_array['protein_ensembl_id'] = $interactor_A_ensembl_id;
			    	
			    $interactor_B = $node_array[$interactor_B_id];
			    $interactor_B_id = $interactor_B['protein_id'];
			    $interactor_B_uniprot_id = $interactor_B['protein_uniprot_id'];
			    $interactor_B_gene_name = $interactor_B['protein_gene_name'];
			    $interactor_B_ensembl_id = $interactor_B['protein_ensembl_id'];
			    	
			    $interactor_B_array = array();
			    $interactor_B_array['protein_id'] = $interactor_B_id;
			    $interactor_B_array['protein_uniprot_id'] = $interactor_B_uniprot_id;
			    $interactor_B_array['protein_gene_name'] = $interactor_B_gene_name;
			    $interactor_B_array['protein_ensembl_id'] = $interactor_B_ensembl_id;
			    	
			    $interaction_id = $interaction['id'];
			    $score = $interaction['score'];
			    	
			    $edge = array();
			    
			    $edge['interaction_id'] = $interaction_id;
			    $edge['interactor_A'] = $interactor_A_array;
			    $edge['interactor_B'] = $interactor_B_array;
			    $edge['score'] = $score;
			    $edge['annotation_array'] = [];
			    $edge['experiment_array'] = [];
			    $edge['dataset_array'] = [];
			    $edge['interaction_category_array'] = [];
			    $edge_array[$interaction_id] = $edge;
			        
			    $in_array_interactor_A = in_array($interactor_A_gene_name, $query_protein_gene_name_array);
			    $in_array_interactor_B = in_array($interactor_B_gene_name, $query_protein_gene_name_array);

			    if ($in_array_interactor_A && $in_array_interactor_B){	
			        $multi_query_edge_array[$interaction_id] = $edge;   
			    }elseif($in_array_interactor_A){
			        $query_edge_array[$interaction_id] = $edge;
			    }elseif($in_array_interactor_B){
			        $edge['interactor_A'] = $interactor_B_array;
			        $edge['interactor_B'] = $interactor_A_array;
			        $query_edge_array[$interaction_id] = $edge;    
			    }else{ 
			        $interactor_edge_array[$interaction_id] = $edge;
			    }		        	    
			}

			$edge_array = $multi_query_edge_array + $query_edge_array + $interactor_edge_array;

		    $interaction_id_string = join(',', $interaction_id_array);
		    $interaction_id_string = "'" . str_replace(",", "','", $interaction_id_string) . "'";
		    //$experiment_array = self::getInteractionArrayExperiments($interaction_array);
		    $annotation_array = self::getInteractionAnnotation($interaction_id_string);
		    $dataset_array = self::getInteractionArrayDatasets($interaction_id_string);
		    $interaction_category_array = self::getInteractionArrayCategoryStatus($interaction_id_string);

			foreach($edge_array as $interaction_id  => $edge){
            /*
				if(array_key_exists($interaction_id, $experiment_array)){
				    $edge_array[$interaction_id]['experiment_array'] = $experiment_array[$interaction_id];
				}*/
			    if(array_key_exists($interaction_id, $annotation_array)){
			        $edge_array[$interaction_id]['annotation_array'] = $annotation_array[$interaction_id];
			    }else{
			        $edge_array[$interaction_id]['annotation_array'] = array();
			    }
			  
				if(array_key_exists($interaction_id, $dataset_array)){
				    $edge_array[$interaction_id]['dataset_array'] = $dataset_array[$interaction_id];
				}
				if(array_key_exists($interaction_id, $interaction_category_array)){
				    $edge_array[$interaction_id]['interaction_category_array'] = $interaction_category_array[$interaction_id];
				}
			}
		}
		return $edge_array;
	}
	
	
	
	public function getInteractionArrayDatasets($interaction_id_string){
	    $dataset_array = array();
	    $repository = $this->getDoctrine()->getRepository('AppBundle:Dataset');
	    $dataset_result_array = $repository->findAll();
	
	    foreach($dataset_result_array as $dataset_result){
	        $dataset_id = $dataset_result->getId();
	        $dataset_pubmed_id = $dataset_result->getPubmedId();
	        $dataset_name = $dataset_result->getName();
	        $dataset_author = $dataset_result->getAuthor();
	        $dataset_year = $dataset_result->getYear();
	        $dataset_interaction_status = $dataset_result->getInteractionStatus();
	        $dataset_description = $dataset_result->getDescription();
	        $dataset_values = array();
	        $dataset_values['dataset_reference'] = $dataset_pubmed_id;
	        if($dataset_author){
	            $dataset_values['dataset_author'] = $dataset_author;
	        }else{
	            $dataset_values['dataset_author'] = 'Unpublished Dataset';
	        }
	        $dataset_values['year'] = $dataset_year;
	        $dataset_values['description'] = $dataset_description;
	        $dataset_values['interaction_status'] = $dataset_interaction_status;
	        $dataset_values['name'] = $dataset_name;
	        	
	        $dataset_array[$dataset_id] = $dataset_values;
	
	    }
	
	    $functions = $this->get('app.functions');
	    $connection =  $functions->mysql_connect();
	    $result = $connection->query("SELECT * FROM interaction_dataset WHERE `interaction_id` IN ($interaction_id_string)");
	    $dataset_return_array = array();
	    if($result){
	        while($row = $result->fetch_assoc()) {
	            $interaction_id = $row['interaction_id'];
	            $dataset_id = $row['dataset_id'];
	            $dataset_return_array[$interaction_id][] = $dataset_array[$dataset_id];
	        }
	    }
	
	    return  $dataset_return_array;

	}
	
	
	public function getInteractionArrayCategoryStatus($interaction_id_string){
	
	    $repository = $this->getDoctrine()->getRepository('AppBundle:Interaction_Category');
	    $interaction_category_result_array = $repository->findAll();
	    $interaction_category_array = array();
	    foreach($interaction_category_result_array as $interaction_category_result){
	        	
	        $interaction_category_values = array();
	        $interaction_category_id = $interaction_category_result->getId();
	        $interaction_category_values['category_name'] = $interaction_category_result->getCategoryName();
	        $interaction_category_values['order'] = $interaction_category_result->getOrder();
	        $interaction_category_array[$interaction_category_id] = $interaction_category_values;
	    }
	
	    $functions = $this->get('app.functions');
	    $connection =  $functions->mysql_connect();
	    $query = "SELECT * FROM `interaction_interaction_category` WHERE `interaction_id` IN ($interaction_id_string)";
	    $result = $connection->query($query);
	    $interaction_category_return_array = array();
	    
	    
	    if($result){
	        while($row = $result->fetch_assoc()) {
	            $interaction_id = $row['interaction_id'];
	            $interaction_category_id = $row['interaction_category_id'];
	            $order = $interaction_category_array[$interaction_category_id]['order'];
	            $category_name = $interaction_category_array[$interaction_category_id]['category_name'];
	            if(array_key_exists($interaction_id, $interaction_category_return_array)){
	                $highest_order = $interaction_category_return_array[$interaction_id]['highest_order'];       	
	                if ($order > $highest_order){
	                    $interaction_category_return_array[$interaction_id]['highest_category_status'] = $category_name;
	                    $interaction_category_return_array[$interaction_id]['highest_order'] = $order;
	                }
	            }else{
	                $interaction_category_return_array[$interaction_id]['highest_category_status'] = $category_name;
	                $interaction_category_return_array[$interaction_id]['highest_order'] = $order;     	
	            }

	            $interaction_category_return_array[$interaction_id]['interaction_category_array'][] = $interaction_category_array[$interaction_category_id];
	        }
	    }
	    
	    
	    
	    return $interaction_category_return_array;
	}
	
	public function getInteractionAnnotation($interaction_id_string){
	    
	    $functions = $this->get('app.functions');
	    $connection =  $functions->mysql_connect();
	    $query = "SELECT * FROM `annotation` WHERE `identifier` IN ($interaction_id_string)";
	    $result = $connection->query($query);
	    
	    $interaction_annotation_return_array[] = array();
	    
	    if($result){
	        while($row = $result->fetch_assoc()) {
	            $interaction_id = $row['identifier'];
	            $annotation = $row['annotation'];
	            $type = $row['type_name'];
	            if(!array_key_exists($interaction_id, $interaction_annotation_return_array)){
	                $interaction_annotation_return_array[$interaction_id] = array();
	            }
	            if(!array_key_exists($type, $interaction_annotation_return_array[$interaction_id])){
	                $interaction_annotation_return_array[$interaction_id][$type] = array();
	            }
	            if(!in_array($annotation, $interaction_annotation_return_array[$interaction_id][$type])){
	                $interaction_annotation_return_array[$interaction_id][$type][] = $annotation;
	            }
	        }
	    } 
	    
	    return $interaction_annotation_return_array;    
	}

	public function getInteractionArrayExperiments($interaction_array){
		$interaction_or_array = array();
		
		foreach($interaction_array as $interaction){
			$interaction_id = $interaction['id'];
			$interaction_or_array[] = "i.id = '$interaction_id'";
		}
		
		$interaction_or_string = join(' OR ', $interaction_or_array);
		
		$experiment_array = array();
		$em = $this->getDoctrine()->getManager();
		
		$query_string = "SELECT ex FROM AppBundle:Experiment ex LEFT JOIN ex.interaction i WHERE $interaction_or_string";
		
		$query = $em->createQuery($query_string);
				
		$experiment_result_array = $query->getResult();
		
		foreach($experiment_result_array as $experiment_result){
			$id = $experiment_result->getId();
			$interaction_id = $experiment_result->getInteraction()->getId();
			$orf_id_A = $experiment_result->getOrfA();
			$orf_id_B = $experiment_result->getOrfB();
			$assay_version = $experiment_result->getAssayVersion();
			$num_screens = $experiment_result->getNumScreens();
			$dna_binding_domain_name = $experiment_result->getDnaBindingDomain()->getGeneName();
			$activation_domain_name = $experiment_result->getActivationDomain()->getGeneName();
			$dataset_name = $experiment_result->getDataset()->getName();
			
			$experiment_values = array();
			$experiment_values['id'] = $id;
			$experiment_values['orf_id_A'] = $orf_id_A;
			$experiment_values['orf_id_B'] = $orf_id_B;
			$experiment_values['num_screens'] = $num_screens;
			$experiment_values['dna_binding_domain_name'] = $dna_binding_domain_name;
			$experiment_values['activation_domain_name'] = $activation_domain_name;
			$experiment_values['assay_version'] = $assay_version;
			$experiment_values['dataset'] = $dataset_name;
			$experiment_array[$interaction_id][] = $experiment_values;
			
		}
			
		return  $experiment_array;
		
	}
	
	public function getFoundProteins($query_parameters){
		
		$search_term_array = $query_parameters->getSearchTermArray();
		
		$return_array = array();
		$unfound_protein_array = array();
		$found_protein_array = array();

		$search_term_string = join(', ', $search_term_array);
		$search_term_string = "'" . str_replace(",", "','", $search_term_string) . "'";
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery("SELECT i FROM AppBundle:Identifier i WHERE i.identifier IN (:identifier)");
		$query->setParameter('identifier', $search_term_string);
		$results = $query->getResult();
		
		foreach($search_term_array as  $search_term){
			
			$protein_exists = self::assertProteinExists($search_term);
			
			if($protein_exists == false){
				$unfound_protein_array[] = $search_term;
			}elseif($protein_exists == true){
				$found_protein_array[] = $search_term;

			}
		}
		$unfound_protein_summary = join(", ", $unfound_protein_array);
		if($unfound_protein_summary == ''){$unfound_protein_summary = 'None';}
		$found_protein_summary = join(", ", $found_protein_array);
		if($found_protein_summary == ''){$found_protein_summary = 'None';}
		
		$return_array['unfound_protein_array'] = $unfound_protein_summary;
		$return_array['found_protein_array'] = $found_protein_summary;
		
		return $return_array;
		
	}
		
	public function assertProteinExists($search_term){
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery("SELECT i FROM AppBundle:Identifier i WHERE i.identifier = :identifier");
		$query->setParameter('identifier', $search_term);
		$results = $query->getResult();
		$return = false;
		if($results){$return = true;}
		return $return;
	}

	public function getQueryParameters($search_term, $request){
		
		$search_term_array = explode(",", $search_term);
		$search_term_summary = join(', ', $search_term_array);
		
		$filter_parameter = $request->query->get('filter');
		$score_parameter = $request->query->get('score');
		$text_output = $request->query->get('output');
		
		if($filter_parameter == null){$filter_parameter = 'None';}
		if($score_parameter == null){$score_parameter = 0;}
		$interaction_category_parameter_array_and_summary = self::getInteractionCategoryParameterArrayAndSummary($request);
		$category_parameter_array = $interaction_category_parameter_array_and_summary[0];
		$category_summary = $interaction_category_parameter_array_and_summary[1];
		
		$annotatation_parameter_array_and_summary = self::getAnnotationParameterArrayAndSummary($request);
		$annotatation_parameter_array = $annotatation_parameter_array_and_summary[0];
		$annotatation_parameter_summary = $annotatation_parameter_array_and_summary[1];
		/*
		$tissue_expression_parameter_array_and_summary = self::getTissueExpressionParameterArrayAndSummary($request);
		$tissue_expression_parameter_array = $tissue_expression_parameter_array_and_summary[0];
		$tissue_expression_summary = $tissue_expression_parameter_array_and_summary[1];
		$subcellular_location_expression_parameter_array_and_summary = self::getSubcellularLocationParameterArrayAndSummary($request);
		$subcellular_location_expression_parameter_array = $subcellular_location_expression_parameter_array_and_summary[0];
		$subcellular_location_expression_summary = $subcellular_location_expression_parameter_array_and_summary[1];
		*/
		$query_parameters = $this->get('app.queryparameters');
		
		$query_parameters->setFilterParameter($filter_parameter);
		$query_parameters->setCategoryArray($category_parameter_array);
		$query_parameters->setAnnotationArray($annotatation_parameter_array);
		$query_parameters->setAnnotationSummary($annotatation_parameter_summary);
		$query_parameters->setScoreParameter($score_parameter);
		$query_parameters->setSearchTermParameter($search_term);
		$query_parameters->setSearchTermSummary($search_term_summary);
		$query_parameters->setSearchTermArray($search_term_array);
		$query_parameters->setCategorySummary($category_summary);
		$query_parameters->setTextOutput($text_output);
		//$query_parameters->setTissueExpressionSummary($tissue_expression_summary);
		//$query_parameters->setSubcellularLocationExpressionArray($subcellular_location_expression_parameter_array);
		//$query_parameters->setSubcellularLocationExpressionSummary($subcellular_location_expression_summary);
		
		return $query_parameters;
	}
	
	public function getAnnotationParameterArrayAndSummary($request){

		$annotation_types = self::getAnnotationTypes();
		$annotation_field_array = self::getAnnotationFieldArray($annotation_types);
		
		$annotation_array = array();
		$annotation_parameter_summary_array = array();

		foreach($annotation_field_array as $annotation_type){
	
			foreach($annotation_type as $annotation_field){
				$annotation_field_value = $request->query->get("$annotation_field");
				if($annotation_field_value == true){
					
					$annotation_array[$annotation_field] = true;
					$annotation_parameter_summary_array[] = $annotation_field;
					
				}else{
					$annotation_array[$annotation_field] = false;
					
				}			
			}
		}
		
		$annotation_summary = join(', ', $annotation_parameter_summary_array);
		$return_array = array($annotation_array, $annotation_summary);
		
		return $return_array;
		
	}
	
	public function getAnnotationFieldArray($annotation_types){
		
		$annotation_field_array = array();
		
		foreach($annotation_types as $annotation_type){
			$type = $annotation_type->getType();
			$show_in_filter = $annotation_type->getShowInFilter();
			
			if($show_in_filter == '1'){
				
				$field_array_json = $annotation_type->getFields();
				$field_array_json = str_replace("'","\"",$field_array_json);
				$field_array = json_decode($field_array_json, true);
				$annotation_field_array[$type] = $field_array;
			}
		}
		return $annotation_field_array;
	}
	
	
	public function getAnnotationFormArray($annotation_types){
		
		$annotation_field_array = array();
		
		foreach($annotation_types as $annotation_type){
			$label= $annotation_type->getLabel();
			
			$show_in_filter = $annotation_type->getShowInFilter();
			$description = $annotation_type->getDescription();
			
			if($show_in_filter == '1'){
				
				$field_array_json = $annotation_type->getFields();
				$field_array_json = str_replace("'","\"",$field_array_json);
				$field_array = json_decode($field_array_json, true);
				$annotation_field_array[] = array($label, $description, $field_array);
			}
		}
		return $annotation_field_array;
	}
	
	public function getInteractionCategoryParameterArrayAndSummary($request){
		
		$interaction_categories = $this->getDoctrine()
		->getRepository('AppBundle:Interaction_Category')
		->findAll();
		
		$category_parameter_array = array();
		$category_parameter_summary_array = array();
		
		foreach ($interaction_categories as $interaction_category){
			$category_name = $interaction_category->getCategoryName();
			$category_name_lowercase = strtolower($category_name);
			$category = $request->query->get("$category_name_lowercase");
			if($category == 'false'){
				$category_parameter_array[$category_name] = array(false) ;
			}else{
				$category_parameter_array[$category_name] = array(true);
				$category_parameter_summary_array[] = $category_name;
			}
		}
		$category_summary = join(', ', $category_parameter_summary_array);
		$return_array = array($category_parameter_array, $category_summary);
		
		return $return_array;
		
	}
	
	public function getAnnotationTypes(){
		
		$annotation_types = $this->getDoctrine()
		->getRepository('AppBundle:Annotation_Type')
		->findAll();
		
		return $annotation_types;
		
	}
	
	public function getAnnotationTypesArray(){

		$annotation_types = $this->getDoctrine()
		->getRepository('AppBundle:Annotation_Type')
		->findAll();

		$annotation_type_array = array();
		json_encode($annotation_types);
		foreach($annotation_types as $annotation_type){
			
			$type = $annotation_type->getType();
			$label = $annotation_type->getLabel();
			$show_in_filter = $annotation_type->getShowInFilter();
			$show_in_table = $annotation_type->getShowInTable();
			$fields = $annotation_type->getFields();
			
			
			$annotation_type_array[$type]['label'] = $label;
			$annotation_type_array[$type]['show_in_filter'] = $show_in_filter;
			$annotation_type_array[$type]['show_in_table'] = $show_in_table;
			$annotation_type_array[$type]['fields'] = $fields;
			$annotation_type_array[$type]['type'] = $type;
			
		}
		return $annotation_type_array;	
	}
	
	public function getInteractionCategories(){
		
		$interaction_categories_array = array();
		$interaction_categories = $this->getDoctrine()
		->getRepository('AppBundle:Interaction_Category')
		->findAll();
		foreach ($interaction_categories as $interaction_category){
			
			
			$interaction_category_order = $interaction_category->getOrder();
			$interaction_category_name = $interaction_category->getCategoryName();
			$interaction_category_color_scheme = $interaction_category->getColorScheme();
			$interaction_category_selected_by_default = $interaction_category->getSelectedByDefault();
			
			$interaction_categories_array[$interaction_category_name] = array('category_name' => $interaction_category_name, 'order' => $interaction_category_order, 'color_scheme' => $interaction_category_color_scheme, 'selected_by_default' => $interaction_category_selected_by_default);
			
		}
		
		return $interaction_categories_array;
	}
	
		
	public function checkLoginStatus(){
		$login_status = false;
		$is_fully_authenticated = $this->get('security.context')
		->isGranted('IS_AUTHENTICATED_FULLY');
		if($is_fully_authenticated){
			$login_status =  true;
		}
		return $login_status;
	}
	
	public function checkAdminStatus(){
		$admin_status = false;
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			$admin_status = true;
		}
		return $admin_status;
	}
	
	public function getAdminSettings(){
		
		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		return $admin_settings;
	}
	
	
	public function getSQLQueryResult($query){
		
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		$result = $connection->query($query);
		mysqli_close($connection);
		
		return $result;
		
	}
	
	public function getComplexesForInteractors($nodes){
	    $query = self::getComplexesForInteractorSQLQuery($nodes);
	    $result = self::getSQLQueryResult($query);
	    $complex_array = self::getComplexArrayFormQueryResults($result);
	    $return_array = self::getComplexReturnArray($complex_array);
	    return $return_array;
	}
	
	public function getComplexesForInteractorSQLQuery($nodes){
	    $complex_or_array = array();
	    foreach($nodes as $node){
	        $protein_id = $node['protein_id'];
	        $complex_or_array[] = "complex_protein.protein_id = '$protein_id'";
	    }
	    $complex_or_statement = join(' OR ', $complex_or_array);
	    $query = "SELECT * FROM `complex` INNER JOIN `complex_protein` ON complex.id = complex_protein.complex_id WHERE $complex_or_statement";
	    return $query;
	}
	
	public function getComplexArrayFormQueryResults($result){
	    $complex_array = array();
	    if($result){
	        while($row = $result->fetch_assoc()) {
	            $complex_array[] = $row;
	        }
	    }
	    return $complex_array;
	}
	
	public function getComplexReturnArray($complex_array){
	    $return_array = array();
	    foreach($complex_array as $complex){
	        $protein_id = $complex['protein_id'];
	        $complex_id = $complex['id'];
	        $return_array['protein_complex'][$protein_id][] = $complex_id;
	        $return_array['complex_protein'][$complex_id][] = $protein_id;
	        $return_array['complex'][$complex_id]['complex_id'] = $complex['id'];
	        $return_array['complex'][$complex_id]['name'] = $complex['name'];
	        $return_array['complex'][$complex_id]['description'] = $complex['description'];
	    }
	    return $return_array;
	}
	
	
	public function getDomainForInteractions($edges){
	    $functions = $this->get('app.functions');
	    $connection =  $functions->mysql_connect();
	    $domain_or_array = array();
	    
	    /*
	     foreach($edges as $edge){
	     
	     $interaction_id = $edge['interaction_id'];
	     
	     $domain_or_array[] = "interaction_id = $interaction_id";
	     }
	     $domain_or_statement = join(' OR ', $domain_or_array);
	     
	     $query = "SELECT * FROM `domain` WHERE $domain_or_statement";
	     */
	    
	    
	    foreach($edges as $edge){
	        $interaction_id = $edge['interaction_id'];
	        $domain_or_array[] = "`interaction_domain`.interaction_id = '$interaction_id'";
	    }
	    $domain_or_statement = join(' OR ', $domain_or_array);
	    $query = "SELECT * FROM `domain` INNER JOIN `interaction_domain` ON `domain`.id=`interaction_domain`.domain_id WHERE $domain_or_statement";
	    $result = $connection->query($query);
	    $domain_array = array();
	    if($result){
	        while($row = $result->fetch_assoc()) {
	            
	            $domain_array[$row['protein_id']][] = $row;
	        }
	    }
	    mysqli_close($connection);
	    
	    return $domain_array;
	    
	}

}
?>	