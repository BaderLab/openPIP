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
use AppBundle\Utils\Functions;
use AppBundle\Entity\Interaction_Network;

/**
 * Search controller.
 */
class DownloadController extends Controller
{
    
    /**
     * Downloads
     *
     * @Route("/download", name="download", options={"expose": true}))
     * @Route("/admin/download", name="admin_download", options={"expose": true}))
     * @Method({"GET", "POST"})
     */
    public function downloadAction(Request $request)
    {
    	$functions = $this->get('app.functions');
    	
    	$form = $this->createFormBuilder()
    	->add('add_dataset', CheckboxType::class, array(
    			'label' => 'Recieve Updates on Dataset',
    			'required' => false,
    			'attr' => array('value' => 'add_dataset', 'checked' => false)))
    	->add('request_dataset', TextType::class, array('attr' => array('style' => "width: 50%;")))
    	->add('request_file_format', TextType::class, array('attr' => array('style' => "width: 50%;")))
    	->getForm();
    			
    	$form->handleRequest($request);
    			
    	if ($form->isSubmitted()) {
    				
    		$add_dataset = $form["add_dataset"]->getData();
    		$request_dataset_id = $form["request_dataset"]->getData();
    		$request_file_format = $form["request_file_format"]->getData();

    		$doctrine_manager = $this->getDoctrine()->getManager();
    		$dataset = $this->getDoctrine()
    		->getRepository('AppBundle:Dataset')
    		->find($request_dataset_id);
    		
    		$dataset_file_path = $dataset->getFilePath();
    		$dataset_author = $dataset->getAuthor();
    		$dataset_year = $dataset->getYear();
    		$dataset_status = $dataset->getInteractionStatus();
    		$dataset_author = $dataset->getAuthor();
    		fwrite($handle, $dataset_file_path);
    		
    		if($dataset_status != 'published'){
				
    			$data_file_name =  $dataset_file_path;
			}else{
				
				$data_file_name = $dataset_author($dataset_year).$request_file_format;
			}
    		
    		if($add_dataset){
    			
    			$user = $this->get('security.token_storage')->getToken()->getUser();
    			
    			$user_id = $user->getId();
    			

    			
    			if(self::isNewUserDataset($user_id, $request_dataset_id)){
	    			$dataset->addUser($user);
	    			$user->addDataset($dataset);
	    			$doctrine_manager->flush();
    		
				}
    		}
    		
    		
    		
    		$response = new Response();
    		
    		$response->headers->set('Content-Type', 'text/csv');
    		$response->headers->set('Content-Disposition', "attachment;filename='$data_file_name.psi'");
    		
    		$response->setContent(file_get_contents( __DIR__ . "/../../../web/data/" . $dataset_file_path));

 

    		return $response;

    	}
        
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT ds
				FROM AppBundle:Dataset ds"
                        );
        
        $dataset_array = $query->getResult();
        
        
        $dataset_data_file_array = array();
        
        foreach($dataset_array as $dataset){
        	
        	$dataset_id = $dataset->getId();
        	
        	
        	$query = $em->createQuery(
        			"SELECT df
				FROM AppBundle:Data_File df
				JOIN  df.dataset ds
				WHERE
				ds.id = :dataset_id"
        			);
        	
        	$query->setParameter('dataset_id', $dataset_id);
        	
        	$data_file_array = $query->getResult();
        	
        	
        	$dataset_data_file_array[] = array($dataset, $data_file_array);
        	
        }

        $admin_settings =  $functions->getAdminSettings();
        
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
        $login_status = $functions->getLoginStatus();
        $admin_status = $functions->GetAdminStatus();
        
