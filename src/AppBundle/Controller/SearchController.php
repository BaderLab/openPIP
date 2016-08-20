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
	    $choice_array = array('--');
	    foreach($organism_result_array as $organism_result){
	        $name = $organism_result->getCommonName();
	        $scientific_name = $organism_result->getScientificName();
	        $taxid_id = $organism_result->getTaxidId();
	        $choice_array[$taxid_id] = $scientific_name . ' (' . $name . ')';
	    }
    
	    $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
            ->add('identifier', TextType::class)
            ->add('organism_select', ChoiceType::class, array(
                    'choices' => $choice_array,            
                    'attr' => array('class' => 'form-control organism_select', 'style' => "width: 240px;")))
            ->add('domain_select', ChoiceType::class, array(
                    'choices' => array('--'),
                    'attr' => array('class' => 'form-control domain_select', 'style' => "width: 240px;")))
            ->add('min_interaction_score', TextType::class, array(
                    'attr' => array('class' => 'hidden', 'value' => 0, 'style' => "width: 240px;")))
            ->add('max_number_of_interactions', TextType::class, array(
                'attr' => array('value' => 50, 'style' => "width: 60px;")))
            ->getForm();
        $form->handleRequest($request);

		
		
		
		if ($form->isSubmitted()) {

		   
			$search_query = $form["identifier"]->getData();
			$organism = $form["organism_select"]->getData();
			$domain = $form["domain_select"]->getData();
			$min_interaction_score = $form["min_interaction_score"]->getData();
			$max_number_of_interactions = $form["max_number_of_interactions"]->getData();
			
			
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
			
			return $this->redirectToRoute('search_results', $option_array);
			
		}
		

		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		
		$color_scheme = $admin_settings->getColorScheme();
		$short_title = $admin_settings->getShortTitle();
		

		
		
		return $this->render('search.html.twig', array(
				'form' => $form->createView(),
				'organism_result_array' => $organism_result_array,
		        'color_scheme' => $color_scheme,
		        'short_title' => $short_title
		        
				
		));
	}
	
	
	
	/**
	 * Search Results
	 *
	 * @Route("/search_results/{search_term}", name="search_results", options={"expose": true})
	 * @Method({"GET", "POST"})
	 */
	public function searchResultsAction($search_term)
	{


	    $search_query = $search_term;
	    	
	    $request = $this->getRequest();
	    $search_setting_organism = $request->query->get('organism');
	    $search_setting_domain = $request->query->get('domain');
	    $search_setting_score = $request->query->get('min_interaction_score');
	    $search_setting_max_interactions = $request->query->get('max_number_of_interactions');
	    
	    //$domain = getDomainByType($search_setting_domain);
	    
	    $identifier_repository = $this->getDoctrine()
	    ->getRepository('AppBundle:Identifier');
	    	
	    $identifier = $identifier_repository->findOneByIdentifier($search_query);
	    
	    if($identifier){
	    
	    
	        $identifier_identifier = $identifier->getIdentifier();
	        $identifier_naming_convention = $identifier->getNamingConvention();
	        $protein = $identifier->getProtein();
	    
	        $protein_id = $protein->getId();
	        $protein_name = $protein->getName();
	        $protein_sequence = $protein->getSequence();
	        $protein_description = $protein->getDescription();
	    
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
	                return $this->redirect($this->generateUrl('select_organmism', $option_array));
	            }
	        }
	        /*
	         $em = $this->getDoctrine()->getManager();
	    
	         $query_sql = "SELECT i FROM AppBundle:Interaction i WHERE i.interactor_A = :interactor_A";
	    
	    
	    
	         if($search_setting_score){
	         $query_builder->andWhere('i.score >= :score');
	         $query_builder->setParameter('score', $search_setting_score);
	         }
	    
	         if($search_setting_max_interactions){
	         $query_builder->setMaxResults($search_setting_max_interactions);
	         }
	    
	    
	    
	    
	    
	    
	         $query = $em->createQuery(
	         "SELECT i
	         FROM AppBundle:Interaction i
	         WHERE i.interactor_A = :interactor_A
	    
	         "
	    
	    
	         );
	         $query->setMaxResults($search_setting_max_interactions);
	         $query->setParameter('interactor_A', $protein_id);
	    
	         if($search_setting_score){
	         $query->setParameter('score', $search_setting_score);
	         }else{
	         $query->setParameter('score', 0);
	         }
	          
	    
	         	
	         $interaction_result_array = $query->getResult();
	         	
	         */
	    
	        $repository = $this->getDoctrine()->getManager();
	        //->getRepository('AppBundle:Interaction');
	    
	        $query_builder = $repository->createQueryBuilder('i');
	        $query_builder->select('i');
	        $query_builder->from('AppBundle:Interaction', 'i');
	        $query_builder->where('i.interactor_A = :interactor_A');
	        $query_builder->setParameter('interactor_A', $protein_id);
	    
	    
	    
	        if($search_setting_score){
	            $query_builder->andWhere('i.score >= :score');
	            $query_builder->setParameter('score', $search_setting_score);
	    
	        }
	    
	        if($search_setting_max_interactions){
	            $query_builder->setMaxResults($search_setting_max_interactions);
	        }
	    
	        $query = $query_builder->getQuery();
	    
	        $interaction_result_array = $query->getResult();
	    
	    
	    
	        /*
	         if($search_setting_score){
	         $query_builder->andWhere('i.score >= :score');
	         $query_builder->setParameter('score', $search_setting_score);
	         }
	    
	         if($search_setting_max_interactions){
	         $query_builder->setMaxResults($search_setting_max_interactions);
	         }
	         $query_builder->setParameter('interactor_A', $protein_id);
	    
	         $query = $query_builder->getQuery();
	    
	         $interaction_result_array = $query->getResult();
	    
	         */
	    
	    
	    
	    
	    
	    
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
	                    $domain_type = $domain->getName();
	                    $domain_type = $domain->getType();
	                    $domain_id = $domain->getId();
	                    $domain_array[] = $domain_name;
	    
	                }else{
	                    $domain_id = $interactor_A_id;
	                    $domain_name = $interactor_A_id . '_' . $interactor_A_name;
	    
	                }
	            }else{
	                	
	                $domain_id = $interactor_A_id;
	                $domain_name = $interactor_A_id . '_' . $interactor_A_name;
	            }
	    
	    
	            	
	            	
	    
	            $protein_of_intrest_array[] = array($interactor_A_id, $interactor_A_name, $interactor_A_gene_name, $domain_id, $domain_name, $domain_type);
	    
	    
	    
	    
	    
	    
	    
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
	            	
	            $interactor_B_sequence = $_interactor_B->getSequence();
	    
	            $interactor_B_id  = $_interactor_B->getId();
	            	
	            	
	    
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
	            	
	            	
	            	
	            	
	            $em = $this->getDoctrine()->getManager();
	            	
	            $repository = $em->getRepository('AppBundle:Dataset');
	            $query = $repository->createQueryBuilder('ds')
	            ->innerJoin('ds.interactions', 'i')
	            ->where('i.id = :interaction_id')
	            ->setParameter('interaction_id', $interaction_id )
	            ->getQuery();
	            $dataset_result_array = $query->getResult();
	            	
	            $dataset = $dataset_result_array[0];
	            $dataset_reference = $dataset->getReference();
	            	
	            	
	            $query = $em->createQuery(
	                            "SELECT l
				FROM AppBundle:External_Link l
				WHERE l.protein = :protein_id"
	                            );
	    
	            $query->setParameter('protein_id', $interactor_B_id);
	            $interactor_B_external_link_array = $query->getResult();
	            	
	            $link = array();
	            foreach($interactor_B_external_link_array as $interactor_B_external_link){
	    
	                $interactor_B_link = array();
	                $interactor_B_link[] = $interactor_B_external_link->getLink();
	                $interactor_B_link[] = $interactor_B_external_link->getLinkId();
	                $interactor_B_link[] = $interactor_B_external_link->getDatabaseName();
	                $link[] = $interactor_B_link;
	    
	            }
	    
	            	
	    
	            $interacting_protein_nodes_array[] = array($interactor_B_id, $interactor_B_name, $link, $interactor_B_gene_name);
	            	
	            	
	            	
	    
	    
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
	    
	            if($dataset_reference){
	                $_interaction['dataset'] = $dataset_reference;
	            }else{
	                $_interaction['dataset'] = 'N/A';
	            }
	            	
	            $interaction_array[] = $_interaction;
	    
	    
	            	
	    
	    
	        }
	    
	        $domain_array = array_unique($domain_array);
	    
	        $domain_array = array_values($domain_array);
	    
	    
	    
	        $domain_object_array = array();
	        $domain_array_2 = $domain_array;
	        array_shift($domain_array_2);
	        foreach($domain_array_2 as $d){
	            $domain_repository = $this->getDoctrine()
	            ->getRepository('AppBundle:Domain');
	             
	            $domain_object = $domain_repository->findOneByName($d);
	    
	            $domain_object_array[] = $domain_object;
	        }
	    
	        $domain_colours = array("black", "#ca0020", "#f4a582", "#0571b0", "#ffffbf", "#92c5de");
	    
	    
	        $domain_count = count($domain_array) - 1;
	    
	    
	    
	    
	        $domains = $domain_array;
	        array_shift($domains);
	    
	        $json = json_encode(array('domain' => $domain_array, 'protein_of_intrest' => $protein_of_intrest_array, 'interacting_protein_nodes' => $interacting_protein_nodes_array, 'edge' => $edge_array));
	    
	    
	        $admin_settings = $this->getDoctrine()
	        ->getRepository('AppBundle:Admin_Settings')
	        ->find(1);
	    
	        $color_scheme = $admin_settings->getColorScheme();
	        $short_title = $admin_settings->getShortTitle();
	    
	        $organism_repository = $this->getDoctrine()
	        ->getRepository('AppBundle:Organism');
	    
	    
	        $parameter_min_interaction_score = 'N/A';
	    
	        if($min_interaction_score){
	            $parameter_min_interaction_score = $min_interaction_score;
	        }
	    
	        if($search_setting_organism){
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
	    
	    
	    
	     
        
        
		return $this->render('search_result.html.twig', array(
				'interaction_array' => $interaction_array,
				'json' => $json,
				'search_query' => $search_query,
		        'min_interaction_score' => $min_interaction_score,		        
		        'color_scheme' => $color_scheme,
		        'short_title' => $short_title,
		        'search_query' => $search_query,
		        'search_setting_organism' => $organism_name,
		        'search_setting_domain' => $search_setting_domain,
		        'search_setting_score' => $search_setting_score,
		        'search_setting_max_interactions' => $search_setting_max_interactions,
		        'number_of_interactions' => $number_of_interactions,
		        'domain_count' => $domain_count,
		        'parameter_min_interaction_score' => $parameter_min_interaction_score,
		        'domains' => $domains,
		        'domain_object_array' => $domain_object_array,
		        'domain_colours' => $domain_colours
		));
		}else{
		    
		    $admin_settings = $this->getDoctrine()
		    ->getRepository('AppBundle:Admin_Settings')
		    ->find(1);
		     
		    $color_scheme = $admin_settings->getColorScheme();
		    $short_title = $admin_settings->getShortTitle();
		    $title = $admin_settings->getTitle();
		    return $this->render('no_results.html.twig', array(
		            'search_query' => $search_query,
		            'color_scheme' => $color_scheme,
		            'short_title' => $short_title,
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

	
	    return $this->render('domain_sequence.html.twig', array(
	            'domain_sequence' => $domain_sequence,
	            'domain_type' => $domain_type,
	            'domain_name' => $domain_name,
	
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
	
	    return $this->render('protein_sequence.html.twig', array(
	            'protein_sequence' => $protein_sequence,
	            'gene_name' => $protein_gene_name,
	
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
