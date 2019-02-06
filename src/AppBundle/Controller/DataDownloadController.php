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
use AppBundle\Entity\Dataset_Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
/**
 * Search controller.
 *
 *
 */
class DownloadController extends Controller
{

    

    
    /**
     * Fasta
     *
     * @Route("/download/multi_fasta/{search_term}", name="multi_fasta", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function multi_fastaAction($search_term)
    {
    
       
        $request = $this->getRequest();

        
        $query_parameters_array = self::getQueryParameters($request);
        
        $search_published = $query_parameters_array[0];
        $search_validated = $query_parameters_array[1];
        $search_verified = $query_parameters_array[2];
        $search_literature = $query_parameters_array[3];
        $search_filter = $query_parameters_array[4];
        $search_setting_score = $query_parameters_array[5];
        
        $status_array = array($search_published, $search_validated, $search_verified, $search_literature, $search_setting_score);
        
        
        
        $search_query_array = explode(",", $search_term);

        
        $fasta_sequences = self::getFastaSequences($search_query_array, $search_filter, $status_array);

        $response = new Response();
    
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename= download_multi_fasta.fa');
    
        $response->setContent($fasta_sequences);
    
        return $response;
    
    }
    
    
    /**
     * Interactor Csv
     *
     * @Route("/download/enriched_term_protein_csv/{search_term}", name="enriched_term_protein_csv", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function enriched_term_protein_csvAction($search_term)
    {
    	
    	$response = new Response();
    	
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename= interactor_csv.csv');
    	
    	$response->setContent($search_term);
    	
    	return $response;
    	
    }
    
    
    
    /**
     * Interactor Csv
     *
     * @Route("/download/interactor_csv/{search_term}", name="interactor_csv", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function interactor_csvAction($search_term)
    {
    
    	 
    	$request = $this->getRequest();
    	

    	$query_parameters_array = self::getQueryParameters($request);
    
    	$search_published = $query_parameters_array[0];
    	$search_validated = $query_parameters_array[1];
    	$search_verified = $query_parameters_array[2];
    	$search_literature = $query_parameters_array[3];
    	$search_filter = $query_parameters_array[4];
    	$search_setting_score = $query_parameters_array[5];
    
    	$status_array = array($search_published, $search_validated, $search_verified, $search_literature, $search_setting_score);
    
    
    
    	$search_query_array = explode(",", $search_term);
    
    
    	$interactor_csv = self::getCsvInteractorData($search_query_array, $search_filter, $status_array);
    
    	$response = new Response();
    
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename= interactor_csv.csv');
    
    	$response->setContent($interactor_csv);
    
    	return $response;
    
    }
    
    
    /**
     * Interaction Csv
     *
     * @Route("/download/interaction_csv/{search_term}", name="interaction_csv", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function interaction_csvAction($search_term)
    {
    

        $response = new Response();
    
        $request = $this->getRequest();
        $query_parameters_array = self::getQueryParameters($request);
        
        $search_published = $query_parameters_array[0];
        $search_validated = $query_parameters_array[1];
        $search_verified = $query_parameters_array[2];
        $search_literature = $query_parameters_array[3];
        $search_filter = $query_parameters_array[4];
        $search_setting_score = $query_parameters_array[5];
        
        $status_array = array($search_published, $search_validated, $search_verified, $search_literature, $search_setting_score);
        
        $search_query_array = explode(",", $search_term);
        
        $csv = "ID(s) interactor A,ID(s) interactor B,Alias(es) interactor A,Alias(es) interactor B\r\n";
        
        
        $csv_array = self::getCsvInteractionData($search_query_array, $search_filter, $status_array);
        
        $csv_array = array_unique($csv_array);
        $csv_array = array_values($csv_array);
        
        foreach($csv_array as $line){
        	
        	$csv .= $line;
        }
        
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . 'interactions_csv.csv');
    
        $response->setContent($csv);
    
        return $response;
    }
    
    
    /**
     * Search Home
     *
     * @Route("/download/psi_mitab/{search_term}", name="psi_mitab", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function psi_mitabAction($search_term)
    {

         
        $psi_mitab = "ID(s) interactor A\tID(s) interactor B\tAlt. ID(s) interactor A\tAlt. ID(s)interactor B\tAlias(es) interactor A\tAlias(es) interactor B\tInteraction detection method(s)\tPublication 1st author(s)\tPublication Identifier(s)\tTaxid interactor A\tTaxid interactor B\tInteraction type(s)\tSource database(s)\tInteraction identifier(s)\tConfidence value(s)\tExpansion method(s)\tBiological role(s)interactor A\tBiological role(s) interactor B\tExperimental role(s) interactor A\tExperimental role(s) interactor B\tType(s) interactor A\tType(s) interactor B\tXref(s) interactor A\tXref(s) interactor B\tInteraction Xref(s)\tAnnotation(s) interactor A\tAnnotation(s) interactor B\tInteraction annotation(s)\tHost organism(s)\tInteraction parameter(s)\tCreation date\tUpdate date\tChecksum(s) interactor A\tChecksum(s) interactor B\tInteraction Checksum(s)	Negative\tFeature(s) interactor A\tFeature(s) interactor B\tStoichiometry(s) interactor A\tStoichiometry(s) interactor B\tIdentification method participant A\tIdentification method participant B\r\n";
    
        $request = $this->getRequest();
        $query_parameters_array = self::getQueryParameters($request);
        
        $search_published = $query_parameters_array[0];
        $search_validated = $query_parameters_array[1];
        $search_verified = $query_parameters_array[2];
        $search_literature = $query_parameters_array[3];
        $search_filter = $query_parameters_array[4];
        $search_setting_score = $query_parameters_array[5];
        
        $status_array = array($search_published, $search_validated, $search_verified, $search_literature, $search_setting_score);
        
        $search_query_array = explode(",", $search_term);
        
        
        $psi_mitab_array = self::getPsiMitabData($search_query_array, $search_filter, $status_array);
        
        
        $psi_mitab_array = array_unique($psi_mitab_array);
        $psi_mitab_array = array_values($psi_mitab_array);
        
        
        
        
        foreach($psi_mitab_array as $line){
        	 
        	$psi_mitab .= $line;
        }
        
        
         
        $response = new Response();
    
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . 'psi_mitab.tab');
    
        $response->setContent($psi_mitab);
    
        return $response;
    }
    
    /**
     * Search Home
     *
     * @Route("/download/unpublished_dataset/{search_term}", name="unpublished_dataset", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function unpublishedDatasetAction($search_term)
    {
    
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT dr
							FROM AppBundle:Dataset_Request dr
							WHERE dr.md5 = :md5"
                        );
        
        $query->setParameter('md5', $search_term);
        $result_array = $query->getResult();
        $result = $result_array[0];
        
        $request = $result->getRequest();
        $response = new BinaryFileResponse($request);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        
        return $response;
    
    }
    
    /**
     * Search Home
     *
     * @Route("/download/unpublished_data/{search_term}", name="unpublished_data", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function unpublishedDataAction($search_term)
    {
    
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT dr
							FROM AppBundle:Dataset_Request dr
							WHERE dr.md5 = :md5"
                        );
    
        $query->setParameter('md5', $search_term);
        $result_array = $query->getResult();
        $result = $result_array[0];
    
        $request = $result->getRequest();
        
        $search_query_array = explode(":", $request);
        $file_type = $search_query_array[0];
        $search_query = $search_query_array[1];
    
        if($file_type == 'psimi_tab'){
            
            $response = self::psi_mitabAction($search_query);
            
        }elseif($file_type == 'interaction_csv'){
            
            $response = self::interaction_csvAction($search_query);
        }
        
        
        return $response;
    
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
    

    public function getCsvInteractorData($search_query_array, $search_filter, $status_array){
    
    	$query_protein_array = self::getProteinQueryArray($search_query_array);
    	$csv = null;
    
    	switch ($search_filter) {
    		case 'query_query':
    			$csv = self::getQueryQueryCsvInteractors($query_protein_array, $status_array);
    			break;
    
    		case 'None':
    			$csv = self::getInteractorInteractorCsvInteractors($query_protein_array, $status_array);
    			break;
    
    		default:
    
    	}
    
    	return $csv;
    }
     

    public function getCsvInteractionData($search_query_array, $search_filter, $status_array){
    
    	$query_protein_array = self::getProteinQueryArray($search_query_array);
    	$csv = null;
    
    	switch ($search_filter) {
    		case 'query_query':
    			$csv = self::getQueryQueryCsvInteractions($query_protein_array, $status_array);
    			break;
    
    		case 'None':
    			$csv = self::getInteractorInteractorCsvInteractions($query_protein_array, $status_array);
    			break;
    
    		default:
    
    	}
    
    	return $csv;
    
    }


    public function  getQueryQueryCsvInteractions($query_protein_array, $status_array){
    
    	$csv = array();
    
    	foreach($query_protein_array as  $query_protein_A){
    
    		$protein_A_id =  $query_protein_A->getId();
    		$protein_A_name =  $query_protein_A->getName();
    		$protein_A_gene_name =  $query_protein_A->getGeneName();
    
    		foreach($query_protein_array as $query_protein_B){
    
    			$protein_B_id =  $query_protein_B->getId();
    			$protein_B_name =  $query_protein_B->getName();
    			$protein_B_gene_name =  $query_protein_B->getGeneName();
    			 
    			$interaction = self::getInteraction($query_protein_A, $query_protein_B, $status_array);
    
    			if($interaction){
    
    				$csv[] = "$protein_A_name,$protein_B_name,$protein_A_gene_name,$protein_B_gene_name\r\n";
    			}
    		}
    	}
    
    	return $csv;
    }
    
    /*
    public function  getInteractorInteractorCsvInteractions($query_protein_array, $status_array){
    
    	$csv = array();
    
    	foreach($query_protein_array as  $query_protein_A){
    
    		$protein_A_id =  $query_protein_A->getId();
    		$protein_A_name = $query_protein_A->getName();
    		$protein_A_gene_name =  $query_protein_A->getGeneName();
    		$protein_A_sequence = $query_protein_A->getSequence();
    
    		$interactions = self::getInteractions($query_protein_A, $status_array);
    		 
    		if($interactions){
    			foreach($interactions as $interaction){
    				 
    				$interaction_id = $interaction->getId();
    				$interactor_B = $interaction->getInteractorB();
    				 
    				$protein_B = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_B);
    				 
    				$protein_B_id = $protein_B->getId();
    				$protein_B_name = $protein_B->getName();
    				$protein_B_gene_name =  $protein_B->getGeneName();
    				$protein_B_sequence = $protein_B->getSequence();
    
    				$csv[] = "$protein_A_name,$protein_B_name,$protein_A_gene_name,$protein_B_gene_name\r\n";
    
    
    
    			}
    		}
    	}
    
    	return $csv;
    }
    */
    
    
    
