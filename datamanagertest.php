<?php
gc_enable();
$dataset = new Dataset();
$form = $this->createForm('AppBundle\Form\DatasetType', $dataset);
$form->handleRequest($request);






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

$delete_form->handleRequest($request);

///$handle = fopen("C:\\Users\\Miles\\Desktop\\test\\test.txt", "w");


//stats for data upload
$interactions_added = 0;
$new_proteins_added = 0;
$new_identifier_added = 0;
$new_organisms_added = 0;
$new_datasets_added = 0;
$new_domain_added = 0;


if ($delete_form->isSubmitted() && $delete_form->isValid()) {


    $dataset_id = $delete_form->get('dataset_to_delete')->getData();

    self::deleteData($dataset_id);

    return $this->redirectToRoute('data_manager');
}


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
     
    $form_data = $form->getData();
     
    $file_type = $form_data->getFileType();


     
    $file_row = 0;

    while ($file_data = fgetcsv($handle, 0, "\t"))
    {
        //skip header
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
                                 
                                //Domain
                                $domain = self::domainHandler($feature_interactor_A);

                                //Organism
                                $organism_array = self::organismHandler($taxid_interactor_A, $taxid_interactor_B, $doctrine_manager);
                                $organism_A_array = $organism_array[0];
                                $organism_B_array = $organism_array[1];
                                $organism_AB_array = $organism_array[2];
                                 
                                //Protein
                                $protein_A_array = self::proteinHandler($interactor_A_id, $doctrine_manager);
                                $protein_A = $protein_A_array[0];
                                $identifier_A_protein = $protein_A_array[1];
                                $links_array_A = $protein_A_array[2];
                                 
                                 
                                if($identifier_A_protein){
                                    $identifier_A_protein->setProtein($protein_A);
                                }
                                 
                                $protein_B_array = self::proteinHandler($interactor_B_id, $doctrine_manager);
                                $protein_B = $protein_B_array[0];
                                $identifier_B_protein = $protein_B_array[1];
                                $links_array_B = $protein_B_array[2];
                                if($identifier_B_protein){
                                    $identifier_B_protein->setProtein($protein_B);
                                }
                                 
                                //Interaction
                                $interaction = self::interactionHandler($feature_interactor_B, $confidence_value);
                                 
                                //Alt Interactor
                                $alt_interactor_array = self::alt_interactorHandler($alt_interactor_A_id, $alt_interactor_B_id);

                                //Aliases
                                $alias_interactor_array = self::aliasHandler($interactor_A_alias, $interactor_B_alias);

                                //Support Information
                                $support_informations_array = self::support_informationHandler($interaction_parameter);
                                $support_information_array = '';
                                $interaction_support_information_array = '';
                                if($support_informations_array){
                                    $support_information_array = $support_informations_array[0];
                                    $interaction_support_information_array = $support_informations_array[1];
                                     
                                }

                                //Dataset
                                $dataset = self::datasetHandler($publication_identifier, $publication_first_author);

                                 
                                foreach ($organism_AB_array as $organism_AB){
                                     
                                    if(self::assertRelationshipExistsProteinOrganism($protein_A, $organism_AB) == false){
                                        $organism_AB->addProtein($protein_A);
                                        $protein_A->addOrganism($organism_AB);
                                    }


                                    if($domain){
                                        if(self::assertRelationshipExistsDomainOrganism($domain, $organism_AB) == false){
                                            $domain->addOrganism($organism_AB);
                                            $organism_AB->addDomain($domain);
                                        }
                                    }
                                    if(self::assertRelationshipExistsProteinOrganism($protein_B, $organism_AB) == false){
                                        $organism_AB->addProtein($protein_B);
                                        $protein_B->addOrganism($organism_AB);

                                    }
                                    $doctrine_manager->persist($organism_AB);
                                }
                                 
                                foreach ($organism_A_array as $organism_A){
                                    if(self::assertRelationshipExistsProteinOrganism($protein_A, $organism_A) == false){
                                        $organism_A->addProtein($protein_A);
                                        $protein_A->addOrganism($organism_A);
                                    }
                                    if($domain){
                                        if(self::assertRelationshipExistsDomainOrganism($domain, $organism_A) == false){
                                            $domain->addOrganism($organism_A);
                                            $organism_A->addDomain($domain);
                                        }
                                    }
                                    $doctrine_manager->persist($organism_A);
                                }
                                 
                                foreach ($organism_B_array as $organism_B){
                                    if(self::assertRelationshipExistsProteinOrganism($protein_B, $organism_B) == false){
                                        $organism_B->addProtein($protein_B);
                                        $protein_B->addOrganism($organism_B);

                                    }
                                    $doctrine_manager->persist($organism_B);
                                }

                                if($support_information_array){
                                    foreach ($support_information_array as $support_information){
                                        $doctrine_manager->persist($support_information);

                                         
                                    }
                                }

                                if($interaction_support_information_array){
                                    foreach ($interaction_support_information_array as $interaction_support_information){

                                        $interaction->addInteractionSupportInformation($interaction_support_information);
                                        $interaction_support_information->setInteraction($interaction);
                                        $doctrine_manager->persist($interaction_support_information);
                                    }
                                }

                                if($identifier_A_protein){
                                    $doctrine_manager->persist($identifier_A_protein);
                                }
                                if($identifier_B_protein){
                                    $doctrine_manager->persist($identifier_B_protein);
                                }

                                $alt_interactor_A_array = $alt_interactor_array[0];
                                 
                                foreach ($alt_interactor_A_array as $alt_interactor_A){

                                    $alt_interactor_A->setProtein($protein_A);
                                    $doctrine_manager->persist($alt_interactor_A);
                                }
                                 
                                $alt_interactor_B_array = $alt_interactor_array[1];
                                 
                                foreach ($alt_interactor_B_array as $alt_interactor_B){
                                     
                                    $alt_interactor_B->setProtein($protein_B);
                                    $doctrine_manager->persist($alt_interactor_B);
                                }

                                $alias_interactor_A_array = $alias_interactor_array[0];
                                 
                                foreach ($alias_interactor_A_array as $alias_interactor_A){
                                     
                                    $alias_interactor_A->setProtein($protein_A);
                                    $doctrine_manager->persist($alias_interactor_A);
                                }
                                 
                                $alias_interactor_B_array = $alias_interactor_array[1];
                                 
                                foreach ($alias_interactor_B_array as $alias_interactor_B){
                                     
                                    $alias_interactor_B->setProtein($protein_B);
                                    $doctrine_manager->persist($alias_interactor_B);
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
                                 
                                 
                                if($domain != null){
                                    $interaction->setDomain($domain);
                                    $domain->setProtein($protein_A);
                                    $doctrine_manager->persist($domain);

                                }

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
        'form' => $form->createView(),
        'dataset_array' => $dataset_array,
        'footer' => $footer,
        'main_color_scheme' => $main_color_scheme,
        'header_color_scheme' => $header_color_scheme,
        'logo_color_scheme' => $logo_color_scheme,
        'button_color_scheme' => $button_color_scheme,
        'short_title' => $short_title,
        'title' => $title
));