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
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT o
				FROM AppBundle:Organism o"
	                    );
	    	
	    $organism_result_array = $query->getResult();
	    
	    $query = $em->createQuery("SELECT d FROM AppBundle:Domain d");
	    
	    $domain_result_array = $query->getResult();
	    
	    
	    $domain_query = $em->createQuery('SELECT COUNT(d.id) FROM AppBundle:Domain d');
	    
	    $domain_count = $domain_query->getSingleScalarResult();
	    
	    $organism_query = $em->createQuery('SELECT COUNT(o.id) FROM AppBundle:Organism o');
	    
	    $organism_count = $organism_query->getSingleScalarResult();
	    
	    $organism_choice_array = array('--');
	    foreach($organism_result_array as $organism_result){
	        $name = $organism_result->getCommonName();
	        $scientific_name = $organism_result->getScientificName();
	        $taxid_id = $organism_result->getTaxidId();
	        $organism_choice_array[$taxid_id] = $scientific_name . ' (' . $name . ')';
	    }
	    
	    $domain_choice_array = array('--');
	    foreach($domain_result_array as $domain_result){
	        $name = $domain_result->getName();
	        $type = $domain_result->getType();
	        
	        $domain_choice_array[$type] = $type;
	    }
    
	    $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
            ->add('identifier', TextType::class)
            ->add('organism_select', ChoiceType::class, array(
                    'choices' => $organism_choice_array,            
                    'attr' => array('class' => 'form-control organism_select', 'style' => "width: 240px;")))
            ->add('domain_select', ChoiceType::class, array(
                    'choices' => $domain_choice_array,
                    'attr' => array('class' => 'form-control domain_select', 'style' => "width: 240px;")))
            ->add('min_interaction_score', TextType::class, array(
                    'attr' => array('class' => 'hidden', 'value' => 0, 'style' => "width: 240px;")))
            ->add('max_number_of_interactions', TextType::class, array(
                'attr' => array('value' => 50, 'style' => "width: 60px;")))
            ->add('published', CheckboxType::class, array(
                    'required' => false,
                    'attr' => array('value' => 'published', 'checked' => 'checked')))
            ->add('prepublished', CheckboxType::class, array(
                    'required' => false,
                    'attr' => array('value' => 'pre_published', 'checked' => 'checked')))
            ->getForm();
        $form->handleRequest($request);
		
		if ($form->isSubmitted()) {
		   
			$search_query = $form["identifier"]->getData();
			$organism = $form["organism_select"]->getData();
			$domain = $form["domain_select"]->getData();
			$min_interaction_score = $form["min_interaction_score"]->getData();
			$max_number_of_interactions = $form["max_number_of_interactions"]->getData();
			$published = $form["published"]->getData();
			$pre_published = $form["prepublished"]->getData();
			
			
			$option_array = array('search_term' => $search_query);
			
			if($organism){
			    $option_array['organism'] = $organism;    
			}
			if($domain){
			    $option_array['domain'] = $domain;
			}
			if($min_interaction_score){
			    $option_array['min_interaction_score'] = $min_interaction_score;
			}
			if($max_number_of_interactions){
			    $option_array['max_number_of_interactions'] = $max_number_of_interactions;
			}
			
			if($published && $pre_published){
			    $option_array['publication_status'] = 'all';
			}elseif($published){
			    $option_array['publication_status'] = 'published';
			}elseif($pre_published){
			    $option_array['publication_status'] = 'pre_published';
			}
				
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
				'organism_result_array' => $organism_result_array,
		        'domain_result_array' => $domain_result_array,
		        'domain_count' => $domain_count,
		        'organism_count' => $organism_count,
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
	    $search_setting_organism = $request->query->get('organism');
	    $search_setting_domain = $request->query->get('domain');
	    $search_setting_score = $request->query->get('score');
	    $search_setting_max_interactions = $request->query->get('max_number_of_interactions');
	    $query_publication_status = $request->query->get('publication_status');
	    
	    //$domain = getDomainByType($search_setting_domain);
	    
	    //find identifier in database
	    $identifier_repository = $this->getDoctrine()
	    ->getRepository('AppBundle:Identifier');	    	
	    $identifier = $identifier_repository->findOneByIdentifier($search_query);
	    
	    //if idetifier is in database
	    if($identifier){
	    
	        
	        $identifier_identifier = $identifier->getIdentifier();
	        $identifier_naming_convention = $identifier->getNamingConvention();
	        
	        //get protein
	        $protein = $identifier->getProtein();	    
	        $protein_id = $protein->getId();
	        $protein_name = $protein->getName();
	        $protein_gene_name = $protein->getGeneName();
	        $protein_sequence = $protein->getSequence();
	        $protein_description = $protein->getDescription();
	        
	        //if organism is not specified by user check if protein exists in multiple organisms	
	        if(!$search_setting_organism){
	            
	            $em = $this->getDoctrine()->getManager();
	            $repository = $em->getRepository('AppBundle:Organism');
	            $query = $repository->createQueryBuilder('o')
	            ->innerJoin('o.proteins', 'p')
	            ->where('p.id = :protein_id')
	            ->setParameter('protein_id', $protein_id )
	            ->getQuery();
	            $organism_result_array = $query->getResult();
	    
	            if (count($organism_result_array) > 1){
	    
	                $option_array = array('search_term' => $search_query);
	                if($search_setting_domain){
	                    $option_array['domain'] = $search_setting_domain;
	                }
	                if($search_setting_score){
	                    $option_array['min_interaction_score'] = $search_setting_score;
	                }
	                if($search_setting_max_interactions){
	                    $option_array['max_number_of_interactions'] = $search_setting_max_interactions;
	                }
	                
	                //redirect to select organism page
	                return $this->redirect($this->generateUrl('select_organmism', $option_array));
	            }
	        }
	        

	        $em = $this->getDoctrine()->getManager();
	        
	        $query = $em->createQuery(
	                        "SELECT DISTINCT l.database_name
				            FROM AppBundle:External_Link l
				            WHERE l.protein = :protein_id"
	                        );
	         
	        $query->setParameter('protein_id', $protein_id);
	        
	        $external_link_database_name_array = $query->getResult();
	        $protein_of_intrest_external_links = array();
	        
	        
	        foreach($external_link_database_name_array as $external_link_database_name){
	           $name = $external_link_database_name['database_name'];
	           $protein_of_intrest_external_links[$name] = array();
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
	            $protein_of_intrest_external_links[$database_name][] = array($link_id, $link);
	            
	        }
	        
	        $protein_of_intrest = array($protein_id, $protein_name , $protein_gene_name, $protein_description, $protein_of_intrest_external_links);
	         
	        
	        
	        

	        $em = $this->getDoctrine()->getManager();
	        $repository = $em->getRepository('AppBundle:Interaction');

	         
	        $query_builder = $repository->createQueryBuilder('i');
	        $query_builder->innerJoin('i.datasets', 'd');
	        $query_builder->where('i.interactor_A = :interactor_A');
	        $query_builder->setParameter('interactor_A', $protein_id);
	        
	        if($search_setting_score){
	            $query_builder->andWhere('i.score >= :score');
	            $query_builder->setParameter('score', $search_setting_score);  
	        }
	         
	        if($search_setting_max_interactions){
	            $query_builder->setMaxResults($search_setting_max_interactions);
	        }
	        
	        if($query_publication_status == 'all'){
			}elseif($query_publication_status == 'published'){
			    $query_builder->andWhere('d.reference != :reference');
			    $query_builder->setParameter('reference', 'unassigned1304');  
			}elseif($query_publication_status == 'pre_published'){
			    $query_builder->andWhere('d.reference = :reference');
			    $query_builder->setParameter('reference', 'unassigned1304');  
			}else{
			}
			
	        $query = $query_builder->getQuery();
	         
	        $interaction_result_array = $query->getResult();

	        
	        $interaction_array = array();	    
	        $domain_array = array();
	        $protein_of_intrest_array = array();
	        $interacting_protein_nodes_array = array();
	        $edge_array = array();
	    
	        $domain_array[] = ' ';
	         
	        $min_interaction_score = 1;
	        $number_of_interactions = 0;
	         
	        foreach($interaction_result_array as $interaction_result){
	    
	            $number_of_interactions ++;
	            
	            //Get interaction data
	            $interaction_id = $interaction_result->getId();
	            $interactor_A = $interaction_result->getInteractorA();
	            $interactor_B = $interaction_result->getInteractorB();
	            $binding_start = $interaction_result->getBindingStart();
	            $binding_end = $interaction_result->getBindingEnd();
	            $score = $interaction_result->getScore();
	            $domain_id = $interaction_result->getDomain();
	            if($score < $min_interaction_score){
	                 
	                $min_interaction_score = $score;
	            }
	            
	            
	            
	            
	            
	            $em = $this->getDoctrine()->getManager();

	            
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
	    
	            	
	            $domain_name = '';
	            $domain_type = '';
	            	
	            if($domain_id){
	                $domain = $this->getDoctrine()
	                ->getRepository('AppBundle:Domain')
	                ->find($domain_id);
	    
	    
	    
	                if($domain){
	                    $domain_name = $domain->getName();
	                    $domain_type = $domain->getType();
	                    $domain_id = $domain->getId();
	                    $domain_array[] = array($domain_id, $domain_name, $domain_type);
	    
	                }else{
	                    $domain_id = $interactor_A_id;
	                    $domain_name = $interactor_A_id . '_' . $interactor_A_name;
	    
	                }
	            }else{
	                	
	                $domain_id = $interactor_A_id;
	                $domain_name = $interactor_A_id . '_' . $interactor_A_name;
	            }
	    
	            
                //Get protein data
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
	            $interactor_B_description = $_interactor_B->getDescription();
	            
	            $interactor_B_sequence = $_interactor_B->getSequence();
	    
	            $interactor_B_id  = $_interactor_B->getId();
	            	
	            
	            //Get support information
	            $query = $em->createQuery(
	                            "SELECT isi
				FROM AppBundle:Interaction_Support_Information isi
				WHERE isi.interaction = :interaction_id"
	                            );
	    
	            $query->setParameter('interaction_id', $interaction_id);
	            $interaction_support_information_array = $query->getResult();
	    
	            $support_information_array = array();
	            	
	            foreach($interaction_support_information_array as $interaction_support_information){
	    
	                $support_information_id = $interaction_support_information->getSupportInformation();
	                $support_information_value = $interaction_support_information->getValue();
	                	
	                	
	                $query = $em->createQuery(
	                                "SELECT si
				                    FROM AppBundle:Support_Information si
				                    WHERE si.id = :support_information_id"
	                                );
	                	
	                $query->setParameter('support_information_id', $support_information_id);
	                $_support_information_array = $query->getResult();
	                $support_information = $_support_information_array[0];
	                $support_information_name = $support_information->getName();
	                	
	                $support_information_array[] = array($support_information_name, $support_information_value);
	            }
	            	
	            
	            //Get reference for interaction
	            $em = $this->getDoctrine()->getManager();
	    
	            $repository = $em->getRepository('AppBundle:Dataset');
	            $query = $repository->createQueryBuilder('ds')
	            ->innerJoin('ds.interactions', 'i')
	            ->where('i.id = :interaction_id')
	            ->setParameter('interaction_id', $interaction_id )
	            ->getQuery();
	            $dataset_result_array = $query->getResult();
	            
	            $publication_status = 'pre-published';
	            
	            foreach($dataset_result_array as $dataset_result){
	                $dataset_reference = $dataset_result->getReference();
	                
    	            if($dataset_reference != 'unassigned1304'){
    	                 
    	                $publication_status = 'published';
    	            }
	            }
	            
	            //Get external links for interacting protein
	            $interactor_B_external_links = array();
	            
	            $em = $this->getDoctrine()->getManager();
	             
	            $query = $em->createQuery(
	                            "SELECT DISTINCT l.database_name
				            FROM AppBundle:External_Link l
				            WHERE l.protein = :protein_id"
	                            );
	            
	            $query->setParameter('protein_id', $interactor_B_id);
	             
	            $interactor_B_external_link_database_name_array = $query->getResult();
	            
	             
	            foreach($interactor_B_external_link_database_name_array as $interactor_B_external_link_database_name){
	                $name = $interactor_B_external_link_database_name['database_name'];
	               $interactor_B_external_links[$name] = array();
	            }
	            
	            $query = $em->createQuery(
	                            "SELECT l
				            FROM AppBundle:External_Link l
				            WHERE l.protein = :protein_id"
	                            );
	             
	            $query->setParameter('protein_id', $interactor_B_id);
	            
	            $interactor_B_external_link_array = $query->getResult();
	             
	            foreach($interactor_B_external_link_array as $interactor_B_external_link){
	                 
	                $database_name = $interactor_B_external_link->getDatabaseName();
	                $link = $interactor_B_external_link->getLink();
	                $link_id = $interactor_B_external_link->getLinkId();
	                $interactor_B_external_links[$database_name][] = array($link_id, $link);
	            }
	            
	            

	            	
	            //Set interacting protein node
	            $interacting_protein_nodes_array[] = array($interactor_B_id, $interactor_B_name, $interactor_B_gene_name, $interactor_B_description, $interactor_B_external_links);
	    
	            
	            //Set edge data
	            $edge_array[] = array($domain_id, $domain_name, $interactor_B_id, $interactor_A_name, $interactor_B_name, $score, $publication_status);
	    
	            
	            
	            //Set network data
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
	            
	            $_interaction['dataset_array'] = array();

	            
	            if($dataset_result_array){
	                foreach($dataset_result_array as $dataset_result){

    	                $dataset_reference = $dataset_result->getReference();
    	                $dataset_author = $dataset_result->getName();
    	                
    	                
    	                
    	                $dataset_values = array();
    	                
        	            if($dataset_reference){
        	                $dataset_values['dataset_reference'] = $dataset_reference;
        	            }elseif($dataset_reference == 'unassigned1304'){
        	                $dataset_values['dataset_reference'] = '';
        	            }else{
        	                $dataset_values['dataset_reference'] = 'N/A';
        	            }
        	             
        	            
        	            if($dataset_author){
        	                $dataset_values['dataset_author'] = $dataset_author;
        	            }else{
        	                $dataset_values['dataset_author'] = 'N/A';
        	            }
        	            
        	            $_interaction['dataset_array'][] = $dataset_values;
	                }
	            
	            }
	            
	            
	            
	           //network data
	            $interaction_array[] = $_interaction;
	    
	        }
	    
	        
	        
	        
	        
	        
	        
	        
	        $domain_array = array_map("unserialize", array_unique(array_map("serialize", $domain_array)));
	        $domain_array = array_values($domain_array);
	        
	        $domain_count = count($domain_array) - 1;
	        
	       
	        $domain_colours = array("black", "#ca0020", "#f4a582", "#0571b0", "#ffffbf", "#92c5de");
	        
	        
	        $json = json_encode(array('domain' => $domain_array, 'protein_of_intrest' => $protein_of_intrest, 'interacting_protein_nodes' => $interacting_protein_nodes_array, 'edge' => $edge_array), JSON_HEX_QUOT);

	        
	        
	        

	        
	    
	        
	        //Get search parameters
	        $parameter_min_interaction_score = 'N/A';
	        if($min_interaction_score){
	            $parameter_min_interaction_score = $min_interaction_score;
	        }
	    
	        if($search_setting_organism){
	    
	            $organism_repository = $this->getDoctrine()
	            ->getRepository('AppBundle:Organism');
	            $organism_array = $organism_repository->findBy(array('taxid_id' => $search_setting_organism));
	            $organism = $organism_array[0];
	            $organism_name = $organism->getScientificName();
	        }else{
	            $organism_name = 'N/A';
	        }
	        if(!$search_setting_domain){
	            $search_setting_domain = 'N/A';
	        }
	        if(!$search_setting_score){
	            $search_setting_score = 'N/A';
	        }
	        if(!$search_setting_max_interactions){
	            $search_setting_max_interactions = 'N/A';
	        }
	    
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
	        	
	        
	        $domain_object_array = array();
	        $domain_array_2 = $domain_array;
	        array_shift($domain_array_2);
	        foreach($domain_array_2 as $d){
	            $domain_repository = $this->getDoctrine()
	            ->getRepository('AppBundle:Domain');
	        
	            $domain_object = $domain_repository->findOneByName($d);
	             
	            $domain_object_array[] = $domain_object;
	        }
	        
	        $domains = $domain_array;
	        array_shift($domains);
	        
	        $json = str_replace("'","\\'", $json);
	        //$handle = fopen('C:\Users\Miles\Desktop\test\test_2.txt', 'w');
	        //fwrite($handle, $json);
	        
	        
	        $organism_query = $em->createQuery('SELECT COUNT(o.id) FROM AppBundle:Organism o');
	        
	        $organism_count = $organism_query->getSingleScalarResult();
	        
	        $domain_query = $em->createQuery('SELECT COUNT(d.id) FROM AppBundle:Domain d');
	        
	        $domain_count = $domain_query->getSingleScalarResult();

	        $binding_count_query = $em->createQuery('SELECT COUNT(i.id) FROM AppBundle:Interaction i WHERE i.binding_start IS NOT NULL');
	         
	        $binding_count = $binding_count_query->getSingleScalarResult();
	        
	        
	        return $this->render('search_result_2.html.twig', array(
	                'interaction_array' => $interaction_array,
	                'json' => $json,
	                'search_query' => $search_query,
	                'min_interaction_score' => $min_interaction_score,
	                'main_color_scheme' => $main_color_scheme,
                    'header_color_scheme' => $header_color_scheme,
                    'logo_color_scheme' => $logo_color_scheme,
                    'button_color_scheme' => $button_color_scheme, 
	                'short_title' => $short_title,
	                'title' => $title,
	                'footer' => $footer,
	                'protein_gene_name' => $protein_gene_name,
	                'search_query' => $search_query,
	                'domain_count' => $domain_count,
	                'binding_count' => $binding_count,
	                'organism_count' => $organism_count,
	                'number_of_interactions' => $number_of_interactions,
	                'search_setting_organism' => $organism_name,
	                'search_setting_domain' => $search_setting_domain,
	                'search_setting_score' => $search_setting_score,
	                'search_setting_max_interactions' => $search_setting_max_interactions,
	                'query_publication_status' => $query_publication_status,
	                'domain_count' => $domain_count,
	                'interaction_count' => $number_of_interactions,
	                'parameter_min_interaction_score' => $parameter_min_interaction_score,
	                'domain_colours' => $domain_colours,
	                'domains' => $domains,
		            'login_status' => $login_status,
	                'domain_object_array' => $domain_object_array,
	        ));
	       
	    }else{
	    
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
    		
	        $login_status = false;
	         
	        $is_fully_authenticated = $this->get('security.context')
	        ->isGranted('IS_AUTHENTICATED_FULLY');
	         
	        if($is_fully_authenticated){
	            $login_status =  true;
	        }
	    
	        return $this->render('no_results.html.twig', array(
	                'search_query' => $search_query,
	                'main_color_scheme' => $main_color_scheme,
                    'header_color_scheme' => $header_color_scheme,
                    'logo_color_scheme' => $logo_color_scheme,
                    'button_color_scheme' => $button_color_scheme, 
	                'short_title' => $short_title,
		            'footer' => $footer,
		            'login_status' => $login_status,
	                'title' => $title
	        ));

	    }
	}

	

	/**
	 * Search Home
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
	 * Domain Sequence
	 *
	 * @Route("/domain_sequence/{search_term}", name="domain_sequence", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function domain_sequenceAction($search_term)
	{
	
	    $em = $this->getDoctrine()->getManager();

	    $domain_repository = $this->getDoctrine()
	    ->getRepository('AppBundle:Domain');
	    
	    $domain = $domain_repository->findOneByName($search_term);
	    $domain_sequence = $domain->getSequence();
	    $domain_type = $domain->getType();
	    $domain_name = $domain->getName();
	    
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

	    return $this->render('domain_sequence.html.twig', array(
	            'domain_sequence' => $domain_sequence,
	            'domain_type' => $domain_type,
	            'domain_name' => $domain_name,
            	'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
                'short_title' => $short_title,
	            'title' => $title,
	            'login_status' => $login_status
	
	    ));
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
	
	/**
	 * Search Home
	 *
	 * @Route("/organmism_domain/{search_term}", name="organmism_domain", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function organmismDomainAction($search_term)
	{

	    $em = $this->getDoctrine()->getManager();

	    $repository = $em->getRepository('AppBundle:Domain');
	    $query = $repository->createQueryBuilder('d')
	    ->innerJoin('d.organisms', 'o')
	    ->where('o.taxid_id = :taxid_id')
	    ->setParameter('taxid_id', $search_term)
	    ->getQuery();
	    $domain_result_array = $query->getResult();
	    
	    $type_array = array();
	    foreach($domain_result_array as $domain_result){
	        
	       $type = $domain_result->getType();
	       $type_array[] = $type;
	       
	       
	    }
	    $type_array = array_unique($type_array);
	    $return_array = array();
	    foreach($type_array as $type){
	        $return_array[] = $type;
	    }
	    $response = new Response(json_encode($return_array));
	    

	    return $response;
	}
}
?>