    public function getInteractorInteractorCsvInteractions($query_protein_array, $status_array){
    	 
    	$csv = array();
    	 
    	$interactor_array = array();
    	 
    	foreach($query_protein_array as  $query_protein){
    
    		$interactions = self::getInteractions($query_protein, $status_array);
    		 
    		if($interactions){
    
    			foreach($interactions as $interaction){
    
    				$interaction_id = $interaction->getId();
    				$interactor_A = $interaction->getInteractorA();
    				$interactor_B = $interaction->getInteractorB();

    
    				 
    				$protein_B = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_B);
    				 
    				$protein_B_id = $protein_B->getId();
    				$protein_B_name = $protein_B->getName();
    				$protein_B_gene_name =  $protein_B->getGeneName();

    
    				$protein_A = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_A);
    				 
    				$protein_A_id = $protein_A->getId();
    				$protein_A_name = $protein_A->getName();
    				$protein_A_gene_name =  $protein_A->getGeneName();

    
    				$interactor_array[] = $protein_A_id;
    				$interactor_array[] = $protein_B_id;
    
    				 
    				$csv[] = "$protein_A_name,$protein_B_name,$protein_A_gene_name,$protein_B_gene_name\r\n";
    
        
    			}
    		}
    	}
    
    	$csv = array_unique($csv);
    
    	$csv = array_values($csv);
    
    
    	foreach($interactor_array as $interactor_A_id){
    
    		foreach($interactor_array as $interactor_B_id){

    
    			$interaction = self::getInteraction($interactor_A_id, $interactor_B_id, $status_array);
    			 
    			if($interaction){
    				$interaction_id = $interaction->getId();
    				 
    				$protein_A = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_A_id);
    
    				$protein_A_id = $protein_A->getId();
    				$protein_A_name = $protein_A->getName();
    				$protein_A_gene_name =  $protein_A->getGeneName();

    				 
    				$protein_B = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_B_id);
    
    				$protein_B_id = $protein_B->getId();
    				$protein_B_name = $protein_B->getName();
    				$protein_B_gene_name =  $protein_B->getGeneName();

    				 
    				$csv[] = "$protein_A_name,$protein_B_name,$protein_A_gene_name,$protein_B_gene_name\r\n";
    				
     			}
    		}
    	}
    	 
    	$csv = array_unique($csv);
    	
    	$csv = array_values($csv);
    
    	return $csv;
    }
    
    public function  getInteractorInteractorCsvInteractors($query_protein_array, $status_array){
    
    	$csv = null;
    	$interactor_array = array();
    
    	foreach($query_protein_array as  $query_protein_A){
    
    
    
    		$protein_A_id =  $query_protein_A->getId();
    		$interactor_array[] = $protein_A_id;
    		
    
    		$interactions = self::getInteractions($query_protein_A, $status_array);
    		 
    		if($interactions){
    			foreach($interactions as $interaction){
    					
    				$interaction_id = $interaction->getId();
    				$interactor_A = $interaction->getInteractorA();
    					
    				$protein_A = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_A);
    					
    
    
    				$protein_A_id = $protein_A->getId();
    
    				$interactor_array[] = $protein_A_id;
    				

    				$interaction_id = $interaction->getId();
    				$interactor_B = $interaction->getInteractorB();
    					
    				$protein_B = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_B);
    					
    				
    				
    				$protein_B_id = $protein_B->getId();
    				
    				$interactor_array[] = $protein_B_id;
    
    			}
    		}
    
    	}
    
    	$interactor_array = array_unique($interactor_array);
    	$interactor_array = array_values($interactor_array);
    
    	    	
    	
    	
    	foreach($interactor_array as $interactor_id){

    		$intoractor = $this->getDoctrine()
    		->getRepository('AppBundle:Protein')
    		->find($interactor_id);
    		 
    		 
    		$protein_id = $intoractor->getId();
    		$protein_name = $intoractor->getName();
    		$protein_gene_name =  $intoractor->getGeneName();
    		$protein_sequence = $intoractor->getSequence();
    		 
    		$csv .= "$protein_gene_name, ";
    
    		 
    	}
    
    	return $csv;
    }
    
    public function getQueryQueryCsvInteractors($query_protein_array, $status_array){
    
    
    	$csv = null;
    
    	foreach($query_protein_array as  $query_protein_A){
    
    		$protein_A_id =  $query_protein_A->getId();
    		$protein_A_name =  $query_protein_A->getName();
    		$protein_A_gene_name =  $query_protein_A->getGeneName();
    
    
    		$csv .= "$protein_A_gene_name\n";
    
    
    	}
    
    	return $csv;
    }
     
    
    public function getPsiMitabData($search_query_array, $search_filter, $status_array){
        
        $query_protein_array = self::getProteinQueryArray($search_query_array);
        $psi_mitab = null;
        
        switch ($search_filter) {
            case 'query_query':
                $psi_mitab = self::getQueryQueryPsiMitab($query_protein_array, $status_array);
                break;
        
            case 'None':
                $psi_mitab = self::getInteractorInteractorPsiMitab($query_protein_array, $status_array);
                break;
        
            default:
        
        }
        
        return $psi_mitab;
        
        
    }
    

    public function getFastaSequences($search_query_array, $search_filter, $status_array){
    
        $query_protein_array = self::getProteinQueryArray($search_query_array);
        $fasta_sequences = null;
        

        
        switch ($search_filter) {
            case 'query_query':
                $fasta_sequences = self::getQueryQueryFastaSequences($query_protein_array, $status_array);
                break;
    
            case 'None':
                $fasta_sequences = self::getInteractorInteractorFastaSequences($query_protein_array, $status_array);
                break;
    
            default:
    
        }
    
        return $fasta_sequences;
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
    
    public function getQueryQueryPsiMitab($query_protein_array, $status_array){
        
        $psi_mitab = array();
        
        foreach($query_protein_array as  $query_protein_A){
        
            $protein_A_id =  $query_protein_A->getId();
            $protein_A_name =  $query_protein_A->getName();
            $protein_A_gene_name =  $query_protein_A->getGeneName();
        
            foreach($query_protein_array as $query_protein_B){
        
                $protein_B_id =  $query_protein_B->getId();
                $protein_B_name =  $query_protein_B->getName();
                $protein_B_gene_name =  $query_protein_B->getGeneName();
                 
                $interaction = self::getInteraction($query_protein_A, $query_protein_B, $status_array);
        
                if($interaction){
        
                    $psi_mitab[] = "$protein_A_name\t$protein_B_name\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
                    
                }
            }
        }
        
        return $psi_mitab;
        
    }

    
    public function getInteractorInteractorPsiMitab($query_protein_array, $status_array){
        
    
		    $psi_mitab = array();
		    
		    $interactor_array = array();
		    
		    foreach($query_protein_array as  $query_protein){
		    	
		    	
		    	
		    	
		    	
		    	
		    
		    	$interactions = self::getInteractions($query_protein, $status_array);
		    	 
		    	if($interactions){
		    
		    		foreach($interactions as $interaction){
		    
		    			$interaction_id = $interaction->getId();
		    			$interactor_A = $interaction->getInteractorA();
		    			$interactor_B = $interaction->getInteractorB();
		    
		    
		    				
		    			$protein_B = $this->getDoctrine()
		    			->getRepository('AppBundle:Protein')
		    			->find($interactor_B);
		    				
		    			$protein_B_id = $protein_B->getId();
		    			$protein_B_name = $protein_B->getName();
		    			$protein_B_gene_name =  $protein_B->getGeneName();
		    
		    
		    			$protein_A = $this->getDoctrine()
		    			->getRepository('AppBundle:Protein')
		    			->find($interactor_A);
		    				
		    			$protein_A_id = $protein_A->getId();
		    			$protein_A_name = $protein_A->getName();
		    			$protein_A_gene_name =  $protein_A->getGeneName();
		    
		    
		    			$interactor_array[] = $protein_A_id;
		    			$interactor_array[] = $protein_B_id;
		    
		    				
		    			$psi_mitab[] = "$protein_A_name\t$protein_B_name\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
		    			 
		    
		    		}
		    	}
		    }
		    
		    $psi_mitab = array_unique($psi_mitab);
		    
		    $psi_mitab = array_values($psi_mitab);
		    
		    
		    foreach($interactor_array as $interactor_A_id){
		    
		    	foreach($interactor_array as $interactor_B_id){
		    
		    
		    		$interaction = self::getInteraction($interactor_A_id, $interactor_B_id, $status_array);
		    
		    		if($interaction){
		    			$interaction_id = $interaction->getId();
		    				
		    			$protein_A = $this->getDoctrine()
		    			->getRepository('AppBundle:Protein')
		    			->find($interactor_A_id);
		    
		    			$protein_A_id = $protein_A->getId();
		    			$protein_A_name = $protein_A->getName();
		    			$protein_A_gene_name =  $protein_A->getGeneName();
		    
		    				
		    			$protein_B = $this->getDoctrine()
		    			->getRepository('AppBundle:Protein')
		    			->find($interactor_B_id);
		    
		    			$protein_B_id = $protein_B->getId();
		    			$protein_B_name = $protein_B->getName();
		    			$protein_B_gene_name =  $protein_B->getGeneName();
		    
		    				
		    			$psi_mitab[] = "$protein_A_name\t$protein_B_name\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
		    			 
		    		}
		    	}
		    }
		    
		    $psi_mitab = array_unique($psi_mitab);
		     
		    $psi_mitab = array_values($psi_mitab);
		    
		    return $psi_mitab;
    }
    

    
    public function  getInteractorInteractorFastaSequences($query_protein_array, $status_array){
       
        $fasta_sequences = null;
        $interactor_array = array();
        
		foreach($query_protein_array as  $query_protein_A){
		    
		    
		    
	        $protein_A_id =  $query_protein_A->getId();
            $interactor_array[] = $protein_A_id;

	        $interactions = self::getInteractions($query_protein_A, $status_array);
	        
            if($interactions){
        	    foreach($interactions as $interaction){
        	    
        	         $interaction_id = $interaction->getId();
        	         $interactor_A = $interaction->getInteractorA();
        	         	
        	         $protein_A = $this->getDoctrine()
        	         ->getRepository('AppBundle:Protein')
        	         ->find($interactor_A);
        	         	
        	         
        	         
        	         $protein_A_id = $protein_A->getId();
        	         
        	         $interactor_array[] = $protein_A_id;
        	         
        	         
                     $interactor_B = $interaction->getInteractorB();
                     
        	         $protein_B = $this->getDoctrine()
        	         ->getRepository('AppBundle:Protein')
        	         ->find($interactor_B);
        	          
        	         
        	         
        	         $protein_B_id = $protein_B->getId();

                    $interactor_array[] = $protein_B_id;
        	                 	             	             
        	     }
    		 }
 
		}
		
		$interactor_array = array_unique($interactor_array);
		$interactor_array = array_values($interactor_array);
		

		
		foreach($interactor_array as $interactor_id){

		    	
		    $intoractor = $this->getDoctrine()
		    ->getRepository('AppBundle:Protein')
		    ->find($interactor_id);
		    	
		    	
		    $protein_id = $intoractor->getId();
		    $protein_name = $intoractor->getName();
		    $protein_gene_name =  $intoractor->getGeneName();
		    $protein_sequence = $intoractor->getSequence();
		    	
		    $fasta_sequences .= ">$protein_gene_name\r\n";
		    $fasta_sequences .= "$protein_sequence\r\n";
		    	
		}
		
		return $fasta_sequences;
    }
    
    
    public function getQueryQueryFastaSequences($query_protein_array, $status_array){
         

        $fasta_sequences = null;
         
        foreach($query_protein_array as  $query_protein_A){
    
            $protein_A_id =  $query_protein_A->getId();
            $protein_A_name =  $query_protein_A->getName();
            $protein_A_gene_name =  $query_protein_A->getGeneName();
            $protein_A_sequence = $query_protein_A->getSequence();

            $fasta_sequences .= "$protein_A_gene_name\n";
            $fasta_sequences .= "$protein_A_sequence\n";
  
        }  
        
        return $fasta_sequences;
    }
    
    
    public function getInteractions($interactor_A, $status_array){
    
        $published = $status_array[0];
        $validated = $status_array[1];
        $verified = $status_array[2];
        $literature = $status_array[3];
        $score = $status_array[4];
        
         

        $interactor_A_id = $interactor_A->getID();

        $em = $this->getDoctrine()->getManager();
        $interaction_repository = $em->getRepository('AppBundle:Interaction');
        $qb = $interaction_repository->createQueryBuilder('i');
        $qb->select('i');
        $qb->join('i.datasets', 'd');
        $qb->where('i.interactor_A = :interactor_A');
        $qb->orWhere('i.interactor_B = :interactor_B');
        if($score){
        	$qb->andWhere('i.score >= :score');
        }
        
        
        $qb->setParameter('interactor_A', $interactor_A_id);
        $qb->setParameter('interactor_B', $interactor_A_id);
    
        if($score){
        	$qb->setParameter('score', $score);
        }
        
        $orX = $qb->expr()->orX();
        
        
        if($published){
        	$orX->add('di_status = :published_status');
        }
        
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
        
        foreach($interaction_array as $interaction){
        	
        	
        	$int_A = $interaction->getInteractorA();
        	$int_B = $interaction->getInteractorB();
        	
        	$int_A_name = $int_A->getGeneName();
        	$int_B_name = $int_B->getGeneName();
        	        	
        }
    
        if($interaction_array){
            return $interaction_array;
        }else{
            return false;
        }
    
    }
    
    public function getInteraction($interactor_A_id, $interactor_B_id, $status_array){
    	 
    	$published = $status_array[0];
    	$validated = $status_array[1];
    	$verified = $status_array[2];
    	$literature = $status_array[3];
    	$score = $status_array[4];
    
    
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
    
    	if($score){
    		$orX->add('i.score >= :score');
    	}
    	 
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
    	 
    	if($score){
    		$qb->setParameter('score', $score);
    	}
    	 
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
    
    public function isNewDatasetRequest($email, $request){
        
        
    	$em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT dr
							FROM AppBundle:Dataset_Request dr
							WHERE dr.email = :email
							AND dr.request = :request"
	                    );
	    	
	    $query->setParameter('email', $email);
	    $query->setParameter('request', $request);
	    $results = $query->getResult();
	
	
	    if($results){
	        return false;
	    }else{
	        return true;
	    }
        
    }
    
    
    public function getDatasetRequest($email, $request){
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT dr
							FROM AppBundle:Dataset_Request dr
							WHERE dr.email = :email
							AND dr.request = :request"
                        );
        
        $query->setParameter('email', $email);
        $query->setParameter('request', $request);
        $results = $query->getResult();
        
        return $results[0];
        
    }
    
}

?>
