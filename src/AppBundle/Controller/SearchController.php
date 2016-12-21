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
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\ChoiceList\ArrayChoiceList;


/**
 * Search controller.

 */
class SearchController extends Controller
{
	/**
	 * Search Home
	 *
	 * @Route("/search/", name="search")
	 * @Route("/admin/search/", name="admin_search")
	 * @Method({"GET", "POST"})
	 */
	public function searchAction(Request $request)
	{

	    $form = $this->createForm('AppBundle\Form\SearchType');
        $form->handleRequest($request);
		
		if ($form->isSubmitted()) {
		   
		    $option_array = self::getSearchFormData($form);
			return $this->redirectToRoute('search_results', $option_array);

		}
		
		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
		$example_1 = $admin_settings->getExample1();
		$example_2 = $admin_settings->getExample2();
		$example_3 = $admin_settings->getExample3();
		
		$login_status = false;
		
		$is_fully_authenticated = $this->get('security.context')
		->isGranted('IS_AUTHENTICATED_FULLY');
		
		if($is_fully_authenticated){
		    $login_status =  true;
		}
		
		return $this->render('search.html.twig', array(
				'form' => $form->createView(),
		        'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
		        'short_title' => $short_title,
		        'title' => $title,
		        'footer' => $footer,
		        'login_status' => $login_status,
		        'example_1' => $example_1,
		        'example_2' => $example_2,
		        'example_3' => $example_3
				
		));
	}
	

	/**
	 * Search Results
	 *
	 * @Route("/search_results/{search_term}", name="search_results", options={"expose": true})
	 * @Route("/admin/search_results/{search_term}", name="admin_search_results", options={"expose": true})
	 * @Method({"GET", "POST"})
	 */
	public function searchResultsAction($search_term)
	{
	
	    //search input
	    $search_query = $search_term;
	     
	    //search parameters
	    $request = $this->getRequest();

	   
	    
	    
	    $query_parameters_array = self::getQueryParameters($request);
	    
	    $search_published = $query_parameters_array[0];
	    $search_validated = $query_parameters_array[1];
	    $search_verified = $query_parameters_array[2];
	    $search_literature = $query_parameters_array[3];
	    $search_filter = $query_parameters_array[4];
	    $search_setting_score = $query_parameters_array[5];
	   
	    
	    $query_parameter_summary = self::getQueryParameterSummary($search_filter, $search_setting_score, $search_published, $search_validated, $search_verified, $search_literature);
	    
	    

	    $status_array = array($search_published, $search_validated, $search_verified, $search_literature, $search_setting_score);
	    
	    
	    
	    
	    $search_query_array = explode(",", $search_term);
	    

	    
	    $nodes_edges = self::getNodesAndEdges($search_query_array, $search_filter, $status_array);
	    
	    $nodes = $nodes_edges[0];
	    $edges = $nodes_edges[1];
	    $interaction_array = $nodes_edges[2];

	    
	    $nodes = array_map("unserialize", array_unique(array_map("serialize", $nodes)));
	    $edges = array_map("unserialize", array_unique(array_map("serialize", $edges)));
	    $interaction_array = array_map("unserialize", array_unique(array_map("serialize", $interaction_array)));
	    
	    $nodes = array_values($nodes);
	    $edges = array_values($edges);
	    $interaction_array = array_values($interaction_array);

        $edges = self::getUniqueEdges($edges);
        $edges = array_values($edges);

        
	    $number_of_nodes = count($nodes);
	    $number_of_edges = count($edges);

	    
	    $json = json_encode(array('nodes' => $nodes, 'edges' => $edges), JSON_HEX_QUOT);
	     
	
	    //Get admin settings
        $admin_settings = $this->getDoctrine()
        ->getRepository('AppBundle:Admin_Settings')
        ->find(1);
        	
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
        
        //Check login status
        $login_status = false;
        
        $is_fully_authenticated = $this->get('security.context')
        ->isGranted('IS_AUTHENTICATED_FULLY');
        
        if($is_fully_authenticated){
            $login_status =  true;
        }
        	

        return $this->render('search_result_2.html.twig', array(
                'interaction_array' => $interaction_array,
                'number_of_nodes' => $number_of_nodes,
                'number_of_edges' => $number_of_edges,
                'json' => $json,
                'search_query' => $search_query,
                'parameters' => $query_parameter_summary,
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme, 
                'short_title' => $short_title,
                'title' => $title,
                'footer' => $footer,
                'search_query' => $search_query,
                'search_setting_score' => $search_setting_score,
	            'login_status' => $login_status,

        ));
	
	}
	