        return $this->render('download.html.twig', array(
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
        		'dataset_array' => $dataset_data_file_array,
        		'login_status' => $login_status,
        		'admin_status' => $admin_status,
        		'page' => 'download'
        
        ));
    }
    


    
    /**
     * Interaction PSI-MITAB
     *
     * @Route("/download/interaction_psi_mitab/", name="interaction_psi_mitab")
     * @Method({"GET", "POST"})
     */
    public function psi_mitabAction(Request $request)
    {
    	
    	$JSONinteraction_array = $request->get('data_request_data');
    	$JSONquery_parameters = $request->get('data_request_query_parameters');
    	$JSONquery_id_array = $request->get('data_request_query_id_array');
    	
    	$query_id_array = json_decode($JSONquery_id_array, true);
    	$interaction_array = json_decode($JSONinteraction_array, true);
    	$query_parameters = json_decode($JSONquery_parameters, true);

    	$add_user_interaction_network = $request->get('add_user_interaction_network');
    	$query_string = $request->get('data_request_search_query');
    		
    	$content = "Unique identifier for interactor A\tUnique identifier for interactor B\tAlternative identifier for interactor A\tAlternative identifier for interactor B\tAliases for A\tAliases for B\tInteraction detection methods\tFirst author\tIdentifier of the publication\tNCBI Taxonomy identifier for interactor A\tNCBI Taxonomy identifier for interactor B\tInteraction types	Source databases\tInteraction identifier(s)\tConfidence score\tComplex expansion\tBiological role A\tBiological role B\tExperimental role A\tExperimental role B\tInteractor type A\tInteractor type B\tXref for interactor A\tXref for interactor B\tXref for the interaction\tAnnotations for interactor A\tAnnotations for interactor B\tAnnotations for the interaction\tNCBI Taxonomy identifier for the host organism\tParameters of the interaction\tCreation date\tUpdate date\tChecksum for interactor A\tChecksum for interactor B\tChecksum for interaction\tnegative\tFeature(s) for interactor A\tFeature(s) for interactor B\tStoichiometry for interactor A\tStoichiometry for interactor B\tParticipant identification method for interactor A\tParticipant identification method for interactor B\r\n";        
    	
    	if($add_user_interaction_network === true){
    	   
    		self::addUserNetwork($query_string, $interaction_array, $query_parameters);
    	}
    	
    	
    	foreach($interaction_array as $interaction){

    		$dataset_array = $interaction['dataset_array'];
    		
    		$dataset_author_array = array();
    		$dataset_reference_array = array();
    		
    		$interaction_id_A = $interaction['interactor_A']['protein_id'];
    		$interaction_id_B = $interaction['interactor_B']['protein_id'];
    		
    		$query_status_A = 'non_query';
    		$query_status_B = 'non_query';
    		
    		if(in_array($interaction_id_A, $query_id_array)){
    			$query_status_A = 'query';
    		}
    		
    		if(in_array($interaction_id_B, $query_id_array)){
    			$query_status_B = 'query';
    		}
    		
    		foreach($dataset_array as $dataset){
    			
    			$dataset_author_array[] = $dataset['dataset_author'] . "(" . $dataset['year'] . ")";
    			
    			$dataset_reference_array[] = $dataset['dataset_reference'];
    			
    		}
    			
    		$dataset_author_string = join(";", $dataset_author_array);
    		
    		$dataset_reference_string = join(";", $dataset_reference_array);
    		
    		$uniprot_id_A = str_replace(',', '|', $interaction['interactor_A']['protein_uniprot_id']);
    		$uniprot_id_B = str_replace(',', '|', $interaction['interactor_B']['protein_uniprot_id']);
    		
    		$score = $interaction['score'];
    		
    		if(!$interaction['score']){
    			$score = '-';
    			
    		}
    		
    		if($uniprot_id_A == ''){
    			
    			$uniprot_id_A = '-';
    		}
    		if($uniprot_id_B == ''){
    			
    			$uniprot_id_B = '-';
    		}

    		$content .= $uniprot_id_A . "\t" . $uniprot_id_B . "\t" . $interaction['interactor_A']['protein_ensembl_id'] . "\t" . $interaction['interactor_B']['protein_ensembl_id'] . "\t" . $interaction['interactor_A']['protein_gene_name'] . "\t" . $interaction['interactor_B']['protein_gene_name'] . "\t-\t$dataset_author_string\t$dataset_reference_string\t9606\t9606\t-\t-\t-\t" . $score . "\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t$query_status_A\t$query_status_B\t" . $interaction['interaction_category_array']['highest_category_status'] . "\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
    		
    	}
    	
    	
    	$content .= self::getQueryParameterFooter($query_parameters);
    	
    	$response = new Response();
    	
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename=' . 'interactions.psi_mitab.tab');
    	
    	$response->setContent($content);
    	
    	return $response;
    }
    
    /**
     * Interaction Csv
     *
     * @Route("/download/interaction_csv/", name="interaction_csv")
     * @Method({"GET", "POST"})
     */
    public function interaction_csvAction(Request $request)
    {
    	  	
    	$JSONinteraction_array = $request->get('data_request_data');
    	$JSONquery_parameters = $request->get('data_request_query_parameters');
    	$JSONquery_id_array = $request->get('data_request_query_id_array');
    	
    	$query_id_array = json_decode($JSONquery_id_array, true);
    	$interaction_array = json_decode($JSONinteraction_array, true);
    	$query_parameters = json_decode($JSONquery_parameters, true);
    	
    	$add_user_interaction_network = $request->get('add_user_interaction_network');
    	$query_string = $request->get('data_request_search_query');
    	
    	
    	if($add_user_interaction_network === true){
    		
    		self::addUserNetwork($query_string, $interaction_array);
    	}
    	
    	$content = "Unique identifier for interactor A,Unique identifier for interactor B,Alternative identifier for interactor A,Alternative identifier for interactor B,Aliases for A,Aliases for B,Query Status Interactor A,Query Status Interactor B,First author,Identifier of the publication,Confidence score,Interaction Status\n";
    	
    	foreach($interaction_array as $interaction){
    		
    		$dataset_array = $interaction['dataset_array'];
    		
    		$dataset_author_array = array();
    		$dataset_reference_array = array();
    		
    		$interaction_id_A = $interaction['interactor_A']['protein_id'];
    		$interaction_id_B = $interaction['interactor_B']['protein_id'];
    		
    		$query_status_A = 'non_query';
    		$query_status_B = 'non_query';
    		
    		if(in_array($interaction_id_A, $query_id_array)){
    			$query_status_A = 'query';
    		}
    		
    		if(in_array($interaction_id_B, $query_id_array)){
    			$query_status_B = 'query';
    		}
    		
    		foreach($dataset_array as $dataset){
    			
    			$dataset_author_array[] = $dataset['dataset_author'] . "(" . $dataset['year'] . ")";
    			
    			$dataset_reference_array[] = $dataset['dataset_reference'];
    			
    		}
    		
    		$dataset_author_string = join(";", $dataset_author_array);
    		
    		$dataset_reference_string = join(";", $dataset_reference_array);
    		
    		$uniprot_id_A = str_replace(',', '|', $interaction['interactor_A']['protein_uniprot_id']);
    		$uniprot_id_B = str_replace(',', '|', $interaction['interactor_B']['protein_uniprot_id']);
    		
    		$score = $interaction['score'];
    		
    		if(!$interaction['score']){
    			$score = '-';
    			
    		}
    		
    		if($uniprot_id_A == ''){
    			
    			$uniprot_id_A = '-';
    		}
    		if($uniprot_id_B == ''){
    			
    			$uniprot_id_B = '-';
    		}
    	

    		$content .= $uniprot_id_A . "," . $uniprot_id_B . "," . $interaction['interactor_A']['protein_ensembl_id'] . "," . $interaction['interactor_B']['protein_ensembl_id'] . "," . $interaction['interactor_A']['protein_gene_name'] . "," . $interaction['interactor_B']['protein_gene_name'] . "," . $query_status_A . "," . $query_status_B . ",$dataset_author_string,$dataset_reference_string," . $score . "," . $interaction['interaction_category_array']['highest_category_status'] . "\r\n";
    		
    	}
    	
    	$content .= self::getQueryParameterFooter($query_parameters);
    	
    	$response = new Response();
    	
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename=' . 'interactions.csv');
    	
    	$response->setContent($content);
    	
    	return $response;
    	
    }
    
    
    /**
     * Interactor Csv
     *
     * @Route("/download/interactor_csv/", name="interactor_csv")
     * @Method({"GET", "POST"})
     */
    public function interactor_csvAction(Request $request)
    {
    	
    	
    	$JSONprotein_array = $request->get('data_request_data');
    	$JSONquery_parameters = $request->get('data_request_query_parameters');
    	$JSONquery_id_array = $request->get('data_request_query_id_array');
    	
    	$query_id_array = json_decode($JSONquery_id_array, true);
    	$protein_array = json_decode($JSONprotein_array, true);
    	$query_parameters = json_decode($JSONquery_parameters, true);
    	
    	$query_string = $request->get('data_request_search_query');
    	
    	
    	$content = "Gene Name,UniProt ID,Ensembl ID,Entrez ID,Description,Query Status,Tissue Expression,Subcellular Location\n";
    	
    	
    	
    	foreach($protein_array as $protein){
    		
    		$uniprot_id = str_replace(',', '|', $protein['protein_uniprot_id']); 
    		
    		$protein_id = $protein['protein_id'];
    		
    		$query_status = 'non_query';
    		
    		if(in_array($protein_id, $query_id_array)){
    			$query_status = 'query';
    		}
    		
    		
    		$content .= $protein['protein_gene_name'] . "," . $uniprot_id . "," . $protein['protein_ensembl_id']  . "," . $protein['protein_entrez_id'] . ',' . '"' . $protein['protein_description'] . '"' . ',' . $query_status ."\n";
    		
    	}
    	
    	$content .= self::getQueryParameterFooter($query_parameters);
    	$response = new Response();
    	
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename=' . 'interactor.csv');
    	
    	$response->setContent($content);
    	
    	return $response;
    	
    }
    
    
    /**
     * Interactor Fasta
     *
     * @Route("/download/multi_fasta/", name="multi_fasta")
     * @Method({"GET", "POST"})
     */
    public function multi_fastaAction(Request $request)
    {
    	
    	$JSONprotein_array = $request->get('data_request_data');
    	$JSONquery_parameters = $request->get('data_request_query_parameters');
    	$JSONquery_id_array = $request->get('data_request_query_id_array');
    	
    	$query_id_array = json_decode($JSONquery_id_array, true);
    	$protein_array = json_decode($JSONprotein_array, true);
    	$query_parameters = json_decode($JSONquery_parameters, true);
    	
    	$query_string = $request->get('data_request_search_query');
    	$content = null;
    	
    	foreach($protein_array as $protein){
    		
    		$uniprot_id = str_replace(',', '|', $protein['protein_uniprot_id']); 
    		
    		$protein_id = $protein['protein_id'];
    		
    		$query_status = 'non_query';
    		
    		if(in_array($protein_id, $query_id_array)){
    			$query_status = 'query';
    		}
    		
    		$content .= ">Gene Name:" . $protein['protein_gene_name'] . ",UniProt ID:" . $uniprot_id . ",Ensembl ID:" . $protein['protein_ensembl_id']  . ",Entrez ID:" . $protein['protein_entrez_id'] . ",Query Status:$query_status" . "\r\n" . $protein['protein_sequence'] . "\r\n";
    	}
    	
    	$content .= self::getQueryParameterFooter($query_parameters);
    	$response = new Response();
    	
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename=' . 'interactor.fasta');
    	
    	$response->setContent($content);
    	
    	return $response;
    	
    }
      
    
	/**
    * Enrichment Term Csv
    *
    * @Route("/download/enriched_term_protein_csv/{search_term}", name="enriched_term_protein_csv", options={"expose": true}))
    * @Method({"GET", "POST"})
    */
    public function enriched_term_protein_csvAction($search_term)
    {
    	
    	$protein_identifier_array = split(',', $search_term);
    	
    	$protein_array = array();
    	foreach ($protein_identifier_array as $protein_identifier){
    		
    		$em = $this->getDoctrine()->getManager();
    		$query = $em->createQuery(
    				"SELECT i
							FROM AppBundle:Identifier i
							WHERE i.identifier = :identifier"
    				);
    		
    		$query->setParameter('identifier', $protein_identifier);
    		$identifier_array = $query->getResult();
    		
    		$identifier_object = $identifier_array[0];
    		$proteins = $identifier_object->getProteins();
    		foreach($proteins as $protein){
    			$protein_array[] = $protein;
    		}
    		
    	}
    	
    	$content = "Gene Name,UniProt ID,Ensembl ID, Entrez ID\n";

    	foreach($protein_array as $protein){
    		
    		$gene_name = $protein->getGeneName();
    		$uniprot_id = $protein->getUniprotId();
    		$ensembl_id = $protein->getEnsemblId();
    		$entrez_id = $protein->getEntrezId();
    		
    		$content .= $gene_name. "," . $uniprot_id. "," . $ensembl_id . "," . $entrez_id . "\n";
    	}
    	

    	$response = new Response();
    	
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename= interactor_csv.csv');
    	
    	$response->setContent($content);
    	
    	return $response;
    	
    }
    
    
    

    
    
    
    public function getQueryParameterFooter($query_parameters){
    
    	$version_query_parameter = $query_parameters[0];
    	$score_parameter = $query_parameters[1];
    	$category_parameter_array= $query_parameters[2];
    	$tissue_expression_parameter_array= $query_parameters[3];
    	$date = getdate();
    	
	    $content = "\r\n";
	    $content .= "##\r\n";
	    $content .= "## Date Downloaded: " . $date['month'] . ' ' . $date['mday'] . ' ' . $date['year'] . "\r\n";
	    $content .= "## Database Version: " . $version_query_parameter  . "\r\n";
	    $content .= "## Query Parameters\r\n";
	    $content .= "## Score: " . $score_parameter  . "\r\n";
	    $content .= "## Interaction Catagories: ";
	    
	    $catagory_array = array();
	    
	    foreach($category_parameter_array as $category => $category_parameter){
	    	
	    	if($category_parameter == true){
	    		$catagory_array[] = $category;
	    	}
	    }
	    
	    $catagory_string = join(',', $catagory_array);
	    $content .= $catagory_string . "\r\n";
	    
	    $content .= "## Tissue Expression: ";
	    
	    $tissue_expression_array = array();
	    
	    foreach($tissue_expression_parameter_array as $tissue => $tissue_expression_parameter){
	    	
	    	if($tissue_expression_parameter == true){
	    		$tissue_expression_array[] = $tissue;
	    	}
	    }
	    
	    $tissue_string = join(',', $tissue_expression_array);
	    
	    if($tissue_string == ''){
	    	$content .= 'None' . "\r\n";
	    }else{
	    	$content .= $tissue_string . "\r\n";
	    }
    
	    return $content;
	    
    }
    
    
    
    
    
    public function getSequencesFastaFormat($search_query_array, $query_parameters_array){
    	
    	$query_protein_array = self::getProteinQueryArray($search_query_array);
    	$fasta_sequences = null;
    	
    	$filter_parameter = $query_parameters_array[4];
    	
    	switch ($filter_parameter) {
    		
    		case 'query_query':
    			
    			$fasta_sequences = self::getSequencesWithQueryQueryFilterAndFastaFormat($query_protein_array, $query_parameters_array);
    			break;
    			
    		case 'None':
    			
    			$fasta_sequences = self::getSequencesWithInteractorInteractorFilterAndFastaFormat($query_protein_array, $query_parameters_array);
    			break;
    			
    		default:
    			
    	}
    	
    	return $fasta_sequences;
    }
    
    public function getSequencesWithQueryQueryFilterAndFastaFormat($query_protein_array, $status_array){
    	
    	$fasta_sequences = null;
    	
    	foreach($query_protein_array as  $query_protein){
    		
    		$protein_gene_name =  $query_protein->getGeneName();
    		$protein_sequence = $query_protein->getSequence();
    		
    		$fasta_sequences .= ">$protein_gene_name\r\n";
    		$fasta_sequences .= "$protein_sequence\r\n";
    		
    	}
    	
    	return $fasta_sequences;
    	
    }
    
    public function  getSequencesWithInteractorInteractorFilterAndFastaFormat($query_protein_array, $query_parameters_array){
    	
    	$published_parameter = $query_parameters_array[0];
    	$validated_parameter = $query_parameters_array[1];
    	$verified_parameter = $query_parameters_array[2];
    	$literature_parameter = $query_parameters_array[3];
    	$score_parameter = $query_parameters_array[5];
    	
    	$status_array = array($published_parameter, $validated_parameter, $verified_parameter, $literature_parameter, $score_parameter);
    	
    	$fasta_sequences = null;
    	$interactor_array = array();

    	$interaction_data = $this->get('app.interaction_data');
    		
    	$interactor_array = $interaction_data->getInteractorsOfQueryArray($query_protein_array, $status_array);
    	
    	foreach($interactor_array as $interactor_id){
    		
    		$intoractor = $this->getDoctrine()
    		->getRepository('AppBundle:Protein')
    		->find($interactor_id);
    		
    		$protein_gene_name =  $intoractor->getGeneName();
    		$protein_sequence = $intoractor->getSequence();
    		
    		$fasta_sequences .= ">$protein_gene_name\r\n";
    		$fasta_sequences .= "$protein_sequence\r\n";
    		
    	}
    	
    	return $fasta_sequences;
    	
    }
    

    
    
    
    public function getInteractorGeneNamesCsvFormat($search_query_array, $query_parameters_array){
    	
    	$query_protein_array = self::getProteinQueryArray($search_query_array);
    	$csv = null;
    	
    	$filter_parameter = $query_parameters_array[4];
    	
    	switch ($filter_parameter) {
    		case 'query_query':
    			$csv = self::getInteractorGeneNamesWithQueryQueryFilterAndCsvFormat($query_protein_array, $query_parameters_array);
    			break;
    			
    		case 'None':
    			   			
    			$csv = self::getInteractorGeneNamesWithInteractorInteractorFilterAndCsvFormat($query_protein_array, $query_parameters_array);
    			break;
    			
    		default:
    			
    	}
    	
    	return $csv;
    }
    
    public function getInteractorGeneNamesWithQueryQueryFilterAndCsvFormat($query_protein_array, $query_parameters_array){
    	
    	$csv = null;
    	
    	foreach($query_protein_array as  $query_protein){
    		
    		$protein_gene_name =  $query_protein->getGeneName();
    		
    		$csv .= "$protein_gene_name\n";
    	}
    	
    	return $csv;
    }
    
    public function  getInteractorGeneNamesWithInteractorInteractorFilterAndCsvFormat($query_protein_array, $query_parameters_array){
    	
    	$published_parameter = $query_parameters_array[0];
    	$validated_parameter = $query_parameters_array[1];
    	$verified_parameter = $query_parameters_array[2];
    	$literature_parameter = $query_parameters_array[3];
    	$score_parameter = $query_parameters_array[5];
    	
    	$status_array = array($published_parameter, $validated_parameter, $verified_parameter, $literature_parameter, $score_parameter);
    	
    	$csv = null;
    	$interactor_array = array();
    	
    		
    	$interaction_data = $this->get('app.interaction_data');
    		
    	$interactions = $interaction_data->getInteractionsAmongInteractorsOfQueryArrayWithParameters($query_protein_array, $status_array);
    	

    	if($interactions){
    		
    		
    		foreach($interactions as $interaction){
    				
    			$interactor_A_id = $interaction['interactor_A'];
    			$interactor_B_id = $interaction['interactor_B'];
    				
    			$interactor_array[] = $interactor_A_id;
    			$interactor_array[] = $interactor_B_id;
    				
    		}
    	}

    	$interactor_array = array_unique($interactor_array);
    	$interactor_array = array_values($interactor_array);
    	
    	foreach($interactor_array as $interactor_id){
    		
    		$intoractor = $this->getDoctrine()
    		->getRepository('AppBundle:Protein')
    		->find($interactor_id);
    		
    		$protein_gene_name =  $intoractor->getGeneName();
    		$protein_uniprot_id =  $intoractor->getUniprotId();
    		$protein_ensembl_id =  $intoractor->getEnsemblId();
    		
    		$csv .= "$protein_gene_name,$protein_uniprot_id,$protein_ensembl_id,\r\n";
    		
    	}

    	
    	
    	
    	return $csv;
    }
    
    
  
    public function getInteractionsCsvFormat($search_query_array, $query_parameters_array){
    	
    	
    	$query_protein_array = self::getProteinQueryArray($search_query_array);
    	$csv = null;
    	$csv_array = array();
    	
    	$filter_parameter = $query_parameters_array[4];
    	
    	switch ($filter_parameter) {
    		
    		case 'query_query':
    			$csv_array = self::getInteractionsWithQueryQueryFilterAndCsvFormat($query_protein_array, $query_parameters_array);
    			break;
    			
    		case 'None':
    			$csv_array = self::getInteractionsWithInteractorInteractorFilterAndCsvFormat($query_protein_array, $query_parameters_array);
    			break;
    			
    		default:
    			
    	}
    	
    	$csv_array = array_unique($csv_array);
    	$csv_array = array_values($csv_array);
    	
    	$csv = "ID(s) interactor A,ID(s) interactor B,Alias(es) interactor A,Alias(es) interactor B\r\n";
    	
    	foreach($csv_array as $csv_line){
    		
    		$csv .= $csv_line;
    	}
    	
    	return $csv;
    	
    }
    
    public function  getInteractionsWithQueryQueryFilterAndCsvFormat($query_protein_array, $query_parameters_array){
    	
    	$csv = array();
    	
    	$interaction_data = $this->get('app.interaction_data');
    	
    	$interactions = $interaction_data->getInteractionsAmongInteractorsOfQueryArray($interactor_array);
    	
    	foreach($interactions as $interaction){
    		
    		$interactor_A_id = $interaction['interactor_A'];
    		$interactor_B_id = $interaction['interactor_B'];
    		
    		$intoractor_A = $this->getDoctrine()
    		->getRepository('AppBundle:Protein')
    		->find($interactor_A_id);
    		
    		$intoractor_B = $this->getDoctrine()
    		->getRepository('AppBundle:Protein')
    		->find($interactor_B_id);
    		
    		$protein_A_gene_name = $intoractor_A->getGeneName();
    		$protein_A_uniprot_id= $intoractor_A->getUniprotId();
    		
    		$protein_B_gene_name = $intoractor_B->getGeneName();
    		$protein_B_uniprot_id = $intoractor_B->getUniprotId();
    		
    		$csv[] = "$protein_A_uniprot_id,$protein_B_uniprot_id,$protein_A_gene_name,$protein_B_gene_name\r\n";
    	}
    	
    	return $csv;
    }
    
    public function getInteractionsWithInteractorInteractorFilterAndCsvFormat($query_protein_array, $query_parameters_array){
    	
    	$csv_array = array();
    	
    	$published_parameter = $query_parameters_array[0];
    	$validated_parameter = $query_parameters_array[1];
    	$verified_parameter = $query_parameters_array[2];
    	$literature_parameter = $query_parameters_array[3];
    	$score_parameter = $query_parameters_array[5];
    	
    	$status_array = array($published_parameter, $validated_parameter, $verified_parameter, $literature_parameter, $score_parameter);
    	
    	$interaction_data = $this->get('app.interaction_data');
    	
    	$interactions = $interaction_data->getInteractionsAmongInteractorsOfQueryArrayWithParameters($query_protein_array, $status_array);
    	
    	if($interactions){
    		
    		foreach($interactions as $interaction){
    			
    			$interactor_A_id = $interaction['interactor_A'];
    			$interactor_B_id = $interaction['interactor_B'];
    			
    			$intoractor_A = $this->getDoctrine()
    			->getRepository('AppBundle:Protein')
    			->find($interactor_A_id);
    			
    			$intoractor_B = $this->getDoctrine()
    			->getRepository('AppBundle:Protein')
    			->find($interactor_B_id);
    			
    			$protein_A_gene_name = $intoractor_A->getGeneName();
    			$protein_A_uniprot_id= $intoractor_A->getUniprotId();
    			
    			$protein_B_gene_name = $intoractor_B->getGeneName();
    			$protein_B_uniprot_id= $intoractor_B->getUniprotId();
    			
    			$csv_array[] = "$protein_A_uniprot_id,$protein_B_uniprot_id,$protein_A_gene_name,$protein_B_gene_name\r\n";
    		}
    		
    	}
    	

    	return $csv_array;
    }
    
    
 
    
    public function  getInteractionsWithQueryQueryFilterAndPsiMiTabFormat($query_protein_array, $query_parameters_array){
    	
    	$psi_mitab_array = array();
    	
    	$interaction_data = $this->get('app.interaction_data');
    	
    	$interactions = $interaction_data->getInteractionsAmongInteractorsOfQueryArray($query_protein_array);
    	
    	foreach($interactions as $interaction){
    		
    		$interactor_A_id = $interaction['interactor_A'];
    		$interactor_B_id = $interaction['interactor_B'];
    		
    		$intoractor_A = $this->getDoctrine()
    		->getRepository('AppBundle:Protein')
    		->find($interactor_A_id);
    		
    		$intoractor_B = $this->getDoctrine()
    		->getRepository('AppBundle:Protein')
    		->find($interactor_B_id);
    		
    		$protein_A_gene_name = $intoractor_A->getGeneName();
    		$protein_A_uniprot_id= $intoractor_A->getUniprotId();
    		
    		$protein_B_gene_name = $intoractor_B->getGeneName();
    		$protein_B_uniprot_id= $intoractor_B->getUniprotId();
    		
    		$psi_mitab_array[] = "$protein_A_uniprot_id\t$protein_B_uniprot_id\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
    	}
    	
    	return $psi_mitab_array;
    }
    
    public function getInteractionsWithInteractorInteractorFilterAndPsiMiTabFormat($query_protein_array, $query_parameters_array){
    	
    	$psi_mitab_array = array();
    	
    	$published_parameter = $query_parameters_array[0];
    	$validated_parameter = $query_parameters_array[1];
    	$verified_parameter = $query_parameters_array[2];
    	$literature_parameter = $query_parameters_array[3];
    	$score_parameter = $query_parameters_array[5];
    	
    	$status_array = array($published_parameter, $validated_parameter, $verified_parameter, $literature_parameter, $score_parameter);
    	
    	$interaction_data = $this->get('app.interaction_data');
    	
    	$interactions = $interaction_data->getInteractionsAmongInteractorsOfQueryArrayWithParameters($query_protein_array, $status_array);
    	
    	if($interactions){
    		
    		foreach($interactions as $interaction){
    			
    			$interactor_A_id = $interaction['interactor_A'];
    			$interactor_B_id = $interaction['interactor_B'];
    			
    			$score = $interaction['score'];
    			$interaction_id = $interaction['id'];
    			
    			$interaction_object = $this->getDoctrine()
    			->getRepository('AppBundle:Interaction')
    			->find($interaction_id);
    			
    			$datasets = $interaction_object->getDatasets();
    			
    			$dataset_array = array();
    			$pubmed_array = array();
    			foreach($datasets as $dataset){
    				
    				$author = $dataset->getAuthor();
    				$year = $dataset->getYear();
    				$pubmed_id = $dataset->getPubmedId();
    				
    				if($author && $year){
    					$dataset_array[] = "$author($year)";
    				}else{
    					$dataset_array[] = 'unpublished';
    				}
    				
    				$pubmed_array[] = $pubmed_id;
    			}
    			
    			$dataset_string = join(";", $dataset_array);
    			$pubmed_string =  join(";", $pubmed_array);
    			
    			$intoractor_A = $this->getDoctrine()
    			->getRepository('AppBundle:Protein')
    			->find($interactor_A_id);
    			
    			$intoractor_B = $this->getDoctrine()
    			->getRepository('AppBundle:Protein')
    			->find($interactor_B_id);
    			
    			$protein_A_gene_name = $intoractor_A->getGeneName();
    			$protein_A_uniprot_id= $intoractor_A->getUniprotId();
    			$protein_A_ensembl_id= $intoractor_A->getEnsemblId();
    			$protein_B_gene_name = $intoractor_B->getGeneName();
    			$protein_B_uniprot_id = $intoractor_B->getUniprotId();
    			$protein_B_ensembl_id= $intoractor_B->getEnsemblId();
    			
    			$psi_mitab_array[] = "$protein_A_uniprot_id\t$protein_B_uniprot_id\t$protein_A_ensembl_id\t$protein_B_ensembl_id\t$protein_A_gene_name\t$protein_B_gene_name\t-\t$dataset_string\t$pubmed_string\t9606\t9606\t-\t-\t-\t$score\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
    			
    		}
    		
    	}
    	
    	
    	return $psi_mitab_array;
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
    		$protein_A_uniprot_id =  $query_protein_A->getUniprotId();
    		$protein_A_gene_name =  $query_protein_A->getGeneName();
    		
    		foreach($query_protein_array as $query_protein_B){
    			
    			$protein_B_id =  $query_protein_B->getId();
    			$protein_B_uniprot_id=  $query_protein_B->getUniprotId();
    			$protein_B_gene_name =  $query_protein_B->getGeneName();
    			
    			$interaction = self::getInteraction($query_protein_A, $query_protein_B, $status_array);
    			
    			if($interaction){
    				
    				$csv[] = "$protein_A_uniprot_id,$protein_B_uniprot_id,$protein_A_gene_name,$protein_B_gene_name\r\n";
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
    				$protein_B_uniprot_id= $protein_B->getUniprotId();
    				$protein_B_gene_name =  $protein_B->getGeneName();
    				
    				
    				$protein_A = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_A);
    				
    				$protein_A_id = $protein_A->getId();
    				$protein_A_uniprot_id= $protein_A->getUniprotId();
    				$protein_A_gene_name =  $protein_A->getGeneName();
    				
    				
    				$interactor_array[] = $protein_A_id;
    				$interactor_array[] = $protein_B_id;
    				
    				
    				$csv[] = "$protein_A_uniprot_id,$protein_B_uniprot_id,$protein_A_gene_name,$protein_B_gene_name\r\n";
    				
    				
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
    				$protein_A_uniprot_id= $protein_A->getUniprotId();
    				$protein_A_gene_name =  $protein_A->getGeneName();
    				
    				
    				$protein_B = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_B_id);
    				
    				$protein_B_id = $protein_B->getId();
    				$protein_B_uniprot_id= $protein_B->getUniprotId();
    				$protein_B_gene_name =  $protein_B->getGeneName();
    				
    				
    				$csv[] = "$protein_A_uniprot_id,$protein_B_uniprot_id,$protein_A_gene_name,$protein_B_gene_name\r\n";
    				
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
    		$protein_uniprot_id= $intoractor->getUniprotId();
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
    		$protein_A_uniprot_id=  $query_protein_A->getUniprotId();
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
    		$protein_A_uniprot_id=  $query_protein_A->getUniprotId();
    		$protein_A_gene_name =  $query_protein_A->getGeneName();
    		
    		foreach($query_protein_array as $query_protein_B){
    			
    			$protein_B_id =  $query_protein_B->getId();
    			$protein_B_uniprot_id=  $query_protein_B->getUniprotId();
    			$protein_B_gene_name =  $query_protein_B->getGeneName();
    			
    			$interaction = self::getInteraction($query_protein_A, $query_protein_B, $status_array);
    			
    			if($interaction){
    				
    				$psi_mitab[] = "$protein_A_uniprot_id\t$protein_B_uniprot_id\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
    				
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
    				$protein_B_uniprot_id = $protein_B->getUniprotId();
    				$protein_B_gene_name =  $protein_B->getGeneName();
    				
    				
    				$protein_A = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_A);
    				
    				$protein_A_id = $protein_A->getId();
    				$protein_A_uniprot_id= $protein_A->getUniprotId();
    				$protein_A_gene_name =  $protein_A->getGeneName();
    				
    				
    				$interactor_array[] = $protein_A_id;
    				$interactor_array[] = $protein_B_id;
    				
    				
    				$psi_mitab[] = "$protein_A_uniprot_id\t$protein_B_uniprot_id\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
    				
    				
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
    				$protein_A_uniprot_id = $protein_A->getUniprotId();
    				$protein_A_gene_name =  $protein_A->getGeneName();
    				
    				
    				$protein_B = $this->getDoctrine()
    				->getRepository('AppBundle:Protein')
    				->find($interactor_B_id);
    				
    				$protein_B_id = $protein_B->getId();
    				$protein_B_uniprot_id= $protein_B->getUniprotId();
    				$protein_B_gene_name =  $protein_B->getGeneName();
    				
    				
    				$psi_mitab[] = "$protein_A_uniprot_id\t$protein_B_uniprot_id\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
    				
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
    		$protein_uniprot_id = $intoractor->getUniprotId();
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
    		$protein_A_uniprot_id=  $query_protein_A->getUniprotId();
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
    		$orX->add('d.interaction_status = :published_status');
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
    
    public function isNewUserDataset($user_id, $dataset_id){
    
	    $em = $this->getDoctrine()->getManager();
	    $interaction_repository = $em->getRepository('AppBundle:Dataset');
	    $qb = $interaction_repository->createQueryBuilder('d');
	    $qb->select('d');
	    $qb->join('d.users', 'u');
	    $qb->where('d.id = :dataset_id');
	    $qb->andWhere('u.id = :user_id');
	    
	    $qb->setParameter('dataset_id', $dataset_id);
	    $qb->setParameter('user_id', $user_id);
	    
	    $query = $qb->getQuery();
	    
	    $dataset_array = $query->getResult();
	    
	    if($dataset_array){
	    	return false;
	    }else{
	    	return true;
	    }
    }
    
    public function addUserNetwork($query_string, $interaction_array, $query_parameters){
	    
    	$user = $this->get('security.token_storage')->getToken()->getUser();
	    
	    $em = $this->getDoctrine()->getManager();
	    
	    $interaction_network = new Interaction_Network();
	    
	    $interaction_network->setName($query_string);
	    $interaction_network->setInteractorQueryString($query_string);
	    
	    foreach($interaction_array as $interaction_row){
	    	
	    	$interaction_id = $interaction_row['interaction_id'];
	    	
	    	
	    	$repository = $em->getRepository('AppBundle:Interaction');
	    	$interaction = $repository->find($interaction_id );
	    	
	    	$interaction->addInteractionNetwork($interaction_network);
	    	$interaction_network->addInteraction($interaction);
	    	$em->persist($interaction);
	    	
	    }
	    
	    
	    
	    
	    $score_parameter = $query_parameters[1];
	    $category_array =  $query_parameters[2];

	    

	    $category_string_array = array();
	    $query_category_string_array = array();
	    foreach($category_array as $key => $value){
	    	
	    	if($value == true){
	    		$category_string_array[] = $key;
	    	}
	    	if($value == false){
	    		$query_category_string_array[] = $key .'=false';
	    	}
	    }
	    $category_array_string = join(',', $category_string_array);
	    $query_category_string = join('&', $query_category_string_array);

	    $interaction_network->setScoreParameter($score_parameter);
	    if($score_parameter){
	    	$query_score_parameter = 'score=' . $score_parameter;
			
		}
	    
	    
	    $interaction_network->setCategoryArray($category_array_string);
	    
	    $array = [$query_score_parameter, $query_category_string];
	    $string = join('&', $array);
	    
	    $query = $query_string;
	    $query .= '?' . $string;
	    $interaction_network->setQuery($query);

	    
	    
	    $interaction_network->addUser($user);
	    $user->addInteractionNetwork($interaction_network);
	    
	    $em->persist($user);
	    $em->persist($interaction_network);
	    
	    $em->flush();
    
    }
}

?>
