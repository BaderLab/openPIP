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
/**
 * Search controller.
 *
 *
 */
class DownloadController extends Controller
{
    
    /**
     * Search Home
     *
     * @Route("/download", name="download", options={"expose": true}))
     * @Route("/admin/download", name="admin_download", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function downloadAction(Request $request)
    {
        
        
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('email', TextType::class)  
        ->add('dataset', TextType::class, array('attr' => array('style' => "width: 240px;")))             
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $email = $form["email"]->getData();
            $dataset = $form["dataset"]->getData();
            
            $dataset_request = new Dataset_Request();
            $dataset_request->setEmail($email);
            $dataset_request->setRequest($dataset);
            
            
            $doctrine_manager = $this->getDoctrine()->getManager();
            $doctrine_manager->persist($dataset_request);
            
            
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT ds
				FROM AppBundle:Dataset ds"
                        );
        
        $dataset_array = $query->getResult();
        
        
        
        
        
        
        
        
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
        $download = $admin_settings->getDownload();
        $show_downloads = $admin_settings->getShowDownloads();
        $show_download_all = $admin_settings->getShowDownloadAll();
        
        $login_status = false;
        
        $is_fully_authenticated = $this->get('security.context')
        ->isGranted('IS_AUTHENTICATED_FULLY');
        
        if($is_fully_authenticated){
            $login_status =  true;
        }
        
        return $this->render('download_2.html.twig', array(
                'form' => $form->createView(),
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
                'short_title' => $short_title,
		        'title' => $title,
                'footer' => $footer,
                'download' => $download,
                'show_downloads' => $show_downloads,
                'show_download_all' => $show_download_all,
                'dataset_array' => $dataset_array,
                'login_status' => $login_status
        
        ));
    }
    
    
    

    /**
     * Search Home
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
     * Search Home
     *
     * @Route("/download/csv/{search_term}", name="csv", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function csvAction($search_term)
    {
    
        $psi_mitab = "";
        $response = new Response();
    
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . 'csv.txt');
    
        $response->setContent($psi_mitab);
    
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
        $search_query = $search_term;
    
        $request = $this->getRequest();
        $search_setting_organism = $request->query->get('organism');
        $search_setting_domain = $request->query->get('domain');
        $search_setting_score = $request->query->get('score');
        $search_setting_max_interactions = $request->query->get('max_interactions');
         
        //$domain = getDomainByType($search_setting_domain);
         
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
         
         
        $psi_mitab = "#ID(s) interactor A\tID(s) interactor B\tAlt. ID(s) interactor A\tAlt. ID(s)interactor B\tAlias(es) interactor A\tAlias(es) interactor B\tInteraction detection method(s)\tPublication 1st author(s)\tPublication Identifier(s)\tTaxid interactor A\tTaxid interactor B\tInteraction type(s)\tSource database(s)\tInteraction identifier(s)\tConfidence value(s)\tExpansion method(s)\tBiological role(s)interactor A\tBiological role(s) interactor B\tExperimental role(s) interactor A\tExperimental role(s) interactor B\tType(s) interactor A\tType(s) interactor B\tXref(s) interactor A\tXref(s) interactor B\tInteraction Xref(s)\tAnnotation(s) interactor A\tAnnotation(s) interactor B\tInteraction annotation(s)\tHost organism(s)\tInteraction parameter(s)\tCreation date\tUpdate date\tChecksum(s) interactor A\tChecksum(s) interactor B\tInteraction Checksum(s)	Negative\tFeature(s) interactor A\tFeature(s) interactor B\tStoichiometry(s) interactor A\tStoichiometry(s) interactor B\tIdentification method participant A\tIdentification method participant B\r\n";
    
         
        $interaction_result_array = $query->getResult();
         
        foreach($interaction_result_array as $interaction_result){
            $em = $this->getDoctrine()->getManager();
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
                            "SELECT p
				FROM AppBundle:Protein p
				WHERE p.id = :interactor_A"
                            );
             
            $query->setParameter('interactor_A', $interactor_A);
             
            $interactor_A_array = $query->getResult();
             
            $_interactor_A = $interactor_A_array[0];
             
            $interactor_A_gene_name = $_interactor_A->getGeneName();
             
            $interactor_A_name = $_interactor_A->getName();
    
            $interactor_A_sequence = $_interactor_A->getSequence();
             
            $interactor_A_id  = $_interactor_A->getId();
             
            $identifier_repository = $this->getDoctrine()
            ->getRepository('AppBundle:Identifier');
             
            $identifier_A = $identifier_repository->findOneByIdentifier($interactor_A_name);
            $identifier_A_identifier = $identifier_A->getIdentifier();
            $identifier_A_naming_convention = $identifier_A->getNamingConvention();
            
            $identifier_B = $identifier_repository->findOneByIdentifier($interactor_B_name);
            $identifier_B_identifier = $identifier_B->getIdentifier();
            $identifier_B_naming_convention = $identifier_B->getNamingConvention();
            
            $psi_mitab .= "$identifier_A_naming_convention:$identifier_A_identifier\t$identifier_B_naming_convention:$identifier_B_identifier\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t\r\n";
    
        }
         
         
         
        $response = new Response();
    
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . 'psi_mitab.tab');
    
        $response->setContent($psi_mitab);
    
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
    
    public function  getInteractorInteractorFastaSequences($query_protein_array, $status_array){
       
        $fasta_sequences = null;
        
		foreach($query_protein_array as  $query_protein_A){
		    
	        $protein_A_id =  $query_protein_A->getId();
	        $protein_A_gene_name =  $query_protein_A->getGeneName();
	        $protein_A_sequence = $query_protein_A->getSequence();

	        $fasta_sequences .= ">$protein_A_gene_name\r\n";
	        $fasta_sequences .= "$protein_A_sequence\r\n";

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

        	         $fasta_sequences .= ">$protein_B_gene_name\r\n";
        	         $fasta_sequences .= "$protein_B_sequence\r\n";

        	                 	             	             
        	     }
    		 } 
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
    
    public function getInteraction($interactor_A, $interactor_B, $status_array){
         
        $published = $status_array[0];
        $validated = $status_array[1];
        $verified = $status_array[2];
        $literature = $status_array[3];
        $score = $status_array[4];
         
        $interactor_A_id = $interactor_A->getID();
        $interactor_B_id = $interactor_B->getID();
    
        $em = $this->getDoctrine()->getManager();
        $interaction_repository = $em->getRepository('AppBundle:Interaction');
        $qb = $interaction_repository->createQueryBuilder('i');
        $qb->select('i');
        $qb->join('i.datasets', 'd');
        $qb->where('i.interactor_A = :interactor_A');
        $qb->andWhere('i.interactor_B = :interactor_B');
        $qb->andWhere('i.score >= :score');
    
        $qb->setParameter('interactor_A', $interactor_A_id);
        $qb->setParameter('interactor_B', $interactor_B_id);
        $qb->setParameter('score', $score);
         
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
    
}

?>