	/**
	 * Autocomplete
	 *
	 * @Route("/search/autocomplete/{search_term}", name="autocomplete_search")
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
	 * Protein Sequence
	 *
	 * @Route("/protein_sequence/{search_term}", name="protein_sequence", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function protein_sequenceAction($search_term)
	{
	    $identifier_repository = $this->getDoctrine()
	    ->getRepository('AppBundle:Identifier');
	
	    $identifier = $identifier_repository->findOneByIdentifier($search_term);
	    $identifier_identifier = $identifier->getIdentifier();
	    $identifier_naming_convention = $identifier->getNamingConvention();
	    $protein = $identifier->getProtein();
	    $protein_gene_name = $protein->getGeneName();
	    $protein_id = $protein->getId();
	    $protein_name = $protein->getName();
	    $protein_sequence = $protein->getSequence();
	    $protein_description = $protein->getDescription();
	     
	    $admin_settings = $this->getDoctrine()
	    ->getRepository('AppBundle:Admin_Settings')
	    ->find(1);
	     
	    $main_color_scheme = $admin_settings->getMainColorScheme();
	    $header_color_scheme = $admin_settings->getHeaderColorScheme();
	    $logo_color_scheme = $admin_settings->getLogoColorScheme();
	    $button_color_scheme = $admin_settings->getButtonColorScheme();
	    $short_title = $admin_settings->getShortTitle();
	    $title = $admin_settings->getTitle();
	     
	    $login_status = false;
	
	    $is_fully_authenticated = $this->get('security.context')
	    ->isGranted('IS_AUTHENTICATED_FULLY');
	
	    if($is_fully_authenticated){
	        $login_status =  true;
	    }
	     
	    return $this->render('protein_sequence.html.twig', array(
	            'protein_sequence' => $protein_sequence,
	            'gene_name' => $protein_gene_name,
	            'main_color_scheme' => $main_color_scheme,
	            'header_color_scheme' => $header_color_scheme,
	            'logo_color_scheme' => $logo_color_scheme,
	            'button_color_scheme' => $button_color_scheme,
	            'short_title' => $short_title,
	            'title' => $title,
	            'login_status' => $login_status
	
	    ));
	}
	
	public function getNodesAndEdges($search_query_array, $filter, $status_array){

	    $nodes_edges = array();
	    $query_protein_array = self::getProteinQueryArray($search_query_array);

	    switch ($filter) {
            case 'query_query':
                $nodes_edges = self::getQueryQueryNodesAndEdges($query_protein_array, $status_array);
                break;
                
            case 'None':
                $nodes_edges = self::getInteractorInteractorNodesAndEdges($query_protein_array, $status_array);
                break;
                
            default:
            
	    }
	   
	    return $nodes_edges;
	}
	
	public function getProteinQueryArray($search_query_array){
	
	    $query_protein_array = array();
	     
	    foreach($search_query_array as $query_protein){
	
	        $identifier_repository = $this->getDoctrine()
	        ->getRepository('AppBundle:Identifier');
	        $identifier = $identifier_repository->findOneByIdentifier($query_protein);
	         
	        if($identifier){

	            $protein = $identifier->getProtein();
	            $query_protein_array[] = $protein;
             
	        }
	    }
	     
	    return $query_protein_array;
	     
	}
	
	public function getQueryQueryNodesAndEdges($query_protein_array, $status_array){
	    
	    $node_array = array();
	    $edge_array = array();
	    $interaction_array = array();
	    
		foreach($query_protein_array as  $query_protein_A){
		        
	        $protein_A_id =  $query_protein_A->getId();
	        $protein_A_name =  $query_protein_A->getName();
	        $protein_A_gene_name =  $query_protein_A->getGeneName();
	        $protein_A_description = $query_protein_A->getDescription();
	        $protein_A_external_links = self::getExternalLinks($protein_A_id);
	        $external_links = self::getExternalLinks($protein_A_id);
	        
	        
	        $node_array[] = array($protein_A_id, $protein_A_name, $protein_A_gene_name, $protein_A_description, $external_links);
        
	        foreach($query_protein_array as $query_protein_B){
	             
    	        $protein_B_id =  $query_protein_B->getId();
    	        $protein_B_name =  $query_protein_B->getName();
	            $protein_B_gene_name =  $query_protein_B->getGeneName();
	            $protein_B_description = $query_protein_B->getDescription();
	            $protein_B_external_links = self::getExternalLinks($protein_B_id);
	            
	            $interaction = self::getInteraction($query_protein_A, $query_protein_B, $status_array);

	            if($interaction){
	                $interaction_id = $interaction->getId();
	                $score = $interaction->getScore();
	                $dataset_array = self::getInteractionDatasets($interaction_id);
	                $interactor_A_array = array('id' => $protein_A_id, 'name' => $protein_A_name, 'gene_name' => $protein_A_gene_name, 'description' => $protein_A_description, 'links' => $protein_A_external_links);
	                $interactor_B_array = array('id' => $protein_B_id, 'name' => $protein_B_name, 'gene_name' => $protein_B_gene_name, 'description' => $protein_B_description, 'links' => $protein_B_external_links);
	                 
	                $interaction_array[] = array("interactor_A_id"=> $protein_A_id, "interactor_A_gene_name"=>$protein_A_gene_name, "interactor_A_array" => $interactor_A_array, "interactor_B_id"=> $protein_B_id, "interactor_B_gene_name"=>$protein_B_gene_name, "interactor_B_array" => $interactor_B_array, "score"=>$score, "dataset_array"=>$dataset_array);
	                $edge_array[] = array($protein_A_id, $protein_A_name, $protein_B_id, $protein_B_name, $score);
	            }
	        }
	    }
	    
	    return array($node_array, $edge_array, $interaction_array);
	}
	
	public function getQueryInteractorNodesAndEdges($query_protein_array, $status_array){
	     
	    $node_array = array();
	    $edge_array = array();
	    $interaction_array = array();
	    
		foreach($query_protein_array as  $query_protein_A){
		        
	        $protein_A_id =  $query_protein_A->getId();
	        $protein_A_name =  $query_protein_A->getName();
	        $protein_A_gene_name =  $query_protein_A->getGeneName();
	        $protein_A_description = $query_protein_A->getDescription();
	        $protein_A_external_links = self::getExternalLinks($protein_A_id);
	        
	        $node_array[] = array($protein_A_id, $protein_A_name, $protein_A_gene_name, $protein_A_description, $protein_A_external_links);
	        
	        $interactions = self::getInteractions($query_protein_A, $status_array);
	        if($interactions){
        	    foreach($interactions as $interaction){
        	         $interaction_id = $interaction->getId();
                     $interactor_B = $interaction->getInteractorB();
                     $score = $interaction->getScore();
                     
        	         $protein_B = $this->getDoctrine()
        	         ->getRepository('AppBundle:Protein')
        	         ->find($interactor_B);
        	          
        	         $protein_B_id = $protein_B->getId();
        	         $protein_B_name = $protein_B->getName();
        	         $protein_B_gene_name =  $protein_B->getGeneName();
        	         $protein_B_description = $protein_B->getDescription();
        	         $protein_B_external_links = self::getExternalLinks($protein_B_id);
        	         
        	         $dataset_array = self::getInteractionDatasets($interaction_id);
        	         
        	         $interactor_A_array = array('id' => $protein_A_id, 'name' => $protein_A_name, 'gene_name' => $protein_A_gene_name, 'description' => $protein_A_description, 'links' => $protein_A_external_links);
        	         $interactor_B_array = array('id' => $protein_B_id, 'name' => $protein_B_name, 'gene_name' => $protein_B_gene_name, 'description' => $protein_B_description, 'links' => $protein_B_external_links);
        	          
        	         $interaction_array[] = array("interactor_A_id"=> $protein_A_id, "interactor_A_gene_name"=>$protein_A_gene_name, "interactor_A_array" => $interactor_A_array, "interactor_B_id"=> $protein_B_id, "interactor_B_gene_name"=>$protein_B_gene_name, "interactor_B_array" => $interactor_B_array, "score"=>$score, "dataset_array"=>$dataset_array);
        	         
        	         
        	        
        	         $node_array[] = array($protein_B_id, $protein_B_name, $protein_B_gene_name, $protein_B_description, $protein_B_external_links);
    	             $edge_array[] = array($protein_A_id, $protein_A_name, $protein_B_id, $protein_B_name, $score);
    
        	     }
	        }
		}
	    return array($node_array, $edge_array, $interaction_array);
	     
	}
	
	public function getInteractorInteractorNodesAndEdges($query_protein_array, $status_array){
	    
	    
	    $handle = fopen('C:\\Users\\Miles\\Desktop\\test\\test.txt', 'w');
	    fwrite($handle, 'START');
	    
	    $node_array = array();
	    $edge_array = array();
	    $interaction_array = array();
	    $interactor_array = array();
	    
		foreach($query_protein_array as  $query_protein_A){
		    fwrite($handle, '1');
	        $protein_A_id =  $query_protein_A->getId();
	        $protein_A_name =  $query_protein_A->getName();
	        $protein_A_gene_name =  $query_protein_A->getGeneName();
	        $protein_A_description = $query_protein_A->getDescription();
	        $protein_A_external_links = self::getExternalLinks($protein_A_id);
	        
	        $interactor_array[] = $query_protein_A;
	        $node_array[] = array($protein_A_id, $protein_A_name, $protein_A_gene_name, $protein_A_description, $protein_A_external_links);
	        
	        $interactions = self::getInteractions($query_protein_A, $status_array);
            if($interactions){
                fwrite($handle, '2');
        	    foreach($interactions as $interaction){
        	        fwrite($handle, '3');
        	         $interaction_id = $interaction->getId();
                     $interactor_B = $interaction->getInteractorB();
                     $score = $interaction->getScore();
                     
        	         $protein_B = $this->getDoctrine()
        	         ->getRepository('AppBundle:Protein')
        	         ->find($interactor_B);
        	          
        	         $protein_B_id = $protein_B->getId();
        	         $protein_B_name = $protein_B->getName();
        	         $protein_B_gene_name =  $protein_B->getGeneName();
        	         $protein_B_description = $protein_B->getDescription();
        	         $protein_B_external_links = self::getExternalLinks($protein_B_id);
        	         
        	         $interactor_array[] = $protein_B;
        	         
        	         $dataset_array = self::getInteractionDatasets($interaction_id);
        	         
        	         $interactor_A_array = array('id' => $protein_A_id, 'name' => $protein_A_name, 'gene_name' => $protein_A_gene_name, 'description' => $protein_A_description, 'links' => $protein_A_external_links);
        	         $interactor_B_array = array('id' => $protein_B_id, 'name' => $protein_B_name, 'gene_name' => $protein_B_gene_name, 'description' => $protein_B_description, 'links' => $protein_B_external_links);
        	          
        	         $interaction_array[] = array("interactor_A_id"=> $protein_A_id, "interactor_A_gene_name"=>$protein_A_gene_name, "interactor_A_array" => $interactor_A_array, "interactor_B_id"=> $protein_B_id, "interactor_B_gene_name"=>$protein_B_gene_name, "interactor_B_array" => $interactor_B_array, "score"=>$score, "dataset_array"=>$dataset_array);
        	             	         
        	        
        	         $node_array[] = array($protein_B_id, $protein_B_name, $protein_B_gene_name, $protein_B_description, $protein_B_external_links);
    	             $edge_array[] = array($protein_A_id, $protein_A_name, $protein_B_id, $protein_B_name, $score);
    
        	     }
    		 } 
		}
		
		fwrite($handle, '4');
	     foreach($interactor_array as $interactor_A){
	         
	         foreach($interactor_array as $interactor_B){
	           
                $interaction = self::getInteraction($interactor_A, $interactor_B, $status_array);
    	        
	         	if($interaction){
	         	    $interaction_id = $interaction->getId();
	         	    $interactor_A_id = $interactor_A->getId();
	         	    $interactor_A_gene_name = $interactor_A->getGeneName();
	         	    $interactor_A_name = $interactor_A->getName();
	         	    $interactor_A_description = $interactor_A->getDescription();
	         	    $interactor_A_external_links = self::getExternalLinks($interactor_A_id);
	         	    $interactor_B_id = $interactor_B->getId();
	         	    $interactor_B_gene_name = $interactor_B->getGeneName();
	         	    $interactor_B_name = $interactor_B->getName();
	         	    $interactor_B_description = $interactor_B->getDescription();
	         	    $interactor_B_external_links = self::getExternalLinks($interactor_B_id);
	         	    
	                $score = $interaction->getScore();
	                
	                $dataset_array = self::getInteractionDatasets($interaction_id);
	                
	                $interactor_A_array = array('id' => $interactor_A_id, 'name' => $interactor_A_name, 'gene_name' => $interactor_A_gene_name, 'description' => $interactor_A_description, 'links' => $interactor_A_external_links);
	                $interactor_B_array = array('id' => $interactor_B_id, 'name' => $interactor_B_name, 'gene_name' => $interactor_B_gene_name, 'description' => $interactor_B_description, 'links' => $interactor_B_external_links);
	                
	                $interaction_array[] = array("interactor_A_id"=> $protein_A_id, "interactor_A_gene_name"=>$protein_A_gene_name, "interactor_A_array" => $interactor_A_array, "interactor_B_id"=> $protein_B_id, "interactor_B_gene_name"=>$protein_B_gene_name, "interactor_B_array" => $interactor_B_array, "score"=>$score, "dataset_array"=>$dataset_array);

	                $edge_array[] = array($interactor_A_id, $interactor_A_name, $interactor_B_id, $interactor_B_name, $score);
	            }
	         }
	     }

	    return array($node_array, $edge_array, $interaction_array);
	}
	
	public function getInteraction($interactor_A, $interactor_B, $status_array){
	    
	    $published = $status_array[0];
	    $validated = $status_array[1];
	    $verified = $status_array[2];
	    $literature = $status_array[3];

	    
	    $interactor_A_id = $interactor_A->getID();
	    $interactor_B_id = $interactor_B->getID();

	    $em = $this->getDoctrine()->getManager();
	    $interaction_repository = $em->getRepository('AppBundle:Interaction');
	    $qb = $interaction_repository->createQueryBuilder('i');
	    $qb->select('i');
	    $qb->join('i.datasets', 'd');
	    $qb->where('i.interactor_A = :interactor_A');
	    $qb->andWhere('i.interactor_B = :interactor_B');


	    $qb->setParameter('interactor_A', $interactor_A_id);
	    $qb->setParameter('interactor_B', $interactor_B_id);

       
        $orX = $qb->expr()->orX();
	    
	    if($published){
	        $orX->add('d.interaction_status = :published_status');
	    }
	     if($validated){
	        $orX->add('d.interaction_status = :validated_status');
	    }
	    if($verified){
	        $orX->add('d.interaction_status = :verified_status');
	    }
	    if($literature){
	        $orX->add('d.interaction_status = :literature_status');
	    }
	    
	    $qb->andWhere($orX);
	    
	    if($published){
	        $qb->setParameter('published_status', 'published');
	    }
	    if($validated){
	        $qb->setParameter('validated_status', 'validated');
	    }
	    if($verified){
	        $qb->setParameter('verified_status', 'verified');
	    }
	    if($literature){
	        $qb->setParameter('literature_status', 'literature');
	    }
	    
	    $query = $qb->getQuery();
	     
	    $interaction_results_array = $query->getResult();

	    if($interaction_results_array){
	        $interaction = $interaction_results_array[0];
	        return $interaction;
	    }else{
	        return false;
	    }
    
	}
	
	public function getInteractions($interactor_A, $status_array){
	     
	    $published = $status_array[0];
	    $validated = $status_array[1];
	    $verified = $status_array[2];
	    $literature = $status_array[3];

	    
	    
	    $interactor_A_id = $interactor_A->getID();

        $em = $this->getDoctrine()->getManager();
        $interaction_repository = $em->getRepository('AppBundle:Interaction');
        $qb = $interaction_repository->createQueryBuilder('i');
        $qb->select('i');
        $qb->join('i.datasets', 'd');
        $qb->where('i.interactor_A = :interactor_A');
        $qb->setParameter('interactor_A', $interactor_A_id);

        
	    $orX = $qb->expr()->orX();
	    
	    if($published){
	        $orX->add('d.interaction_status = :published_status');
	    }
	     if($validated){
	        $orX->add('d.interaction_status = :validated_status');
	    }
	    if($verified){
	        $orX->add('d.interaction_status = :verified_status');
	    }
	    if($literature){
	        $orX->add('d.interaction_status = :literature_status');
	    }
	    
	    $qb->andWhere($orX);
	    
	    if($published){
	        $qb->setParameter('published_status', 'published');
	    }
	    if($validated){
	        $qb->setParameter('validated_status', 'validated');
	    }
	    if($verified){
	        $qb->setParameter('verified_status', 'verified');
	    }
	    if($literature){
	        $qb->setParameter('literature_status', 'literature');
	    }
	    
        $query = $qb->getQuery();
         
        $interaction_array = $query->getResult();
	
	    if($interaction_array){
	        return $interaction_array;
	    }else{
	        return false;
	    }
	
	}
	
	public function getExternalLinks($protein_id){
	
    	$em = $this->getDoctrine()->getManager();
    	 
    	$query = $em->createQuery(
    	                "SELECT DISTINCT l.database_name
    				            FROM AppBundle:External_Link l
    				            WHERE l.protein = :protein_id"
    	                );
    	
    	$query->setParameter('protein_id', $protein_id);
    	 
    	$external_link_database_name_array = $query->getResult();
    	
    	$external_links = array();
    	 
    	foreach($external_link_database_name_array as $external_link_database_name){
    	    $name = $external_link_database_name['database_name'];
    	    $external_links[$name] = array();
    	}
    	
    	$query = $em->createQuery(
    	                "SELECT l
    				            FROM AppBundle:External_Link l
    				            WHERE l.protein = :protein_id"
    	                );
    	 
    	$query->setParameter('protein_id', $protein_id);
    	
    	$external_link_array = $query->getResult();
    	 
    	foreach($external_link_array as $external_link){
    	     
    	    $database_name = $external_link->getDatabaseName();
    	    $link = $external_link->getLink();
    	     
    	    $link_id = $external_link->getLinkId();
    	    $external_links[$database_name][] = array($link_id, $link);
    	     
    	}
    	
    	return $external_links;
    	
	}
	
	public function getUniqueEdges($edges){
	    
	    
	    
	    foreach ($edges as $key_1 => &$array_1){
	        
	        foreach ($edges as $key_2 => $array_2) {
	            
	            if ($key_1 !== $key_2 && $array_1[0] === $array_2[2] && $array_1[2] === $array_2[0]) {
	                unset($edges[$key_2]);
	            }
	            
	            
	        }
	    }
	                    
	                    
	    
	   return $edges; 
	}
	
	public function getInteractionDatasets($interaction_id){
	    

	    $em = $this->getDoctrine()->getManager();
	     
	    $repository = $em->getRepository('AppBundle:Dataset');
	    $query = $repository->createQueryBuilder('ds')
	    ->innerJoin('ds.interactions', 'i')
	    ->where('i.id = :interaction_id')
	    ->setParameter('interaction_id', $interaction_id )
	    ->getQuery();
	    $dataset_result_array = $query->getResult();

	    $dataset_array = array();
	    
        foreach($dataset_result_array as $dataset_result){
            $dataset_pubmed_id = $dataset_result->getPubmedId();
            $dataset_author = $dataset_result->getAuthor();
             
             
             
            $dataset_values = array();
             
            if($dataset_pubmed_id){
                $dataset_values['dataset_reference'] = $dataset_pubmed_id;
            }elseif($dataset_pubmed_id == 'unassigned1304'){
                $dataset_values['dataset_reference'] = '';
            }else{
                $dataset_values['dataset_reference'] = 'N/A';
            }
    
             
            if($dataset_author){
                $dataset_values['dataset_author'] = $dataset_author;
            }else{
                $dataset_values['dataset_author'] = 'N/A';
            }
            
            $dataset_array[] = $dataset_values;
             
        }
        
        return $dataset_array;

	}
	
	public function getQueryParameterSummary($search_filter, $search_setting_score, $search_published, $search_validated, $search_verified, $search_literature){
	    
	    $parameters = '';
	    if($search_filter){
	        $parameters .= "<div class='row'><strong>Filter: </strong> $search_filter</div>";
	    }
	    if($search_setting_score){
	        $parameters .= "<div class='row'><strong>Minimum Score: </strong> $search_setting_score</div>";
	    }
	    
	    $parameter_array = array();
	    
	    if($search_published){
	        $parameter_array[] = "Published";
	    }
	    if($search_validated){
	        $parameter_array[] = "Validated";
	    }
	    if($search_verified){
	        $parameter_array[] = "Verified";
	    }
	    if($search_literature){
	        $parameter_array[] = "Literature";
	    }
	    
	    $parameter_publication_status = join(', ', $parameter_array);
	    
	    $parameters .= "<div class='row'><strong>Interaction Status:</strong>";
	    $parameters .= $parameter_publication_status;
	    $parameters .= "</div>";
	    
	    return $parameters;
	    
	}
	
	public function getQueryParameters($request){
	    
	    $search_published = $request->query->get('published');
	    $search_validated = $request->query->get('validated');
	    $search_verified = $request->query->get('verified');
	    $search_literature = $request->query->get('literature');
	    $search_filter = $request->query->get('filter');
	    $search_setting_score = $request->query->get('score');
	    
	    
	    if($search_published == null && $search_validated == null && $search_verified == null && $search_literature == null && $search_filter == null && $search_setting_score == null){
	        
	        $search_published = true;
	        $search_validated = true;
	        $search_verified = true;
	        $search_literature = true;
	        $search_filter = 'None';
	        $search_setting_score = 0;
	    }
	    
	    $query_parameters_array = array($search_published, $search_validated, $search_verified, $search_literature, $search_filter, $search_setting_score);
	    
	    return $query_parameters_array;
	}
	
	public function getSearchFormData($form){
	    
	    $search_query = $form["identifier"]->getData();
	    $min_interaction_score = $form["min_interaction_score"]->getData();
	    $published = $form["published"]->getData();
	    $validated = $form["validated"]->getData();
	    $verified = $form["verified"]->getData();
	    $literature = $form["literature"]->getData();
	    $query_query = $form["query_query"]->getData();
	    
	    $option_array = array('search_term' => $search_query);
	    
	    if($published && $validated && $verified && $literature && $published && $min_interaction_score == 0 && !$query_query){

	        
	    }else{
	        
	        
	        
	        if($min_interaction_score){
	            $option_array['score'] = $min_interaction_score;
	        }
	        
	         
	        if($published){
	            $option_array['published'] = 'true';
	        }
	        if($validated){
	            $option_array['validated'] = 'true';
	        }
	        if($verified){
	            $option_array['verified'] = 'true';
	        }
	        if($literature){
	            $option_array['literature'] = 'true';
	        }
	        
	        if($query_query){
	            $option_array['filter'] = 'query_query';
	        }else{
	            $option_array['filter'] = 'None';
	        }
	        
	    }


	    
	    
	    
	    
	    return $option_array;
	}
	


}
	
	
?>	