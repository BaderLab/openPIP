<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Domain;
use AppBundle\Entity\Identifier;
use AppBundle\Entity\Protein;
use AppBundle\Entity\Interaction;
use AppBundle\Entity\Data_File;
use AppBundle\Entity\Organism;
use AppBundle\Entity\Dataset;
use AppBundle\Form\Data_FileType;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Data controller.
 *
 * @Route("/admin/data_manager")
 */
class DataManagerController extends Controller
{
		
	/**
	 * @Route("/", name="data_manager")
	 * @Method({"GET", "POST"})
	 */
	public function announcement_managerAction(Request $request)
	{
        $data_File = new Data_File();
        $form = $this->createForm('AppBundle\Form\Data_FileType', $data_File);
        $form->handleRequest($request);
        
        //stats for data upload
        $interactions_added = 0;
        $new_proteins_added = 0;
        $new_identifier_added = 0;
        
        
        if ($form->isSubmitted() && $form->isValid()) {
        		
        	/** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        	$file = $data_File->getDataFile();
        	
        	$fileName = $file->getClientOriginalName();
        	
        	$file->move(
        			$this->container->getParameter('data_file_directory'),
        			$fileName
        			);
        	
        	$data_File->setDataFile($fileName);
        	
        	$upload_dir = $this->get('kernel')->getRootDir() . '/../web/uploads/data/';
        	 
        	$filepath = $upload_dir . $fileName;
        		
        	$handle = fopen($filepath , "r");
        	
        	
        	
        	while ($data = fgetcsv($handle, 0, "\t"))
        	{
        		
        		$interactions_added++;
        	
        		list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $alt_interactor_B_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method,
        				$publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database,
        				$interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B,
        				$experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A,
        				$xref_interactor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism,
        				$interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum,
        				$negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B,
        				$identification_method_participant_A, $identification_method_participant_B) = $data;
        				 
        	
        		$em = $this->getDoctrine()->getManager();
        		$interaction = new Interaction();
        		//Protein A
        		
        		//Column 1 eg. uniprotkb:O15156
        		$interactor_A_id_array = explode(":", $interactor_A_id);
        		
        		//eg. uniprotkb
        		$identifier_naming_convention_interactor_A_id = $interactor_A_id_array[0];
        		
        		//eg. O15156
        		$identifier_identifier_interactor_A_id = $interactor_A_id_array[1];
        		
        		//true if new and false if it already exists
        		$is_new_protein_A = self::isNewProtein($identifier_identifier_interactor_A_id, $identifier_naming_convention_interactor_A_id);
        		
        		//
        		$protein_A = '';
        		$organism_A = '';
        		
        		//if protein exists
        		if($is_new_protein_A == false){
        		
        			//get protein id
        			$protein_id = self::getProteinIdFromIdentifier($identifier_identifier_interactor_A_id, $identifier_naming_convention_interactor_A_id);
        			 
        			//get the protein
        			$protein_A = $this->getDoctrine()
        			->getRepository('AppBundle:Protein')
        			->find($protein_id);
        		
        			//if protein is new
        		}elseif($is_new_protein_A == true){

        			//add protein
        			$protein_A = new Protein();
        			$protein_A->setName($identifier_identifier_interactor_A_id);
        			$new_proteins_added++;
        			 
        			//add identifier
        			$identifier_A = new Identifier();
        			$identifier_A->setProtein($protein_A);
        			$identifier_A->setIdentifier($identifier_identifier_interactor_A_id);
        			$identifier_A->setNamingConvention($identifier_naming_convention_interactor_A_id);
        			$em->persist($identifier_A);

        			$new_identifier_added++;
        			
        			$organisms_to_add = array();
        		    
        			//Alternate identifiers
        			if($alt_interactor_A_id != '-'){
        			
        				//intact:EBI-742397|uniprotkb:Q5JQQ8|uniprotkb:Q96LZ4|uniprotkb:Q96M47|uniprotkb:Q9BXU6|uniprotkb:A8K8V6
        				$alt_interactor_A_id_array =  explode("|", $alt_interactor_A_id);
        			
        				//intact:EBI-742397, uniprotkb:Q5JQQ8, uniprotkb:Q96LZ4, uniprotkb:Q96M47, uniprotkb:Q9BXU6, uniprotkb:A8K8V6
        				foreach($alt_interactor_A_id_array as $_alt_interactor_A_id){
        					 
        					//intact:EBI-742397
        					$alt_interactor_array = explode(":", $_alt_interactor_A_id);
        					//intact
        					$alt_identifier_naming_convention = $alt_interactor_array[0];
        					//EBI-742397
        					$alt_identifier_identifier = $alt_interactor_array[1];
        					 
        					//add identifer
        					$alt_identifier = new Identifier();
        					$alt_identifier->setProtein($protein_A);
        					$alt_identifier->setIdentifier($alt_identifier_identifier);
        					$alt_identifier->setNamingConvention($alt_identifier_naming_convention);
        					$em->persist($alt_identifier);        					 
        				}
        			}
        			
        			
        			if($interactor_A_alias != '-'){
        			
        				$interactor_A_alias_array =  explode("|", $interactor_A_alias);
        				 
        				foreach($interactor_A_alias_array as  $_interactor_A_alias){
        			
        					$_interactor_A_alias_array = explode(":", $_interactor_A_alias);
        			
        					$interactor_A_alias_naming_convention = $_interactor_A_alias_array[0];
        			
        					$interactor_A_alias_identifier = $_interactor_A_alias_array[1];
        			
        					
        					
        					//add identifer
        					$interactor_A_alias_identifier_object = new Identifier();
        					$interactor_A_alias_identifier_object->setProtein($protein_A);
        					$interactor_A_alias_identifier_object->setIdentifier($interactor_A_alias_identifier);
        					$interactor_A_alias_identifier_object->setNamingConvention($interactor_A_alias_naming_convention);
        					$em->persist($interactor_A_alias_identifier_object);
        				}
        			}
        			
        			
        			//Organism
        			if($taxid_interactor_A != '-'){
        				
        				$taxid_interactor_A_array =  explode("|", $taxid_interactor_A);
        				
        				foreach($taxid_interactor_A_array as  $_taxid_interactor_A){
        					
        					preg_match( '/(\d+)/', $_taxid_interactor_A, $matches);
        					$taxid_id = $matches[1];

        					if(in_array($taxid_id, $organisms_to_add) == true){
        					
        						
        					
        					}else{

	        					$is_new_taxid_id = self::isNewOrganism($taxid_id);
	        					
	        					if($is_new_taxid_id == false){
	        						
	        						$organism_A = self::getOrganismFromTaxidId($taxid_id);
	        						
	        					}elseif($is_new_taxid_id == true){
	        						
	        						if(in_array($taxid_id, $organisms_to_add)){
	        							
	        							$organisms_to_add[] = $taxid_id;
	        							
	        						}else{
	        							
	        							$organisms_to_add[] = $taxid_id;
	
		        						$url = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=taxonomy&id=$taxid_id";
		        						$str=file_get_contents($url);
		        						
		        						$organism_A = new Organism;
		        						$crawler = new Crawler($str);
		        						
		        						$organism_A->setTaxidId($taxid_id);
		        						
		        						try{
		        							//get the sequence node from xml
		        							$scientific_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="ScientificName"]');
		        						
		        							//if the node is present
		        							if($scientific_name->count()){
		        								//get the sequence text from node
		        								$scientific_name_text = $scientific_name->text();
		        								$organism_A->setScientficName($scientific_name_text);
		
		        							}
		        						}
		        						catch(Exception $e) {
		        						}
		        						
		        						
		        						try{
		        							//get the sequence node from xml
		        							$common_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="CommonName"]');
		        						
		        							//if the node is present
		        							if($common_name->count()){
		        								//get the sequence text from node
		        								$common_name_text = $common_name->text();
		        								$organism_A->setCommonName($common_name_text);
		        						
		        							}
		        						}
		        						catch(Exception $e) {
		        						}
		        						
		        						
		        						try{
		        							//get the sequence node from xml
		        							$common_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="CommonName"]');
		        						
		        							//if the node is present
		        							if($common_name->count()){
		        								//get the sequence text from node
		        								$common_name_text = $common_name->text();
		        								$organism_A->setCommonName($common_name_text);
		        						
		        							}
		        						}
		        						catch(Exception $e) {
		        						}
		        						
		        						$em->persist($organism_A);
	        						}
	        					} 
        					}
        				}	
        			}
        			

        			
        			//if the identifier is from uniprot
        			if($identifier_naming_convention_interactor_A_id == 'uniprotkb'){
        			
        				//get the uniprot accession
        				$uniprot_accession = $identifier_identifier_interactor_A_id;
        			
        				//get the uniprot xml url
        				$url = "http://www.uniprot.org/uniprot/$uniprot_accession.xml";
        			
        				//get the uniprot xml
        				$str=file_get_contents($url);
        			
        				//delete string from xml (bug fix)
        				$str=str_replace('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://uniprot.org/uniprot http://www.uniprot.org/support/docs/uniprot.xsd"', "", $str);
        			
        				//create crawler for xml
        				$crawler = new Crawler($str);
        			
        				try{
        					//get the sequence node from xml
        					$sequence = $crawler->filter('uniprot > entry > sequence');
        					 
        					//if the node is present
        					if($sequence->count()){
        						//get the sequence text from node
        						$sequence_text = $sequence->text();
        			
        						//set the sequece text for the protein
        						$protein_A->setSequence($sequence_text);
        					}
        				}
        				catch(Exception $e) {  			
        				}
        				try{
        					//get the gene name node from xml
        					$gene_name = $crawler->filter('uniprot > entry > gene > name');
        						
        					//if the node is present
        					if($gene_name->count()){
        			
        						//get the gene name text from node
        						$gene_name_text = $gene_name->text();
        			
        						//set the gene name text for the protein
        						$protein_A->setGeneName($gene_name_text);
        			
        						$identifier_gene_name = new Identifier();
        						$identifier_gene_name->setIdentifier($gene_name_text);
        						$identifier_gene_name->setNamingConvention('gene_name');
        						$identifier_gene_name->setProtein($protein_A);
        						$em->persist($identifier_gene_name);

        					}
        				}
        				catch(Exception $e) {      			
        				}		
        			}
        			
        			$protein_A->addOrganism($organism_A);
        			$organism_A->addProtein($protein_A);
        		}
        		
        		//Protein B
        		
        		//Column 1 eg. uniprotkb:O15156
        		$interactor_B_id_array = explode(":", $interactor_B_id);
        		
        		//eg. uniprotkb
        		$identifier_naming_convention_interactor_B_id = $interactor_B_id_array[0];
        		
        		//eg. O15156
        		$identifier_identifier_interactor_B_id = $interactor_B_id_array[1];
        		
        		//true if new and false if it already exists
        		$is_new_protein_B = self::isNewProtein($identifier_identifier_interactor_B_id, $identifier_naming_convention_interactor_B_id);
        		
        		//
        		$protein_B = '';
        		$organism_B = '';

        		
        		//if protein exists
        		if($is_new_protein_B == false){
        		
        			//get protein id
        			$protein_id = self::getProteinIdFromIdentifier($identifier_identifier_interactor_B_id, $identifier_naming_convention_interactor_B_id);
        		
        			//get the protein
        			$protein_B = $this->getDoctrine()
        			->getRepository('AppBundle:Protein')
        			->find($protein_id);
        		
        			//if protein is new
        		}elseif($is_new_protein_B == true){
        		
        			//add protein
        			$protein_B = new Protein();
        			$protein_B->setName($identifier_identifier_interactor_B_id);
        			$new_proteins_added++;
        		
        			//add identifier
        			$identifier_B = new Identifier();
        			$identifier_B->setProtein($protein_B);
        			$identifier_B->setIdentifier($identifier_identifier_interactor_B_id);
        			$identifier_B->setNamingConvention($identifier_naming_convention_interactor_B_id);
        			$em->persist($identifier_B);
        		
        			$new_identifier_added++;
        		
        			//Blternate identifiers
        			if($alt_interactor_B_id != '-'){
        				 
        				//intact:EBI-742397|uniprotkb:Q5JQQ8|uniprotkb:Q96LZ4|uniprotkb:Q96M47|uniprotkb:Q9BXU6|uniprotkb:B8K8V6
        				$alt_interactor_B_id_array =  explode("|", $alt_interactor_B_id);
        				 
        				//intact:EBI-742397, uniprotkb:Q5JQQ8, uniprotkb:Q96LZ4, uniprotkb:Q96M47, uniprotkb:Q9BXU6, uniprotkb:B8K8V6
        				foreach($alt_interactor_B_id_array as $_alt_interactor_B_id){
        		
        					//intact:EBI-742397
        					$alt_interactor_array = explode(":", $_alt_interactor_B_id);
        					//intact
        					$alt_identifier_naming_convention = $alt_interactor_array[0];
        					//EBI-742397
        					$alt_identifier_identifier = $alt_interactor_array[1];
        		
        					//add identifer
        					$alt_identifier = new Identifier();
        					$alt_identifier->setProtein($protein_B);
        					$alt_identifier->setIdentifier($alt_identifier_identifier);
        					$alt_identifier->setNamingConvention($alt_identifier_naming_convention);
        					$em->persist($alt_identifier);
        				}
        			}
        			 

        			if($interactor_B_alias != '-'){
        			
        				$interactor_B_alias_array =  explode("|", $interactor_B_alias);
        				 
        				foreach($interactor_B_alias_array as  $_interactor_B_alias){
        			
        					$_interactor_B_alias_array = explode(":", $_interactor_B_alias);
        			
        					$interactor_B_alias_naming_convention = $_interactor_B_alias_array[0];
        			
        					$interactor_B_alias_identifier = $_interactor_B_alias_array[1];
        			
        					//add identifer
        					$interactor_B_alias_identifier_object = new Identifier();
        					$interactor_B_alias_identifier_object->setProtein($protein_B);
        					$interactor_B_alias_identifier_object->setIdentifier($interactor_B_alias_identifier);
        					$interactor_B_alias_identifier_object->setNamingConvention($interactor_B_alias_naming_convention);
        					$em->persist($interactor_B_alias_identifier_object);
        				}
        			}
        			
        			
        			//Organism
        			if($taxid_interactor_B != '-'){
        		
        				$taxid_interactor_B_array =  explode("|", $taxid_interactor_B);
        		
        				foreach($taxid_interactor_B_array as  $_taxid_interactor_B){
        					 
        					preg_match( '/(\d+)/', $_taxid_interactor_B, $matches);
        					$taxid_id = $matches[1];
        					
        					if(in_array($taxid_id, $organisms_to_add) == true){
        						 
        						$organism_B = $organism_A;
        						 
        					}else{
	        					 
	        					$is_new_taxid_id = self::isNewOrganism($taxid_id);
	        					 
	        					if($is_new_taxid_id == false){
	        		
	        						$organism_B = self::getOrganismFromTaxidId($taxid_id);
	        		
	        					}elseif($is_new_taxid_id == true){
	        						
	        						if(in_array($taxid_id, $organisms_to_add)){
	        							 
	        							$organisms_to_add[] = $taxid_id;
	        							 
	        						}else{
	        							 
	        							$organisms_to_add[] = $taxid_id;
	        						
		        						$url = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=taxonomy&id=$taxid_id";
		        						$str=file_get_contents($url);
		        		
		        						$organism_B = new Organism;
		        						$crawler = new Crawler($str);
		        		
		        						$organism_B->setTaxidId($taxid_id);
		        						
		        						try{
		        							//get the sequence node from xml
		        							$scientific_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="ScientificName"]');
		        		
		        							//if the node is present
		        							if($scientific_name->count()){
		        								//get the sequence text from node
		        								$scientific_name_text = $scientific_name->text();
		        								$organism_B->setScientficName($scientific_name_text);
		        		
		        							}
		        						}
		        						catch(Exception $e) {
		        						}
		        		
		        		
		        						try{
		        							//get the sequence node from xml
		        							$common_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="CommonName"]');
		        		
		        							//if the node is present
		        							if($common_name->count()){
		        								//get the sequence text from node
		        								$common_name_text = $common_name->text();
		        								$organism_B->setCommonName($common_name_text);
		        		
		        							}
		        						}
		        						catch(Exception $e) {
		        						}
		        		
		        		
		        						try{
		        							//get the sequence node from xml
		        							$common_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="CommonName"]');
		        		
		        							//if the node is present
		        							if($common_name->count()){
		        								//get the sequence text from node
		        								$common_name_text = $common_name->text();
		        								$organism_B->setCommonName($common_name_text);
		        		
		        							}
		        						}
		        						catch(Exception $e) {
		        						}
		        		
		        						$em->persist($organism_B);
	        						}
	        					}
        					}
        				}
        			}

        			//if the identifier is from uniprot
        			if($identifier_naming_convention_interactor_B_id == 'uniprotkb'){
        				 
        				//get the uniprot accession
        				$uniprot_accession = $identifier_identifier_interactor_B_id;
        				 
        				//get the uniprot xml url
        				$url = "http://www.uniprot.org/uniprot/$uniprot_accession.xml";
        				 
        				//get the uniprot xml
        				$str=file_get_contents($url);
        				 
        				//delete string from xml (bug fix)
        				$str=str_replace('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://uniprot.org/uniprot http://www.uniprot.org/support/docs/uniprot.xsd"', "", $str);
        				 
        				//create crawler for xml
        				$crawler = new Crawler($str);
        				 
        				try{
        					//get the sequence node from xml
        					$sequence = $crawler->filter('uniprot > entry > sequence');
        		
        					//if the node is present
        					if($sequence->count()){
        						//get the sequence text from node
        						$sequence_text = $sequence->text();
        						 
        						//set the sequece text for the protein
        						$protein_B->setSequence($sequence_text);
        					}
        				}
        				catch(Exception $e) {
        				}
        				try{
        					//get the gene name node from xml
        					$gene_name = $crawler->filter('uniprot > entry > gene > name');
        		
        					//if the node is present
        					if($gene_name->count()){
        						 
        						//get the gene name text from node
        						$gene_name_text = $gene_name->text();
        						 
        						//set the gene name text for the protein
        						$protein_B->setGeneName($gene_name_text);
        						 
        						$identifier_gene_name = new Identifier();
        						$identifier_gene_name->setIdentifier($gene_name_text);
        						$identifier_gene_name->setNamingConvention('gene_name');
        						$identifier_gene_name->setProtein($protein_B);
        						$em->persist($identifier_gene_name);
        		
        					}
        				}
        				catch(Exception $e) {
        				}
        			}
        			
        			$protein_B->addOrganism($organism_B);
        			$organism_B->addProtein($protein_B);
        		}
        		
        		$dataset = '';
        		
        		if($publication_identifier != '-'){
        			 
        			//intact:EBI-742397|uniprotkb:Q5JQQ8|uniprotkb:Q96LZ4|uniprotkb:Q96M47|uniprotkb:Q9BXU6|uniprotkb:A8K8V6
        			$publication_identifier_array =  explode("|", $publication_identifier);
        			 
        			//intact:EBI-742397, uniprotkb:Q5JQQ8, uniprotkb:Q96LZ4, uniprotkb:Q96M47, uniprotkb:Q9BXU6, uniprotkb:A8K8V6
        			foreach($publication_identifier_array  as $_publication_identifier){
        		
        				//intact:EBI-742397
        				$_publication_identifier_array = explode(":", $_publication_identifier);
        				
        				$reference = $_publication_identifier_array[0];
        				
        				$reference_id = $_publication_identifier_array[1];
        				
        				if($reference == 'pubmed'){
        					
        					$is_new_dataset = self::isNewDataset($reference_id);
        					
        					if($is_new_dataset == false){
        						
        						$dataset = self::getDatasetFromReferenceId($reference_id);
        					
        					}elseif($is_new_dataset == true){
        						
        						$dataset = new Dataset();
        						 
        						$dataset->setReference($reference_id);
        						 
        						$url = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&id=$reference_id";
        						$str=file_get_contents($url);
        						 
        						$crawler = new Crawler($str);
        						 
        						 
        						try{
        							//get the sequence node from xml
        							$reference_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="Title"]');
        							 
        						
        							if($reference_name->count()){
        								//get the sequence text from node
        								$reference_name_text = $reference_name->text();
        								$dataset->setName($reference_name_text);
        						
        							}
        						
        						
        						}
        						catch(Exception $e) {
        						} 
        						$em->persist($dataset);
        					}
        				}
        			}
        		}


        		$interaction->setInteractorA($protein_A);
        		$interaction->setInteractorB($protein_B);
        		$interaction->addDataset($dataset);
        		$dataset->addInteraction($interaction);    		
        		$em->persist($data_File);
        		$em->persist($protein_A);
        		$em->persist($protein_B);
        		$em->persist($interaction);
        		$em->flush();

       		}       
		}
		
		return $this->render('data_manager.html.twig', array(
				'new_proteins_added' => $new_proteins_added,
				'interactions_added' => $interactions_added,
				'data_File' => $data_File,
				'form' => $form->createView(),
		));
						
	}
	
	
	public function isNewProtein($identifier, $naming_convention){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT i
							FROM AppBundle:Identifier i
							WHERE i.identifier = :identifier
							AND i.naming_convention = :naming_convention"
				);
			
		$query->setParameter('identifier', $identifier);
		$query->setParameter('naming_convention', $naming_convention);
		$results = $query->getResult();
		if($results){
			return false;
		}else{
			return true;
		}
	
	}
	
	public function isNewOrganism($taxid_id){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT o
				FROM AppBundle:Organism o
				WHERE o.taxid_id = :taxid_id"
				);
			
		$query->setParameter('taxid_id', $taxid_id);

		$results = $query->getResult();
		if($results){
			return false;
		}else{
			return true;
		}
	
	}
	
	public function isNewDataset($reference_id){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT d
				FROM AppBundle:Dataset d
				WHERE d.reference = :reference"
				);
			
		$query->setParameter('reference', $reference_id);
	
		$results = $query->getResult();
		if($results){
			return false;
		}else{
			return true;
		}
	
	}
	
	public function getProteinIdFromIdentifier($identifier, $naming_convention){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT i
							FROM AppBundle:Identifier i
							WHERE i.identifier = :identifier
							AND i.naming_convention = :naming_convention"
				);
			
		$query->setParameter('identifier', $identifier);
		$query->setParameter('naming_convention', $naming_convention);
		$identifier_array = $query->getResult();
		
		$identifier_object = $identifier_array[0];
		$protein_id = $identifier_object->getProtein();

		return $protein_id;
		
	}
	
	public function getOrganismFromTaxidId($taxid_id){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT o
							FROM AppBundle:Organism o
							WHERE o.taxid_id = :taxid_id"
				);
			
		$query->setParameter('taxid_id', $taxid_id);

		$organism_array = $query->getResult();
		
		$organism_object = $organism_array[0];

		
		return $organism_object;
		
	}
	
	public function getDatasetFromReferenceId($reference_id){
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT d
							FROM AppBundle:Dataset d
							WHERE d.reference = :reference"
				);
			
		$query->setParameter('reference', $reference_id);
		
		$dataset_array = $query->getResult();
		
		$dataset_object = $dataset_array[0];
		
		
		return $dataset_object;
	}
	
	
}
?>
