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
use AppBundle\Entity\External_Link;
use AppBundle\Entity\Support_Information;
use AppBundle\Entity\Interaction_Support_Information;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Data_FileType;
use AppBundle\Form\DataType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Data controller.
 *
 * @Route("/admin/data_manager")
 */
class DataController extends Controller
{
		
	/**
	 * @Route("/", name="data_manager")
	 * @Method({"GET", "POST"})
	 */
	public function dataAction(Request $request)
	{
	    gc_enable();
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT ds
				FROM AppBundle:Dataset ds"
	                    );
	    
	    $dataset_array = $query->getResult();
	    
	    $delete_form = self::getDeleteForm();
	    $delete_form->handleRequest($request);
	    
	    if ($delete_form->isSubmitted() && $delete_form->isValid()) {
	    
	    
	        $dataset_id = $delete_form->get('dataset_to_delete')->getData();
	    
	        self::deleteData($dataset_id);
	    
	        return $this->redirectToRoute('data_manager');
	    }
	    

	    $data_File = new Data_File();
	    $data_form = $this->createForm('AppBundle\Form\Data_FileType', $data_File);
	    $data_form->handleRequest($request);
	    
	    if ($data_form->isSubmitted() && $data_form->isValid()) {
	        
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
	         
	        $form_data = $data_form->getData();
	         
	        $file_row = 0;
	        
	        
	        while ($file_data = fgetcsv($handle, 0, "\t"))
	        {
	            if($file_row < 1){ $file_row++; continue; }
	            
	            try{
	                //variable for each mitab coloumn
	                list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $alt_interactor_B_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method,
	                                $publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database,
	                                $interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B,
	                                $experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A,
	                                $xref_interactor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism,
	                                $interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum,
	                                $negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B,
	                                $identification_method_participant_A, $identification_method_participant_B) = $file_data;
	                
                    $doctrine_manager = $this->getDoctrine()->getManager();
                    $doctrine_manager->getConfiguration()->setSQLLogger(null);
                    
                    if(self::isNewInteraction($interactor_A_id, $interactor_B_id) == true){
                        
                        
                        //Protein
                        $protein_A_array = self::proteinHandler($interactor_A_id, $doctrine_manager);
                        $protein_A = $protein_A_array[0];
                        $identifier_A_protein_array = $protein_A_array[1];
                        $links_array_A = $protein_A_array[2];
                         
                         

                         
                        $protein_B_array = self::proteinHandler($interactor_B_id, $doctrine_manager);
                        $protein_B = $protein_B_array[0];
                        $identifier_B_protein_array = $protein_B_array[1];
                        $links_array_B = $protein_B_array[2];
                        

                        
                        $dataset = self::datasetHandler($publication_identifier, $publication_first_author);
                        
                        
                        //Interaction
                        $interaction = self::interactionHandler($feature_interactor_B, $confidence_value);
                        
                        
                        $support_informations_array = self::support_informationHandler($interaction_parameter);
                        $support_information_array = '';
                        $interaction_support_information_array = '';
                        if($support_informations_array){
                            $support_information_array = $support_informations_array[0];
                            $interaction_support_information_array = $support_informations_array[1];
                             
                        }
                        
                        if($interaction_support_information_array){
                            foreach ($interaction_support_information_array as $interaction_support_information){
                        
                                $interaction->addInteractionSupportInformation($interaction_support_information);
                                $interaction_support_information->setInteraction($interaction);
                                $doctrine_manager->persist($interaction_support_information);
                            }
                        }
                        

                        
                        foreach($identifier_A_protein_array as $identifier_A_protein){
                            $identifier_A_protein->setProtein($protein_A);
                            $doctrine_manager->persist($identifier_A_protein);
                        }
                        
                        foreach($identifier_B_protein_array as $identifier_B_protein){
                            $identifier_B_protein->setProtein($protein_B);
                            $doctrine_manager->persist($identifier_B_protein);
                        }
                        
                        
                        
                        if($links_array_A){
                            foreach ($links_array_A as $link_A){
                        
                                $doctrine_manager->persist($link_A);
                            }
                        }
                        if($links_array_B){
                            foreach ($links_array_B as $link_B){
                        
                                $doctrine_manager->persist($link_B);
                            }
                        }
                        
                        if($dataset){
                            $dataset->addInteraction($interaction);
                            $interaction->addDataset($dataset);
                            $doctrine_manager->persist($dataset);
                        }
                        $interaction->setInteractorA($protein_A);
                        $interaction->setInteractorB($protein_B);
                        
                        $doctrine_manager->persist($interaction);
                        $doctrine_manager->flush();
                        $doctrine_manager->clear();
                        gc_collect_cycles();
                        
                    }elseif(self::isNewDatasetFromPublicationIdentifier($publication_identifier) == false){
                        
                        $interaction = self::getInteractionByIds($interactor_A_id, $interactor_B_id);
                        $dataset = self::getDatasetByPublicationIdentifier($publication_identifier);
                        
                        if(self::assertRelationshipExistsInteractionDataset($interaction, $dataset) == false){
                        
                            $dataset->addInteraction($interaction);
                            $interaction->addDataset($dataset);
                            $doctrine_manager->persist($dataset);
                            $doctrine_manager->persist($interaction);
                            $doctrine_manager->flush();
                            $doctrine_manager->clear();
                            gc_collect_cycles();
                        }
                        
                    }elseif(self::isNewDatasetFromPublicationIdentifier($publication_identifier) == true){
                        
                        $interaction = self::getInteractionByIds($interactor_A_id, $interactor_B_id);
                        $dataset = self::datasetHandler($publication_identifier, $publication_first_author);
                        
                        $dataset->addInteraction($interaction);
                        $interaction->addDataset($dataset);
                        $doctrine_manager->persist($dataset);
                        $doctrine_manager->persist($interaction);
                        $doctrine_manager->flush();
                        $doctrine_manager->clear();
                        gc_collect_cycles();
                        
                    }
	                                
	                                
	            }catch(Exception $e) {
                }
	            
	        }
	        
	    }
	    
	    $admin_settings = $this->getDoctrine()
	    ->getRepository('AppBundle:Admin_Settings')
	    ->find(1);
	    
	    $footer = $admin_settings->getFooter();
	    $main_color_scheme = $admin_settings->getMainColorScheme();
	    $header_color_scheme = $admin_settings->getHeaderColorScheme();
	    $logo_color_scheme = $admin_settings->getLogoColorScheme();
	    $button_color_scheme = $admin_settings->getButtonColorScheme();
	    $short_title = $admin_settings->getShortTitle();
	    $title = $admin_settings->getTitle();
	    
	    return $this->render('data_manager.html.twig', array(
	            'delete_form' => $delete_form->createView(),
	            'form' => $data_form->createView(),
	            'dataset_array' => $dataset_array,
	            'footer' => $footer,
	            'main_color_scheme' => $main_color_scheme,
	            'header_color_scheme' => $header_color_scheme,
	            'logo_color_scheme' => $logo_color_scheme,
	            'button_color_scheme' => $button_color_scheme,
	            'short_title' => $short_title,
	            'title' => $title
	    ));
	    
	}
	
	
	public function getDeleteForm(){
	    
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT ds
				FROM AppBundle:Dataset ds"
	                    );
	    
	    $dataset_array = $query->getResult();
	    
	    $delete_dataset_array = array();
	    
	    foreach($dataset_array as $dataset){
	        $id = $dataset->getId();
	        $year = $dataset->getYear();
	        $author = $dataset->getAuthor();
	    
	        $delete_dataset_array[$id] = "$author ($year)";
	    
	    }
	    
	    $defaultData = array('message' => 'Type your message here');
	    $delete_form = $this->createFormBuilder($defaultData)
	    ->add('dataset_to_delete', ChoiceType::class, array(
	            'choices' => $delete_dataset_array))->getForm();
	    
	    return $delete_form;
	    
	}
	
	public function getDataForm(){
	    
	    $data = array();
	    $form = $this->createFormBuilder($data)
	    ->add('data_file', FileType::class)
	    ->getForm();
	    
        return $form;
	}
	
	
	
	
	public function assertNotNull($value){

		if($value == '' || $value == ' ' || $value == '-' || $value == null){
			return false;
		}else{
			return true;
		}
	}
	
	public function datasetHandler($publication_identifier, $publication_first_author){
	    
	    $dataset = '';

	    
	        $dataset = self::createDatasetFromData($publication_identifier, $publication_first_author);

	    
	    return $dataset;
	}
	
	public function createDatasetFromData($publication_identifier, $publication_first_author){
	    
	    //$reference_array =  explode("|", $publication_identifier);
	    
	    $dataset = '';
	    if($publication_identifier == 'validated'){
	        if(self::isNewDataset('0000') == true){
	             
	            $dataset = new Dataset();
	            $dataset->setInteractionStatus('validated');
	            $dataset->setPubmedId('0000');
	             
	        }else{
	             
	            $dataset = self::getDatasetByReference('0000');
	             
	        }
	    }
	    //foreach($reference_array as $reference){
	         
	        $_reference_array = explode(":", $publication_identifier);
	    
	        $name = $_reference_array[0];
	        
	        if(array_key_exists(1, $_reference_array)){
	           $id = $_reference_array[1];
	        }
	        
	        if ($name == 'pubmed'){
	            
	           if(self::isNewDataset($id) == true){
	               
	               $dataset = new Dataset();
	               $dataset->setPubmedId($id);
	               $dataset->setAuthor($publication_first_author);
	               $dataset->setInteractionStatus('published');
	               
	           }else{
	               
	               $dataset = self::getDatasetByReference($id);
	               
	           }

	          }
	      // }  
	      return $dataset;
	}
	
	public function getDatasetByReference($id){
	    
	    
	    $em = $this->getDoctrine()->getManager();
	    

	    $query = $em->createQuery(
	                    "SELECT d
							FROM AppBundle:Dataset d
							WHERE d.pubmed_id = :pubmed_id"
	                    );
	    
	    $query->setParameter('pubmed_id', $id);
         
	    $results = $query->getResult();
	    
	    return $results[0];
 
	    
	}
	
	
	public function getDatasetByPublicationIdentifier($publication_identifier){
	     
	     
	    $em = $this->getDoctrine()->getManager();
	     
	    $reference_array =  explode("|", $publication_identifier);
	
	
	    foreach($reference_array as $reference){
	         /*
	        $_reference_array = explode(":", $reference);
	
	        $name = $_reference_array[0];
	        $id = $_reference_array[1];
	
	*/
	        if ($reference == 'validated'){
	
	            $query = $em->createQuery(
	                            "SELECT d
        							FROM AppBundle:Dataset d
        							WHERE d.pubmed_id = :pubmed_id"
	                            );
	             
	            $query->setParameter('pubmed_id', '0000');
	
	            $results = $query->getResult();
	             
	            return $results[0];
	        }
	    }
	     
	}

	public function isNewDataset($id){
	    
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT d
							FROM AppBundle:Dataset d
							WHERE d.pubmed_id = :pubmed_id"
	                    );
	
	    $query->setParameter('pubmed_id', $id);
	    $results = $query->getResult();
	
	
	    if($results){
	        return false;
	    }else{
	        return true;
	    }
	}
	
	
	public function isNewDatasetFromPublicationIdentifier($publication_identifier){
	    
	    
        $reference_array =  explode("|", $publication_identifier);
	    
	    $return = true;
	    
	    foreach($reference_array as $reference){
	         
	        $_reference_array = explode(":", $reference);
	    
	        $name = $_reference_array[0];
	        if(array_key_exists(1,$_reference_array)){
	        $id = $_reference_array[1];
	        }
	        
	        if ($name == 'pubmed'){
	            
	           if(self::isNewDataset($id) == false){
	               
	               $return = false;
	               
	           }	            
	            
	        }elseif($name == 'validated'){
	              if(self::isNewDataset('0000') == false){
	              
	                  $return = false;
	              
	              }
	          }
	        
	        
	        
	        
	        
	    }
	       
        return $return;
	    
	}
	
	
	

	public function assertRelationshipExistsProteinOrganism($protein, $organism){
	    
	    $p_id = $protein->getId();
	    
	    $o_id = $organism->getId();
	    
	    $em = $this->getDoctrine()->getManager();
	    
	    
	    
	    $query = $em->createQuery(
	                    "SELECT p
				FROM AppBundle:Protein p
	            JOIN p.organisms o
				WHERE p.id = :p_id
	            AND  o.id = :o_id      
	                    
	                    "
	                    );
	    $query->setParameter('p_id', $p_id);
	    $query->setParameter('o_id', $o_id);

	    $results = $query->getResult();
	    if($results){
	        return true;
	    }else{
	        return false;
	    }
	    
	    
	}
	
	public function assertRelationshipExistsDomainOrganism($domain, $organism){
	     
	    $d_id = $domain->getId();
	     
	    $o_id = $organism->getId();
	     
	    $em = $this->getDoctrine()->getManager();
	     
	    $query = $em->createQuery(
	                    "SELECT d
				FROM AppBundle:Domain d
	            JOIN d.organisms o
				WHERE d.id = :d_id
	            AND  o.id = :o_id"
	            );
	    $query->setParameter('d_id', $d_id);
	    $query->setParameter('o_id', $o_id);
	
	    $results = $query->getResult();
	    if($results){
	        return true;
	    }else{
	        return false;
	    }   
	}
	
	
	public function assertRelationshipExistsInteractionDataset($interaction, $dataset){
	
	    $i_id = $interaction->getId();
	
	    $d_id = $dataset->getId();
	
	    $em = $this->getDoctrine()->getManager();
	
	    $query = $em->createQuery(
	                    "SELECT i
				FROM AppBundle:Interaction i
	            JOIN i.datasets d
				WHERE i.id = :i_id
	            AND  d.id = :d_id"
	                    );
	    $query->setParameter('i_id', $i_id);
	    $query->setParameter('d_id', $d_id);
	
	    $results = $query->getResult();
	    if($results){
	        return true;
	    }else{
	        return false;
	    }
	}

	
	
	public function support_informationHandler($annotation_interactor_A){
	
	    $support_informations_array = array(); 
	    if(self::assertNotNull($annotation_interactor_A)){
	
	        $support_informations_array = self::createSupportInformationsFromData($annotation_interactor_A);   
	    }

	    return $support_informations_array;  
	}
	
	
	public function createSupportInformationsFromData($annotation_interactor_A){
	
	    $annotation_interactor_A_array =  explode(";", $annotation_interactor_A);
	
	    $support_information_array = array();
	    $interaction_support_information_array = array();
	    
	    foreach($annotation_interactor_A_array as $annotation_interactor_A){
	        
	        $_annotation_interactor_A_array = explode(":", $annotation_interactor_A);
	        

	        $value = '0';
	        $name = '';
	        
	        if($_annotation_interactor_A_array[0]){
	            $name = $_annotation_interactor_A_array[0];

	        }
	        if($_annotation_interactor_A_array[1]){
	            $value = $_annotation_interactor_A_array[1];

	        }


	        if(self::isNewSupportInformation($name) == true){

	            $support_information = new Support_Information;
	            $support_information->setName($name);
	            
	            $interaction_support_information = new Interaction_Support_Information;
	            if($value){
	               $interaction_support_information->setValue($value);
	            }
	            $interaction_support_information->setSupportInformation($support_information);
	            $interaction_support_information_array[] = $interaction_support_information;
	            $support_information_array[] = $support_information;
	            
	        }elseif(self::isNewSupportInformation($name) == false){

	            $support_information = self::getSupportInformationFromName($name);
	            $interaction_support_information = new Interaction_Support_Information;
	            $interaction_support_information->setValue($value);
	            $interaction_support_information->setSupportInformation($support_information);
	            $interaction_support_information_array[] = $interaction_support_information;
	            
	        }

	    }

	    $return_array = array($support_information_array, $interaction_support_information_array);
	    return $return_array;
	}
	

	public function isNewSupportInformation($name){
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT si
							FROM AppBundle:Support_Information si
							WHERE si.name = :name"
	                    );
	    	
	    $query->setParameter('name', $name);
	    $results = $query->getResult();
	
	
	    if($results){
	        return false;
	    }else{
	        return true;
	    }
	
	}
	
	public function getSupportInformationFromName($name){
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT si
							FROM AppBundle:Support_Information si
							WHERE si.name = :name"
	                    );
	
	    $query->setParameter('name', $name);
	    $results = $query->getResult();
	    $return = $results[0];
	    return $return;
	
	}	
	
	public function domainHandler($feature_interactor_A){
		
		$domain = null;
		
		if(self::assertNotNull($feature_interactor_A)){	 
			$domain = self::createDomainObjectFromData($feature_interactor_A);
		}

		return $domain;
	}
	
	
	public function organismHandler($taxid_interactor_A, $taxid_interactor_B, &$doctrine_manager){
		

		$organism_array = array();
		$organism_A_array = array();
		$organism_B_array = array();
		$organism_AB_array = array();
	
		if(self::assertNotNull($taxid_interactor_A) && self::assertNotNull($taxid_interactor_B)){
			
			$taxid_array = self::getTaxidIdsFromData($taxid_interactor_A, $taxid_interactor_B);
			
			$organism_A_taxid_array = $taxid_array[0];
			$organism_B_taxid_array = $taxid_array[1];
			$organism_AB_taxid_array = $taxid_array[2];
			
			
			
			$organism_A_array = self::createOrganismsFromTaxidIds($organism_A_taxid_array, $doctrine_manager);
			$organism_B_array = self::createOrganismsFromTaxidIds($organism_B_taxid_array, $doctrine_manager);
			$organism_AB_array = self::createOrganismsFromTaxidIds($organism_AB_taxid_array, $doctrine_manager);
		}
		
		
		
		$organism_array[] = $organism_A_array;
		$organism_array[] = $organism_B_array;
		$organism_array[] = $organism_AB_array;
		
		return $organism_array;
		
	}

	public function proteinHandler($interactor_id, &$doctrine_manager){

		if(self::assertNotNull($interactor_id)){

			$return_array = self::createProteinFromData($interactor_id, $doctrine_manager);
	
		}
		

		return $return_array;
	}
	
	public function aliasHandler($interactor_A_alias, $interactor_B_alias){
		
		$interactor_A_alias_array = self::createAliasIdentifiersFromData($interactor_A_alias);
			
		$interactor_B_alias_array = self::createAliasIdentifiersFromData($interactor_B_alias);
		
		$alias_array = array($interactor_A_alias_array, $interactor_B_alias_array);
	
		return $alias_array;
	
	}
	
	public function alt_interactorHandler($alt_interactor_A_id, $alt_interactor_B_id){
	

		$alt_interactor_A_array = self::createAltIdentifiersFromData($alt_interactor_A_id);
			
		$alt_interactor_B_array = self::createAltIdentifiersFromData($alt_interactor_B_id);
		
		$alt_interactor_array = array($alt_interactor_A_array, $alt_interactor_B_array);
		
		return $alt_interactor_array;
	
	}
	
	
	public function interactionHandler($feature_interactor_B, $confidence_value){
	
	
		$interaction = self::createInteractionFromData($feature_interactor_B, $confidence_value);
	
		return $interaction;
	
	}
	
	
	
	
	public function createInteractionFromData($feature_interactor_B, $confidence_value){
		
		$interaction = new Interaction;
		
		if(self::assertNotNull($feature_interactor_B)){
		
			$binding_array = explode(':', $feature_interactor_B);
			
			$coordinate_array = explode('-', $binding_array[1]);
			$binding_start = $coordinate_array[0];
			$binding_end = $coordinate_array[1];
			$interaction->setBindingStart($binding_start);
			$interaction->setBindingEnd($binding_end);
		
		}
		
		if(self::assertNotNull($confidence_value)){
		
			$score_array = explode(':', $confidence_value);
			$score = $score_array[1];
			$interaction->setScore($score);
		}
		
		return $interaction;
		
	}
	
	public function getInteractionByIds($interactor_A_id, $interactor_B_id){
	    
	    $interactor_A_id_array = explode(":", $interactor_A_id);
	    $identifier_A_naming_convention_interactor_id = $interactor_A_id_array[0];
	    $identifier_A_identifier_interactor_id = $interactor_A_id_array[1];
	     
	    $interactor_B_id_array = explode(":", $interactor_B_id);
	    $identifier_B_naming_convention_interactor_id = $interactor_B_id_array[0];
	    $identifier_B_identifier_interactor_id = $interactor_B_id_array[1];
	     
	    $protein_A_id = null;
	    $protein_B_id = null;
	    
	    $em = $this->getDoctrine()->getManager();
	     
	    $query = $em->createQuery(
	                    "SELECT i
							FROM AppBundle:Identifier i
				            WHERE i.identifier = :identifier"
	
	                    );
	     
	    $query->setParameter('identifier', $identifier_A_identifier_interactor_id);
	     
	    $identifier_A_results = $query->getResult();
	     
	    if($identifier_A_results){
	         
	        $identifier_A = $identifier_A_results[0];
	
	        $protein_A_id = $identifier_A->getProtein();
	         
	    }
	
	     
	     
	     
	    $query = $em->createQuery(
	                    "SELECT i
							FROM AppBundle:Identifier i
				            WHERE i.identifier = :identifier"
	
	                    );
	     
	    $query->setParameter('identifier', $identifier_B_identifier_interactor_id);
	     
	    $identifier_B_results = $query->getResult();
	     
	    if($identifier_B_results){
	
	        $identifier_B = $identifier_B_results[0];
	         
	        $protein_B_id = $identifier_B->getProtein();
	
	    }
	
	
	     

	         
	        $query = $em->createQuery(
	                        "SELECT i
    							FROM AppBundle:Interaction i
                				WHERE i.interactor_A = :interactor_A
                				AND i.interactor_B = :interactor_B"
	                        );
	         
	        $query->setParameter('interactor_A', $protein_A_id);
	        $query->setParameter('interactor_B', $protein_B_id);
	        $results = $query->getResult();
	        $result = $results[0];
	        return $result;
	        
	}
	
	public function createAltIdentifiersFromData($alt_interactor_id){
		
		$alt_identifier_array = array();
		
		if(self::assertNotNull($alt_interactor_id)){
					
			//intact:EBI-742397|uniprotkb:Q5JQQ8|uniprotkb:Q96LZ4|uniprotkb:Q96M47|uniprotkb:Q9BXU6|uniprotkb:B8K8V6
			$alt_interactor_id_array =  explode("|", $alt_interactor_id);
		
			//intact:EBI-742397, uniprotkb:Q5JQQ8, uniprotkb:Q96LZ4, uniprotkb:Q96M47, uniprotkb:Q9BXU6, uniprotkb:B8K8V6
			foreach($alt_interactor_id_array as $_alt_interactor_id){
					
				//intact:EBI-742397
				$alt_interactor_array = explode(":", $_alt_interactor_id);
				//intact
				$alt_identifier_naming_convention = $alt_interactor_array[0];
				//EBI-742397
				$alt_identifier_identifier = $alt_interactor_array[1];
				
				if(self::isNewIdentifier($alt_identifier_identifier, $alt_identifier_naming_convention) == true){
					//add identifer
					$alt_identifier = new Identifier();
					
					$alt_identifier->setIdentifier($alt_identifier_identifier);
					$alt_identifier->setNamingConvention($alt_identifier_naming_convention);
					
					$alt_identifier_array[] = $alt_identifier;
				}
				
			}
	
		}
		
		return $alt_identifier_array;
	}

	
	public function createAliasIdentifiersFromData($interactor_alias){
		
		$alias_array = array();
		
		if(self::assertNotNull($interactor_alias)){
			
			$interactor_alias_array =  explode("|", $interactor_alias);
		
			foreach($interactor_alias_array as  $_interactor_alias){
					
				$_interactor_alias_array = explode(":", $_interactor_alias);
					
				$interactor_alias_naming_convention = $_interactor_alias_array[0];
					
				$interactor_alias_identifier = $_interactor_alias_array[1];
				
				$interactor_alias_identifier = preg_replace('/\(.*$/',"", $interactor_alias_identifier);
				
				if(self::isNewIdentifier($interactor_alias_identifier, $interactor_alias_naming_convention) == true){	
					//add identifer
					$interactor_alias_identifier_object = new Identifier();
					$interactor_alias_identifier_object->setIdentifier($interactor_alias_identifier);
					$interactor_alias_identifier_object->setNamingConvention($interactor_alias_naming_convention);
					
					$alias_array[] = $interactor_alias_identifier_object;
				}
			}
		
		}
		
		return $alias_array;
		
	}
 	
	public function createProteinFromData($interactor_id, &$doctrine_manager){
		
		$protein = null;
		$identifier_array = array();
		$links_array = null;
		$interactor_id_array = explode(":", $interactor_id);
		$identifier_naming_convention_interactor_id = $interactor_id_array[0];
		$identifier_identifier_interactor_id = $interactor_id_array[1];
		
		$is_new_protein = self::isNewProtein($identifier_identifier_interactor_id, $identifier_naming_convention_interactor_id);
		
		if($is_new_protein == false){

			$protein = self::getProteinFromIdentifier($identifier_identifier_interactor_id, $identifier_naming_convention_interactor_id);
			
		}elseif($is_new_protein == true){
			
			$protein = new Protein;

			$protein_remote_data_array = self::getProteinRemoteData($protein, $identifier_naming_convention_interactor_id, $identifier_identifier_interactor_id);
			$links_array = $protein_remote_data_array[0];
			$remote_identifier = $protein_remote_data_array[1];
			
			
			$protein->setName($identifier_identifier_interactor_id);

			$doctrine_manager->persist($protein);
		      
			if($remote_identifier){
    			$remote_identifier->setProtein($protein);
    			$identifier_array[] = $remote_identifier;
			}

			
			$uniprot_identifier = new Identifier();
			$uniprot_identifier->setProtein($protein);
			

			$uniprot_identifier->setIdentifier($identifier_identifier_interactor_id);
			$uniprot_identifier->setNamingConvention($identifier_naming_convention_interactor_id);
			$identifier_array[] = $uniprot_identifier;
		}
		
		
		
		$return_array = array($protein, $identifier_array, $links_array);
		
		
		
		return $return_array;
	}


	
	public function getProteinRemoteData(&$protein, &$naming_convention, &$identifier){

		$links_array = array();
		$remote_identifier = null;
		if($naming_convention == 'uniprotkb'){
		    

		 
			//get the uniprot accession
			$uniprot_accession = $identifier;
			 
			$external_link = new External_Link;
			$external_link->setDatabaseName("UniProt");
			$external_link->setLinkId($uniprot_accession);
			$external_link->setLink("http://www.uniprot.org/uniprot/" . $uniprot_accession);
			$external_link->setProtein($protein);
			$links_array[] = $external_link;
			
			
			//get the uniprot xml url
			$url = "http://www.uniprot.org/uniprot/$uniprot_accession.xml";
			 
			//get the uniprot xml
			
			try{
    			$str= @file_get_contents($url);
    			
    			if($str != FALSE){
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
        					$protein->setSequence($sequence_text);
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
        					$protein->setGeneName($gene_name_text);
        
        					
        					if(self::isNewIdentifier($gene_name_text, 'uniprotkb') == true){
        					    //add identifer
        					    $remote_identifier = new Identifier();
        					    	
        					    $remote_identifier->setIdentifier($gene_name_text);
        					    $remote_identifier->setNamingConvention('uniprotkb');
        					    
        					}
        					
        		
        				}
        			}
        			catch(Exception $e) {
        			}
        			
        			
        			try{
        			    //get the gene name node from xml
        			    $function = $crawler->filter('uniprot > entry > comment[type="function"] > text');
        			
        			    //if the node is present
        			    if($function->count()){
        			
        			        //get the gene name text from node
        			        $function_text = $function->text();
        			
        			        //set the gene name text for the protein
        			        $protein->setDescription($function_text);
        			
        			
        			    }
        			}
        			catch(Exception $e) {
        			}

        			
        			
        			try{
        				//get the gene name node from xml
        				$link = $crawler->filter('uniprot > entry > dbReference[type="Ensembl"]');
        					
        				//if the node is present
        				if($link->count()){
        						
        					//get the gene name text from node
        					$link_text = $link->each(function ($node, $i) {
        						return $node->attr('id');
        					});
        			
        						//set the gene name text for the protein
        						foreach($link_text as $l){
        			
        							$external_link = new External_Link;
        							$external_link->setDatabaseName("Ensembl");
        							$external_link->setLinkId($l);
        							$external_link->setLink("http://www.ensembl.org/id/" . $l);
        							$external_link->setProtein($protein);
        							$links_array[] = $external_link;
        			
        						}
        			
        				}
        			}
        			catch(Exception $e) {
        			}
        			
        			try{
        				//get the gene name node from xml
        				$link = $crawler->filter('uniprot > entry > dbReference[type="RefSeq"]');
        					
        				//if the node is present
        				if($link->count()){
        			
        					//get the gene name text from node
        					$link_text = $link->each(function ($node, $i) {
        						return $node->attr('id');
        					});
        							
        						//set the gene name text for the protein
        						foreach($link_text as $l){
        								
        							$external_link = new External_Link;
        							$external_link->setDatabaseName("RefSeq");
        							$external_link->setLinkId($l);
        							$external_link->setLink("http://www.ncbi.nlm.nih.gov/protein/" . $l);
        							$external_link->setProtein($protein);
        							$links_array[] = $external_link;
        								
        						}
        							
        				}
        			}
        			catch(Exception $e) {
        			}
			
    			
			    }
			}
			catch(Exception $e) {
			}
			
		}
		
		$return_array = array($links_array, $remote_identifier);
		return $return_array;
	
	}
	
	public function createDomainObjectFromData($feature_interactor_A){
	
		$domain_array =  explode(";", $feature_interactor_A);
		
		$domain_type = null;
		$domain_name = null;
		$domain_description = null;
		$domain_sequence = null;
		$domain_start_position = null;
		$domain_end_position = null;
		
		foreach($domain_array as $domain){
			
			$_domain_array = explode(":", $domain);
			$field = $_domain_array[0];
			$value = $_domain_array[1];
	
			switch($field){
				case 'type':
					$domain_type = $value;
					break;
				case 'Name':
					$domain_name = $value;
					break;
				case 'Desc':
					$domain_description = $value;
					break;
				case 'Sequence':
					$domain_sequence = $value;
					break;
				case 'coordinates':
					$coordinates = $value;
					$coordinat_array = explode("-", $coordinates);
					$domain_start_position = $coordinat_array[0];
					$domain_end_position = $coordinat_array[1];
					break;
			}
		}
		
		if(self::isNewDomain($domain_type, $domain_name) == true){
		
		    $domain = new Domain;
		    $domain->setType($domain_type);
		    $domain->setName($domain_name);
		    $domain->setDescription($domain_description);
		    $domain->setSequence($domain_sequence);
		    $domain->setStartPosition($domain_start_position);
		    $domain->setEndPosition($domain_end_position);
		
		}else{
		    $domain = self::getDomainFromTypeName($domain_type, $domain_name);
		    
		}
		
		return $domain;
	}
	
	public function getTaxidIdsFromData($taxid_interactor_A, $taxid_interactor_B){

		$taxid_array_A = self::getTaxidIds($taxid_interactor_A);
		$taxid_array_B = self::getTaxidIds($taxid_interactor_B);

		if($taxid_array_A && $taxid_array_B){
			if($taxid_array_A){
				$taxid_array_A = array_unique($taxid_array_A);
			}
			if($taxid_array_B){
				$taxid_array_B = array_unique($taxid_array_B);
			}
			
			$taxid_array_AB = array_intersect($taxid_array_A, $taxid_array_B);
			$taxid_array_A = array_diff($taxid_array_A, $taxid_array_AB);		
			$taxid_array_B = array_diff($taxid_array_B, $taxid_array_AB);
			
			$taxid_array = array(array(), array(), array());
			$taxid_array[0] = $taxid_array_A;
			$taxid_array[1] = $taxid_array_B;
			$taxid_array[2] = $taxid_array_AB;
			

			
			return $taxid_array;
		}
	}
	
	public function createOrganismsFromTaxidIds($taxid_id_array, &$doctrine_manager){
		
		$organism_array = array();
		$organism = null;

		foreach($taxid_id_array as $taxid_id){

			$is_new_taxid_id = self::isNewOrganism($taxid_id);

			if($is_new_taxid_id == false){

				$organism = self::getOrganismFromTaxidId($taxid_id);
				$organism_array[] = $organism;

			}elseif($is_new_taxid_id == true){

				$organism = new Organism;
				$organism = self::setOrganismAttributes($taxid_id, $organism);
				$organism_array[] = $organism;
	
			}

		}
	
		return $organism_array;
	}

	public function getTaxidIds($taxid_interactor){
	
		$taxid_id_array = array();
	
		$taxid_interactor_array = explode("|", $taxid_interactor);
			
		foreach($taxid_interactor_array as $_taxid_interactor){
	
			$matches = array();
			preg_match( '/(\d+)/', $_taxid_interactor, $matches);
			$taxid_id_array = $matches;
		}
	
		$taxid_id_array = array_unique($taxid_id_array);
	
		return $taxid_id_array;
	}
	
	public function previouslyAddedOrganism($taxid_id, $previously_added_organisms){
	
		$organism_in_array = in_array($taxid_id, $previously_added_organisms);
		$return = null;
	
		switch($organism_in_array){
	
			case true:
				$return = true;

				break;
			case false:
				$return = false;

				break;
			default:
				$return = null;

				break;
					
		}
		
		return $return;
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
	
	public function getOrganismFromTaxidId($taxid_id){
	
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT o
				FROM AppBundle:Organism o
				WHERE o.taxid_id = :taxid_id"
				);
			
		$query->setParameter('taxid_id', $taxid_id);
	
		$results = $query->getResult();
	
		return $results[0];
	
	}

	public function setOrganismAttributes($taxid_id, &$organism){
	
		$organism_common_name = '';
		$organism_scientific_name = '';
			
		self::getOrganismRemoteData($taxid_id, $organism_common_name, $organism_scientific_name);
	
		$organism->setTaxidId($taxid_id);
		$organism->setCommonName($organism_common_name);
		$organism->setScientificName($organism_scientific_name);
		
		return $organism;
	
	}
	
	public function getOrganismRemoteData($taxid_id, &$organism_common_name, &$organism_scientific_name){
	
		$url = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=taxonomy&id=$taxid_id";
		$url_file_contents = file_get_contents($url);
	
		$crawler = new Crawler($url_file_contents);
	
		$return = true;
	
		try{
			$scientific_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="ScientificName"]');
			if($scientific_name->count()){
				$organism_scientific_name = $scientific_name->text();
			}
		}catch(Exception $e) {$return = false;}
	
		try{
			$common_name = $crawler->filter('eSummaryResult > DocSum > Item[Name="CommonName"]');
			if($common_name->count()){
				$organism_common_name = $common_name->text();
			}
		}catch(Exception $e) {$return = false;}
	
		return $return;
	}
	/*
	public function isNewDataset($publication_identifier){
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT d
							FROM AppBundle:Dataset d
							WHERE d.reference = :reference
                        "
	                    );
	    	
	    $query->setParameter('reference', $publication_identifier);

	    $results = $query->getResult();
	
	
	    if($results){
	        return false;
	    }else{
	        return true;
	    }
	
	}
	*/
	
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
	
	public function getProteinFromIdentifier($identifier, $naming_convention){
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
		$protein = $identifier_object->getProtein();
		

		
		return $protein;
	
	}
	
	public function isNewIdentifier($identifier, $naming_convention){
		
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

	public function isNewDomain($type, $name){
	
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT d
							FROM AppBundle:Domain d
							WHERE d.type = :type
							AND d.name = :name"
	                    );
	    	
	    $query->setParameter('type', $type);
	    $query->setParameter('name', $name);
	    $results = $query->getResult();
	
	
	    if($results){
	        return false;
	    }else{
	        return true;
	    }
	}
	
	public function isNewInteraction($interactor_A_id, $interactor_B_id){
	
	    $interactor_A_id_array = explode(":", $interactor_A_id);
	    $identifier_A_naming_convention_interactor_id = $interactor_A_id_array[0];
	    $identifier_A_identifier_interactor_id = $interactor_A_id_array[1];
	     
	    $interactor_B_id_array = explode(":", $interactor_B_id);
	    $identifier_B_naming_convention_interactor_id = $interactor_B_id_array[0];
	    $identifier_B_identifier_interactor_id = $interactor_B_id_array[1];
	     
	    $protein_A_id = null;
	    $protein_B_id = null;
	    
	    $em = $this->getDoctrine()->getManager();
	     
	    $query = $em->createQuery(
	                    "SELECT i
							FROM AppBundle:Identifier i
				            WHERE i.identifier = :identifier"
	
	                    );
	     
	    $query->setParameter('identifier', $identifier_A_identifier_interactor_id);
	     
	    $identifier_A_results = $query->getResult();
	     
	    if($identifier_A_results){
	         
	        $identifier_A = $identifier_A_results[0];
	
	        $protein_A_id = $identifier_A->getProtein();
	         
	    }
	
	     
	     
	     
	    $query = $em->createQuery(
	                    "SELECT i
							FROM AppBundle:Identifier i
				            WHERE i.identifier = :identifier"
	
	                    );
	     
	    $query->setParameter('identifier', $identifier_B_identifier_interactor_id);
	     
	    $identifier_B_results = $query->getResult();
	     
	    if($identifier_B_results){
	
	        $identifier_B = $identifier_B_results[0];
	         
	        $protein_B_id = $identifier_B->getProtein();
	
	    }
	
	
	     
	    if ($protein_A_id && $protein_B_id){
	         
	        $query = $em->createQuery(
	                        "SELECT i
    							FROM AppBundle:Interaction i
                				WHERE i.interactor_A = :interactor_A
                				AND i.interactor_B = :interactor_B"
	                        );
	         
	        $query->setParameter('interactor_A', $protein_A_id);
	        $query->setParameter('interactor_B', $protein_B_id);
	        $results = $query->getResult();
	
	        if($results){
	            return false;
	        }else{
	            return true;
	        }
	    }
	     
	    return true;
	
	}
	

	
	public function getDomainFromTypeName($type, $name){
	    
	    $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	                    "SELECT d
							FROM AppBundle:Domain d
							WHERE d.name = :name
							AND d.type = :type"
	                    );
	    	
	    $query->setParameter('type', $type);
	    $query->setParameter('name', $name);
	    $domain_array = $query->getResult();
	    
	    $domain = $domain_array[0];
	    
	    
	    return $domain;
	    
	}


	
	
	
	
	
	
	
	
	
	
	
	
	
	

    public function deleteData($dataset_id){

            $dataset = $this->getDoctrine()
            ->getRepository('AppBundle:Dataset')
            ->find($dataset_id);
        
            $interaction_array = self::getInteractionsFromDataset($dataset_id);
            
            foreach($interaction_array as $interaction){
            
                $interactions_exist_in_multiple_datasets = self::checkIfInteractionsExistInMultipleDatasets($interaction);

            
                if($interactions_exist_in_multiple_datasets == true){
            
                    self::removeInteractionFromDataset($interaction, $dataset);
            
                }elseif($interactions_exist_in_multiple_datasets == false){
            
                    
                    $interactor_A = $interaction->getInteractorA();
                    $interactor_B = $interaction->getInteractorB();
                    
                    
                    $interactor_A_protein = $this->getDoctrine()
                    ->getRepository('AppBundle:Protein')
                    ->find($interactor_A);

                    $interactor_B_protein = $this->getDoctrine()
                    ->getRepository('AppBundle:Protein')
                    ->find($interactor_B);
                    
                    
                    $interactor_A_exist_in_multiple_interactions = self::checkIfProteinExistInMultipleInteractons($interactor_A_protein);
                    
                    $interactor_B_exist_in_multiple_interactions = self::checkIfProteinExistInMultipleInteractons($interactor_B_protein);
                    
                    
                    self::removeInteraction($interaction);

                    if ($interactor_A_exist_in_multiple_interactions == false){
                        
                        self::removeIdentifiers($interactor_A_protein);
                        self::removeExternalLinks($interactor_A_protein);
                        self::removeProtein($interactor_A_protein);
                    }
                    
                    if ($interactor_B_exist_in_multiple_interactions == false){
                    
                        self::removeIdentifiers($interactor_B_protein);
                        self::removeExternalLinks($interactor_B_protein);
                        self::removeProtein($interactor_B_protein);

                    }
                }
            }
            $em = $this->getDoctrine()->getManager();
            $dataset = $em->merge($dataset);
            $em->remove($dataset);
            
            $em->flush();
            $em->clear();
            gc_collect_cycles();
    }
    
    public function getInteractionsFromDataset($dataset_id){
        
        $em = $this->getDoctrine()->getManager();
         
        $query = $em->createQuery(
                        "SELECT i
				FROM AppBundle:Interaction i
	            JOIN i.datasets ds
				WHERE ds.id = :ds_id"
                        );
        $query->setParameter('ds_id', $dataset_id);
        
        $interaction_array = $query->getResult();
        
        return $interaction_array;
    }
    
    
    public function checkIfInteractionsExistInMultipleDatasets($interaction){
    
        $i_id = $interaction->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT ds
                        				FROM AppBundle:Dataset ds
                        	            JOIN ds.interactions i
                        				WHERE i.id = :i_id"
                        );
        $query->setParameter('i_id', $i_id);
        
        $dataset_array = $query->getResult();
    
        if(count($dataset_array) > 1){
            
            return true;
        }else{
            return false;
            
        }

    }
    
    public function removeInteractionFromDataset($interaction, $dataset){
        
        
        $em = $this->getDoctrine()->getManager();
        $interaction->removeDataset($dataset);
        $dataset->removeInteraction($interaction);
        $em->merge($dataset);
        $em->merge($interaction);
        $em->flush();
        $em->clear();
        
    }
    
    public function checkIfProteinExistInMultipleInteractons($interactor){
    
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT i
        				FROM AppBundle:Interaction i
        				WHERE
                        (i.interactor_A = :interactor
                        OR
                        i.interactor_B = :interactor)"
                        );
        $query->setParameter('interactor', $interactor);
        
        $interacton_array = $query->getResult();
        
        if(count($interacton_array) > 1){
        
            return true;
        }else{
            return false;
        
        }
    
    }
    
    
    public function removeInteraction($interaction){
        
        $em = $this->getDoctrine()->getManager();
        $interaction = $em->merge($interaction);
        $em->remove($interaction);
        $em->flush();
        $em->clear();
    }
    
    public function removeIdentifiers($interactor_protein){
        
        $protein_id = $interactor_protein->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT i
        				FROM AppBundle:Identifier i
        				WHERE
                        i.protein = :protein
                        "
                        );
        $query->setParameter('protein', $interactor_protein);
        
        $identifier_array = $query->getResult();
        
        foreach($identifier_array as $identifier){
            $em = $this->getDoctrine()->getManager();
            
            $identifier = $em->merge($identifier);
            $em->remove($identifier);
            $em->flush();
            $em->clear();
        }
        
    }
    
    public function removeExternalLinks($interactor_protein){
    
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT l
        				FROM AppBundle:External_Link l
        				WHERE
                        l.protein = :protein
                        "
                        );
        $query->setParameter('protein', $interactor_protein);
    
        $external_link_array = $query->getResult();
    
        foreach($external_link_array as $external_link){
            $em = $this->getDoctrine()->getManager();
    
            $external_link = $em->merge($external_link);
            $em->remove($external_link);
            $em->flush();
            $em->clear();
        }
    
    }
    
    
    
    public function removeProtein($interactor_protein){
        $em = $this->getDoctrine()->getManager();
        $interactor_protein = $em->merge($interactor_protein);
        $em->remove($interactor_protein);
        $em->flush();
        $em->clear();
    }
    

    
}

?>
