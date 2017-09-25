<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Dataset;
use AppBundle\Entity\Interaction;
use AppBundle\Entity\Interaction_Category;
use AppBundle\Entity\Tissue_Expression;
use AppBundle\Entity\External_Link;
use AppBundle\Entity\Experiment;
use AppBundle\Entity\Identifier;
use AppBundle\Entity\Subcellular_Location_Expression;
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Utils\Functions;
use AppBundle\Entity\Domain;

/**
 * Home controller.
 *

 */
class HomeController extends Controller
{
	
	/**
	 * Home
	 * @Route("/", name="home")
	 * @Route("/home", name="home2")
	 * @Route("/admin/home/", name="admin_home")
	 * @Method({"GET", "POST"})
	 */
	public function homeAction(Request $request)
	{
		
		
		$em = $this->getDoctrine()->getManager();
		$em->getConfiguration()->setSQLLogger(null);
		
		$query = $em->createQuery(
				'SELECT i
					    FROM AppBundle:Interaction i
					    WHERE i.id > :ida
						AND i.id < :idb'
				);
		$query->setParameter('ida', 2000);
		$query->setParameter('idb', 4001);
		$interaction_array = $query->getResult();
		
		
		foreach($interaction_array as $interaction){
			
			
			$interactor_A = $interaction->getInteractorA();
			
			
			$domain = new Domain();
			
			$domain->setType('SH2');
			$domain->setName('PLCG1-1');
			$domain->setDescription('NA');
			$domain->setSequence('CAVKALFDYKAQREDELTFIKSAIIQNVEKQEGGWWRGDYGGKKQLWFPSNYVEEMV');
			$domain->setStartPosition('182');
			$domain->setEndPosition('455');
			
			$domain->setInteraction($interaction);
			$domain->setProtein($interactor_A);
			$em->persist($domain);
			
			
		}
		$em->flush();
		/*
		foreach($interaction_array as $interaction){
			
			
			$interactor_A = $interaction->getInteractorA();
			
			
			$domain = new Domain();
			
			$domain->setType('SH3');
			$domain->setName('ABL2-1');
			$domain->setDescription('NA');
			$domain->setSequence('NLFVALYDFVASGDNTLSITKGEKLRVLGYNQNGEWSEVRSKNGQGWVPSNYITPVN');
			$domain->setStartPosition('182');
			$domain->setEndPosition('455');
			
			$domain->setInteraction($interaction);
			$domain->setProtein($interactor_A);
			$em->persist($domain);
			
			
		}
		
		$em->flush();
		
		

		foreach($protein_array as $protein){
			
			$domain = new Domain();
			
			$domain->setType('SH2');
			$domain->setName('PLCG1-1');
			$domain->setDescription('NA');
			$domain->setSequence('CAVKALFDYKAQREDELTFIKSAIIQNVEKQEGGWWRGDYGGKKQLWFPSNYVEEMV');
			$domain->setStartPosition('182');
			$domain->setEndPosition('455');
			
			$domain->setProtein($protein);
			
			$em->persist($domain);
			
			
		}
		
		$em->flush();
		*/
			/*
		$array_1 = array();
		$array = array();
		
		$handle = fopen('D:\\research_project\\comparisons\\initial_vs_6_weeks_non_responder\\sort2.txt', 'r');
		while ($file_data = fgetcsv($handle, 0, "\t"))
		{
			$gene = $file_data[0];
			$array_1[] = $gene;

		}
		
		$handle2 = fopen('D:\\research_project\\comparisons\\initial_vs_6_weeks_non_responder\\sort.txt', 'r');
		while ($file_data2 = fgetcsv($handle2, 0, "\t"))
		{
			
			list ($gene_name, $fc) = $file_data2;
			
			if(in_array($gene_name, $array_1)){
				
				$array[$gene_name]= $fc;
			}

			
		}
		
		$handle3 = fopen('D:\\research_project\\comparisons\\initial_vs_6_weeks_non_responder\\sorted.txt', 'w');

		foreach($array as $key2 => $value2){
			fwrite($handle3, "$key2\t$value2\n");
			
		}
		
	
		$out_array = array();
		
		foreach($array as $key => $value_array){
			
			
			$out_value = 0;
			
			foreach($value_array as $value){
				if($value > 0){
					if ( $value > $out_value){
						
						$out_value = $value;
					}
				}elseif($value < 0){
					if ( $value < $out_value){
						
						$out_value = $value;
					}
					
				}
				
			}
			
			
			$out_array[$key] = $out_value;
			
			
		}
		
		$handle2 = fopen('D:\\research_project\\comparisons\\initial_vs_6_weeks_non_responder\\sorted.txt', 'w');
		//fwrite($handle2, json_encode($out_array));
		
		foreach($out_array as $key2 => $value2){
			fwrite($handle2, "$key2\t$value2\n");
		
		}
		
		*/
		/*
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		$query1 = "SELECT *, COUNT(*) FROM `interaction` GROUP BY `interactor_A`, `interactor_B` HAVING COUNT(*) > 1";
		$result1 = $connection->query($query1);
		while($row1 = $result1->fetch_assoc()) {
			$id1 = $row1['interactor_A'];
			$query2 = "SELECT * FROM `interaction` WHERE `interactor_A` = '$id1' AND `interactor_B` = '$id1'";
			$result2 = $connection->query($query2);
			$set_interaction_id = '';
			$count = 0;
			while($row2 = $result2->fetch_assoc()) {
				$count++;
				$interaction_id = $row2['id'];
				if($count == 1){
					$set_interaction_id = $interaction_id;
				}
				
/*
					$query3 = "UPDATE `interaction_dataset` SET `interaction_id`= '$set_interaction_id' WHERE `interaction_id` = '$interaction_id'";
					$result3 = $connection->query($query3);


					$query4 = "UPDATE `interaction_interraction_category` SET `interaction_id`= '$set_interaction_id' WHERE `interaction_id` = '$interaction_id'";
					$result4 = $connection->query($query4);

				

				$query6 = "UPDATE `experiment` SET `interaction_id`= '$set_interaction_id' WHERE `interaction_id` = '$interaction_id'";
				$result6 = $connection->query($query6);
				
				
				
				if($count > 1){
					$query5 = "DELETE FROM `interaction` WHERE `id` = '$interaction_id'";
					$result5 = $connection->query($query5);
				}
			}
			
		}
	*/	
	/*
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		$query1 = "SELECT * FROM `protein`";
		$result1 = $connection->query($query1);
		while($row1 = $result1->fetch_assoc()) {
			
			$protein_id = $row1['id'];
			$ensembl_id = $row1['ensembl_id'];
			
			$query2 = "SELECT * FROM `subcellular_location_expression` WHERE `ensembl_id` = '$ensembl_id'";
			$result2 = $connection->query($query2);
			
			while($row2 = $result2->fetch_assoc()) {
				$sub_cell_id = $row2['id'];
				$sub_cell_ensembl_id = $row2['ensembl_id'];
				
				$query3 = "UPDATE `subcellular_location_expression` SET `protein_id` = $protein_id WHERE `id` = $sub_cell_id";
				$result3 = $connection->query($query3);
			}
			
		}
		
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		//$query1 = "SELECT * FROM `protein` WHERE `gene_name` REGEXP '.*\\[.*'";
		
		$query1 = "SELECT * FROM `protein` WHERE `id` > '9203'";
		$result1 = $connection->query($query1);
		
		
		
		while($row1 = $result1->fetch_assoc()) {
			
			$protein_id = $row1['id'];
			//$ensembl_id = $row1['ensembl_id'];
			//$id = $row1['id'];
		
			$identifier = $row1['gene_name'];
			
			$gene_name = '';
			//$entrez_id = '';
			/*
			$url = "https://rest.ensembl.org/xrefs/id/$ensembl_id?content-type=application/json";
			
			try{
				$str= @file_get_contents($url);
				$json_array =  json_decode($str, true);
				foreach($json_array as $json){
					
					if(array_key_exists('dbname', $json)){
						
						if($json['dbname'] == "EntrezGene"){
							
							$entrez_id = $json['primary_id'];
							
						}
						if($json['dbname'] == "Clone_based_ensembl_gene"){
							
							$gene_name = $json['primary_id'];
							
						}
						
						if($json['dbname'] == "WikiGene"){
							
							$gene_name = $json['display_id'];
							
						}
						if($json['dbname'] == "HGNC"){
							
							$gene_name = $json['display_id'];
							
						}
						if($json['dbname'] == "Uniprot_gn"){
							
							$gene_name = $json['display_id'];
							
						}
						
						
						
						
					}
				}

				
			}catch(Exception $e) {
			}
			
			
			if($gene_name == ''){
				$gene_name = $identifier;
			}

			$query2 = "UPDATE `protein` SET `entrez_id` = '$entrez_id',`gene_name`= '$gene_name' WHERE `id` = '$id'";
			$connection->query($query2);
			
			
			
			//$query3 = "INSERT INTO `identifier`(`identifier`, `naming_convention`) VALUES ('$gene_name', 'gene_name')";
			//$connection->query($query3);

			$query3 = "SELECT * FROM `identifier` WHERE `identifier` = '$identifier'";
			$result3 = $connection->query($query3);
			
			while($row3 = $result3->fetch_assoc()) {

				$identifier_id = $row3['id'];
				//$query4 = "UPDATE `identifier` SET `identifier`= '$gene_name' WHERE `id` = '$id'";
				//$connection->query($query4);
				
				$query4 = "INSERT INTO `protein_identifier`(`identifier_id`, `protein_id`) VALUES ('$identifier_id', '$protein_id')";
				$connection->query($query4);

			}

		}
		*/
		/*
		$query = "SELECT * FROM `protein` WHERE `gene_name` REGEXP 'ENSG'";
		$result = $connection->query($query);

		while($row = $result->fetch_assoc()) {
			$ensembl_id = $row['ensembl_id'];
			$url = "https://rest.ensembl.org/xrefs/id/$ensembl_id?content-type=application/json";
			try{
				$str= @file_get_contents($url);
				$json =  json_decode($str, true);
				$gene_name = $json[1]['display_id'];
				
			}catch(Exception $e) {
			}
			$query2 = "INSERT INTO `protein_identifiers`(`protein_id`, `identifier_id`) VALUES ('$protein_id','$identifier_id')";
			$result2 = $connection->query($query2);
			
		}

		
		
		
		
		
		
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Identifier');
		$identifiers = $repository->findAll();
		
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		
		foreach($identifiers as $identifier){
			$identifier_id = $identifier->getId();
			$identifier_naming = $identifier->getNamingConvention();
			$identifier_name = $identifier->getIdentifier();
			
			if($identifier_naming == 'uniprotkb'){
				$query = "SELECT * FROM `protein` WHERE `uniprot_id` = '$identifier_name'";
				$result = $connection->query($query);
				if($result){
					while($row = $result->fetch_assoc()) {
						$protein_id = $row['id'];
						$query2 = "INSERT INTO `protein_identifiers`(`protein_id`, `identifier_id`) VALUES ('$protein_id','$identifier_id')";
						$result2 = $connection->query($query2);
					}
				}			
			}elseif($identifier_naming == 'gene_name'){
				$query = "SELECT * FROM `protein` WHERE `gene_name` = '$identifier_name'";
				$result = $connection->query($query);
				if($result){
					while($row = $result->fetch_assoc()) {
						$protein_id = $row['id'];
						$query2 = "INSERT INTO `protein_identifiers`(`protein_id`, `identifier_id`) VALUES ('$protein_id','$identifier_id')";
						$result2 = $connection->query($query2);
					}
				}
			}elseif($identifier_naming == 'ensembl'){
				$query = "SELECT * FROM `protein` WHERE `ensembl_id` = '$identifier_name'";
				$result = $connection->query($query);
				if($result){
					while($row = $result->fetch_assoc()) {
						$protein_id = $row['id'];
						$query2 = "INSERT INTO `protein_identifiers`(`protein_id`, `identifier_id`) VALUES ('$protein_id','$identifier_id')";
						$result2 = $connection->query($query2);
					}
				}				
			}elseif($identifier_naming == 'entrez'){
				$query = "SELECT * FROM `protein` WHERE `entrez_id` = '$identifier_name'";
				$result = $connection->query($query);
				if($result){
					while($row = $result->fetch_assoc()) {
						$protein_id = $row['id'];
						$query2 = "INSERT INTO `protein_identifiers`(`protein_id`, `identifier_id`) VALUES ('$protein_id','$identifier_id')";
						$result2 = $connection->query($query2);
					}
				}				
			}
		}

*/
		/*
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Protein');
		$proteins = $repository->findAll();
		$protein_array = array();
		
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		foreach($proteins as $protein){
			$entrez_id = $protein->getEntrezID();
			$protein_id = $protein->getId();
			$em = $this->getDoctrine()->getManager();
			
			$query = $em->createQuery(
					"SELECT el
			    FROM AppBundle:External_Link el
			    WHERE el.database_name = 'Entrez'
				AND el.link_id = :entrez_id"
					)->setParameter('entrez_id', $entrez_id);
					
			$link_array = $query->getResult();
			
			$link = '';
			
			if($link_array){
				
				$link_id = $link_array[0]->getId();
			}
			
			if($link_id){
				
				$query = "UPDATE `external_link` SET `protein_id`= '$protein_id' WHERE `id` = $link_id";
				$result = $connection->query($query);

			}
			
			
		}
		
		
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Tissue_Expression');
		$Tissue_Expression_array = $repository->findAll();

		
		$functions = $this->get('app.functions');
		$connection =  $functions->mysql_connect();
		foreach($Tissue_Expression_array as $Tissue_Expression){
			$uniprot_id = $Tissue_Expression->getUniprotId();
			$Tissue_Expression_id = $Tissue_Expression->getId();
			$em = $this->getDoctrine()->getManager();
			
			$query = $em->createQuery(
					"SELECT p
			    FROM AppBundle:Protein p
			    WHERE p.uniprot_id = :uniprot_id"
					)->setParameter('uniprot_id', $uniprot_id);
					
			$protein_array = $query->getResult();
			
			$protein_id = '';
			
			if($protein_array){
				
				$protein_id = $protein_array[0]->getId();
			}
			
			if($protein_id ){
				
				$query = "UPDATE `tissue_expression` SET `protein_id`= '$protein_id' WHERE `id` = '$Tissue_Expression_id'";
				$result = $connection->query($query);
				
			}
					
					
		}
		*/
	/*
		$count = 0;
		
		$handle1 = fopen('D:\\HuRI Data\\release_170701\\bioinfo_katja..tsv_psi_mi_collapsed', 'r');
		$handle = fopen('D:\\test\\test.txt', 'w');

		while ($file_data = fgetcsv($handle1, 0, "\t"))
		{
			$count++;
			if($count == 1 || $count > 1000){ continue; }
			

			list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $alt_interactor_B_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method, $publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database, $interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B, $experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A, $xref_interactor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism, $interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum, $negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B, $identification_method_participant_A, $identification_method_participant_B) = $file_data;
			
					
			$interactor_A_ensembl_id_array = explode('.', $interactor_A_id);	
			$interactor_A_ensembl_id = $interactor_A_ensembl_id_array[0];
			
			$interactor_B_ensembl_id_array = explode('.', $interactor_B_id);
			$interactor_B_ensembl_id = $interactor_B_ensembl_id_array[0];

			$functions = $this->get('app.functions');
			$connection =  $functions->mysql_connect();
			
			$query_A = "SELECT * FROM `protein` WHERE `ensembl_id` = '$interactor_A_ensembl_id'";
			$query_B = "SELECT * FROM `protein` WHERE `ensembl_id` = '$interactor_B_ensembl_id'";
			$result_A = $connection->query($query_A);
			$result_B = $connection->query($query_B);

			
			$interactor_A_id_array = array();
			
			if($result_A){
				while($row = $result_A->fetch_assoc()) {
					
					$interactor_A_id_array[] = $row['id'];
				}
			}
			
			if(empty($interactor_A_id_array[0])){
				fwrite($handle, $query_A . "\r\n");
			
			}
			
			$interactor_B_id_array = array();
			
			if($result_B){
				while($row = $result_B->fetch_assoc()) {
					
					$interactor_B_id_array[] = $row['id'];
				}
			}
			
			if(empty($interactor_B_id_array[0])){
				
				fwrite($handle, $query_B . "\r\n");
			}
			
			
			
			
			/*
			$interactor_A_id = $interactor_A_id_array[0];
			
			
			
			$functions = $this->get('app.functions');
			$connection =  $functions->mysql_connect();
			$query = "SELECT * FROM `protein` WHERE `ensembl_id` = '$interactor_B_ensembl_id'";
			$result = $connection->query($query);
			
			$interactor_B_id_array = array();
			
			if($result){
				while($row = $result->fetch_assoc()) {
					
					$interactor_B_id_array[] = $row['id'];
				}
				
			}
			
			if(!$interactor_B_id_array[0]){
				
				fwrite($handle, $interactor_B_ensembl_id);
			}
			
			$interactor_B_id = $interactor_B_id_array[0];

			
			$interaction_array = array();
			
			
			$query = "SELECT * FROM `interaction` WHERE `interactor_A` = $interactor_A_id AND WHERE `interactor_B` = $interactor_B_id";
			
			$result = $connection->query($query);
			
			if($result){
				while($row = $result->fetch_assoc()) {
					
					$interaction_array[] = $row['id'];
				}
				
			}
			
			*/
			
			/*
			foreach($interaction_array as $interaction_id){

				
				$doctrine_manager = $this->getDoctrine()->getManager();
				
				$repository = $doctrine_manager->getRepository('AppBundle:Interaction');

				$interaction = $repository->find($interaction_id);
				
				$experiment_array = explode(';', $interaction_annotation);
				
				foreach($experiment_array as $experiment){
					
					$experiment_value_array = explode(';', $experiment);
					$orf_id_A = $experiment_value_array[0];
					$orf_id_B = $experiment_value_array[1];
					$orientation = $experiment_value_array[2];
					$assay_id = $experiment_value_array[3];
					$num_screens = $experiment_value_array[4];
					
					$doctrine_manager = $this->getDoctrine()->getManager();
					$doctrine_manager->getConfiguration()->setSQLLogger(null);
					$experiment = new Experiment;
					$experiment->setOrfA($orf_id_A);
					$experiment->setOrfB($orf_id_B);
					$experiment->setOrientation($orientation);
					$experiment->setAssayId($assay_id);
					$experiment->setNumScreens($num_screens);
					$experiment->setInteraction($interaction);
					
					
					$doctrine_manager->persist($experiment);
					$doctrine_manager->flush();
				}
				
			}
			*/
			
			
		/*	
		}



		
		$em = $this->getDoctrine()->getManager();
		
		
		$query = $em->createQuery(
				"SELECT i
				FROM AppBundle:Interaction i
	            JOIN i.datasets d
				WHERE d.id = '8'"
				);


		
		$interaction_results_array = $query->getResult();
		
				
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				"SELECT ic
							FROM AppBundle:Interaction_Category ic
							WHERE ic.id = :ic_id"
				);
		
		$query->setParameter('ic_id', '3');
		$interaction_catagory_array = $query->getResult();
		
		$interaction_catagory = $interaction_catagory_array[0];
		
			$functions = $this->get('app.functions');
			
			$connection =  $functions->mysql_connect();
			
		$count = 0;
		foreach($interaction_results_array as $interaction){
			//if($count < 26131){ $count++; continue; }
			$interaction_id = $interaction->getId();
			$query = "INSERT INTO `tor_ibin`.`interaction_interaction_category` (`interaction_category_id`, `interaction_id`) VALUES ('3', '$interaction_id')";
			
			$connection->query($query);

		}
		
*/
		/*
		
		$repository = $this->getDoctrine()->getRepository('AppBundle:Protein');

		$protein_array = $repository->findAll();
		
		$count = 0;
		
		
		foreach($protein_array as $protein){
			
			//if($count < 7360){ $count++; continue; }
			$doctrine_manager = $this->getDoctrine()->getManager();
			$doctrine_manager->getConfiguration()->setSQLLogger(null);
			
			$uniprot_accession = $protein->getUniprotId();
			
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
						//get the gene name node from xml
						$entrez_gene = $crawler->filter('uniprot > entry > dbReference[type="GeneID"]');
						
						if($entrez_gene->count()){
						
							$entrez_gene_id = $entrez_gene->attr("id");
							
							$protein->setEntrezId($entrez_gene_id);
							/*
							$external_link = new External_Link;
							$external_link->setDatabaseName("Ensembl");
							$external_link->setLinkId($entrez_gene_id);
							$external_link->setLink("http://www.ensembl.org/id/" . $entrez_gene_id);
							$external_link->setProtein($protein);
							$protein->addExternalLink($external_link);
							
							$doctrine_manager->persist($entrez_gene_id);

							$identifier = new Identifier();
							
							$identifier->setIdentifier($ensembl_gene_id);
							$identifier->setNamingConvention('ensembl');
							$identifier->setProtein($protein);
							
							$doctrine_manager->persist($identifier);
						
						}
					}
					catch(Exception $e) {
					}

				}
			}
			catch(Exception $e) {
			}
			
			$doctrine_manager->persist($protein);
			$doctrine_manager->flush();

		}
		

		
		$handle = fopen('D:\\test\\subcellular_location.csv', 'r');
		
		while ($file_data = fgetcsv($handle, 0, ","))
		{
			
			
			list ($ensembl_id, $gene_name, $reliability, $validated, $supported, $approved, $uncertain, $cell_to_cell_variation_spatial, $cell_to_cell_variation_intensity, $cell_cycle_dependency, $go_id) = $file_data;
			
			

			
			
			$new_subcellular_location_expression = new Subcellular_Location_Expression();
			
			$new_subcellular_location_expression->setEnsemblId($ensembl_id);
			

			
			$locations = explode(";", $validated);
			
			foreach ($locations as $location){
				if($location == 'Aggresome'){
					$new_subcellular_location_expression->setAggresome('validated');
				}
				if($location == 'Cell junctions'){
					$new_subcellular_location_expression->setCellJunctions('validated');
				}
				if($location == 'Centrosome'){
					$new_subcellular_location_expression->setCentrosome('validated');
				}
				if($location == 'Cytokinetic bridge'){
					$new_subcellular_location_expression->setCytokineticBridge('validated');
				}

				if($location == 'Cytoplasmic bodies'){
					$new_subcellular_location_expression->setCytoplasmicBodies('validated');
				}
				
				if($location == 'Cytosol'){
					$new_subcellular_location_expression->setCytosol('validated');
				}
				
				if($location == 'Endoplasmic reticulum'){
					$new_subcellular_location_expression->setEndoplasmicReticulum('validated');
				}
				
				if($location == 'Endosomes'){
					$new_subcellular_location_expression->setEndosomes('validated');
				}
				if($location == 'Focal adhesion sites'){
					$new_subcellular_location_expression->setFocalAdhesionSites('validated');
				}
				if($location == 'Golgi apparatus'){
					$new_subcellular_location_expression->setGolgiApparatus('validated');
				}
				if($location == 'Intermediate filaments'){
					$new_subcellular_location_expression->setIntermediateFilaments('validated');
				}
				if($location == 'Lipid droplets'){
					$new_subcellular_location_expression->setLipidDroplets('validated');
				}
				if($location == 'Lysosomes'){
					$new_subcellular_location_expression->setLysosomes('validated');
				}
				if($location == 'Microtubule ends'){
					$new_subcellular_location_expression->setMicrotubuleEnds('validated');
				}
				if($location == 'Microtubule organizing center'){
					$new_subcellular_location_expression->setMicrotubuleOrganizingCenter('validated');
				}
				if($location == 'Microtubules'){
					$new_subcellular_location_expression->setMicrotubules('validated');
				}
				if($location == 'Midbody'){
					$new_subcellular_location_expression->setMidbody('validated');
				}
				if($location == 'Mitochondria'){
					$new_subcellular_location_expression->setMitochondria('validated');
				}
				if($location == 'Microtubules'){
					$new_subcellular_location_expression->setMicrotubules('validated');
				}
				if($location == 'Mitotic spindle'){
					$new_subcellular_location_expression->setMitoticSpindle('validated');
				}
				if($location == 'Nuclear bodies'){
					$new_subcellular_location_expression->setNuclearBodies('validated');
				}
				if($location == 'Nucleoli'){
					$new_subcellular_location_expression->setNucleoli('validated');
				}
				if($location == 'Nucleoli fibrillar center'){
					$new_subcellular_location_expression->setNucleoliFibrillarCenter('validated');
				}
				if($location == 'Nucleoplasm'){
					$new_subcellular_location_expression->setNucleoplasm('validated');
				}
				if($location == 'Peroxisomes'){
					$new_subcellular_location_expression->setPeroxisomes('validated');
				}
				if($location == 'Plasma membrane'){
					$new_subcellular_location_expression->setPlasmaMembrane('validated');
				}
				if($location == 'Peroxisomes'){
					$new_subcellular_location_expression->setPeroxisomes('validated');
				}
				if($location == 'Rods & Rings'){
					$new_subcellular_location_expression->setRodsAndRings('validated');
				}
				if($location == 'Vesicles'){
					$new_subcellular_location_expression->setVesicles('validated');
				}
			}
			
			$locations = explode(";", $supported);
			
			foreach ($locations as $location){
				if($location == 'Aggresome'){
					$new_subcellular_location_expression->setAggresome('supported');
				}
				if($location == 'Cell junctions'){
					$new_subcellular_location_expression->setCellJunctions('supported');
				}
				if($location == 'Centrosome'){
					$new_subcellular_location_expression->setCentrosome('supported');
				}
				if($location == 'Cytokinetic bridge'){
					$new_subcellular_location_expression->setCytokineticBridge('supported');
				}
				
				if($location == 'Cytoplasmic bodies'){
					$new_subcellular_location_expression->setCytoplasmicBodies('supported');
				}
				
				if($location == 'Cytosol'){
					$new_subcellular_location_expression->setCytosol('supported');
				}
				
				if($location == 'Endoplasmic reticulum'){
					$new_subcellular_location_expression->setEndoplasmicReticulum('supported');
				}
				
				if($location == 'Endosomes'){
					$new_subcellular_location_expression->setEndosomes('supported');
				}
				if($location == 'Focal adhesion sites'){
					$new_subcellular_location_expression->setFocalAdhesionSites('supported');
				}
				if($location == 'Golgi apparatus'){
					$new_subcellular_location_expression->setGolgiApparatus('supported');
				}
				if($location == 'Intermediate filaments'){
					$new_subcellular_location_expression->setIntermediateFilaments('supported');
				}
				if($location == 'Lipid droplets'){
					$new_subcellular_location_expression->setLipidDroplets('supported');
				}
				if($location == 'Lysosomes'){
					$new_subcellular_location_expression->setLysosomes('supported');
				}
				if($location == 'Microtubule ends'){
					$new_subcellular_location_expression->setMicrotubuleEnds('supported');
				}
				if($location == 'Microtubule organizing center'){
					$new_subcellular_location_expression->setMicrotubuleOrganizingCenter('supported');
				}
				if($location == 'Microtubules'){
					$new_subcellular_location_expression->setMicrotubules('supported');
				}
				if($location == 'Midbody'){
					$new_subcellular_location_expression->setMidbody('supported');
				}
				if($location == 'Mitochondria'){
					$new_subcellular_location_expression->setMitochondria('supported');
				}
				if($location == 'Microtubules'){
					$new_subcellular_location_expression->setMicrotubules('supported');
				}
				if($location == 'Mitotic spindle'){
					$new_subcellular_location_expression->setMitoticSpindle('supported');
				}
				if($location == 'Nuclear bodies'){
					$new_subcellular_location_expression->setNuclearBodies('supported');
				}
				if($location == 'Nucleoli'){
					$new_subcellular_location_expression->setNucleoli('supported');
				}
				if($location == 'Nucleoli fibrillar center'){
					$new_subcellular_location_expression->setNucleoliFibrillarCenter('supported');
				}
				if($location == 'Nucleoplasm'){
					$new_subcellular_location_expression->setNucleoplasm('supported');
				}
				if($location == 'Peroxisomes'){
					$new_subcellular_location_expression->setPeroxisomes('supported');
				}
				if($location == 'Plasma membrane'){
					$new_subcellular_location_expression->setPlasmaMembrane('supported');
				}
				if($location == 'Peroxisomes'){
					$new_subcellular_location_expression->setPeroxisomes('supported');
				}
				if($location == 'Rods & Rings'){
					$new_subcellular_location_expression->setRodsAndRings('supported');
				}
				if($location == 'Vesicles'){
					$new_subcellular_location_expression->setVesicles('supported');
				}
			}
			
			$locations = explode(";", $approved);
			
			foreach ($locations as $location){
				if($location == 'Aggresome'){
					$new_subcellular_location_expression->setAggresome('approved');
				}
				if($location == 'Cell junctions'){
					$new_subcellular_location_expression->setCellJunctions('approved');
				}
				if($location == 'Centrosome'){
					$new_subcellular_location_expression->setCentrosome('approved');
				}
				if($location == 'Cytokinetic bridge'){
					$new_subcellular_location_expression->setCytokineticBridge('approved');
				}
				
				if($location == 'Cytoplasmic bodies'){
					$new_subcellular_location_expression->setCytoplasmicBodies('approved');
				}
				
				if($location == 'Cytosol'){
					$new_subcellular_location_expression->setCytosol('approved');
				}
				
				if($location == 'Endoplasmic reticulum'){
					$new_subcellular_location_expression->setEndoplasmicReticulum('approved');
				}
				
				if($location == 'Endosomes'){
					$new_subcellular_location_expression->setEndosomes('approved');
				}
				if($location == 'Focal adhesion sites'){
					$new_subcellular_location_expression->setFocalAdhesionSites('approved');
				}
				if($location == 'Golgi apparatus'){
					$new_subcellular_location_expression->setGolgiApparatus('approved');
				}
				if($location == 'Intermediate filaments'){
					$new_subcellular_location_expression->setIntermediateFilaments('approved');
				}
				if($location == 'Lipid droplets'){
					$new_subcellular_location_expression->setLipidDroplets('approved');
				}
				if($location == 'Lysosomes'){
					$new_subcellular_location_expression->setLysosomes('approved');
				}
				if($location == 'Microtubule ends'){
					$new_subcellular_location_expression->setMicrotubuleEnds('approved');
				}
				if($location == 'Microtubule organizing center'){
					$new_subcellular_location_expression->setMicrotubuleOrganizingCenter('approved');
				}
				if($location == 'Microtubules'){
					$new_subcellular_location_expression->setMicrotubules('approved');
				}
				if($location == 'Midbody'){
					$new_subcellular_location_expression->setMidbody('approved');
				}
				if($location == 'Mitochondria'){
					$new_subcellular_location_expression->setMitochondria('approved');
				}
				if($location == 'Microtubules'){
					$new_subcellular_location_expression->setMicrotubules('approved');
				}
				if($location == 'Mitotic spindle'){
					$new_subcellular_location_expression->setMitoticSpindle('approved');
				}
				if($location == 'Nuclear bodies'){
					$new_subcellular_location_expression->setNuclearBodies('approved');
				}
				if($location == 'Nucleoli'){
					$new_subcellular_location_expression->setNucleoli('approved');
				}
				if($location == 'Nucleoli fibrillar center'){
					$new_subcellular_location_expression->setNucleoliFibrillarCenter('approved');
				}
				if($location == 'Nucleoplasm'){
					$new_subcellular_location_expression->setNucleoplasm('approved');
				}
				if($location == 'Peroxisomes'){
					$new_subcellular_location_expression->setPeroxisomes('approved');
				}
				if($location == 'Plasma membrane'){
					$new_subcellular_location_expression->setPlasmaMembrane('approved');
				}
				if($location == 'Peroxisomes'){
					$new_subcellular_location_expression->setPeroxisomes('approved');
				}
				if($location == 'Rods & Rings'){
					$new_subcellular_location_expression->setRodsAndRings('approved');
				}
				if($location == 'Vesicles'){
					$new_subcellular_location_expression->setVesicles('approved');
				}
			}
			
			$em = $this->getDoctrine()->getManager();
			$em->getConfiguration()->setSQLLogger(null);
			
			$query = $em->createQuery(
					'SELECT p
					    FROM AppBundle:Protein p
					    WHERE p.ensembl_id = :ensembl_id'
					)->setParameter('ensembl_id', $ensembl_id);
					
					$protein_array = $query->getResult();
					
					if($protein_array){
						
						$protein = $protein_array[0];
						
						if($protein){
							
							$new_subcellular_location_expression->setProtein($protein);
							$protein->setSubcellularLocationExpression($new_subcellular_location_expression);
							$em->persist($protein);
							
						}
					}
					
					$em->persist($new_subcellular_location_expression);
					
					$em->flush();
			
		}
		
		
		/*
		$handle = fopen('D:\\test\\gtex.txt', 'r');

		while ($file_data = fgetcsv($handle, 0, "\t"))
		{
			
			list ($uniprot_id_gtex, $adipose_subcutaneous, $adipose_visceral_omentum, $adrenal_gland, $artery_aorta, $artery_coronary, $artery_tibial,
					$brain_0, $brain_1, $brain_2, $breast_mammary_tissue,
					 $colon_sigmoid, $colon_transverse, $esophagus_gastroesophageal_junction, $esophagus_mucosa,	
					 $esophagus_muscularis, $heart_atrial_appendage, $heart_left_ventricle, $kidney_cortex,
					 $liver, $lung, $minor_salivary_gland, $muscle_skeletal, $nerve_tibial, $ovary, $pancreas,	
					 $pituitary, $prostate, $skin, $small_intestine_terminal_ileum, $spleen, $stomach, $testis,
					 $thyroid, $uterus, $vagina, $whole_blood) = $file_data;
			
					 
			 $em = $this->getDoctrine()->getManager();
			 
			 $new_tissue_expression = new Tissue_Expression();
			 $new_tissue_expression->setUniprotId($uniprot_id_gtex);
			 $new_tissue_expression->setAdiposeSubcutaneous($adipose_subcutaneous);
			 $new_tissue_expression->setAdiposeVisceralOmentum($adipose_visceral_omentum);
			 $new_tissue_expression->setAdrenalGland($adrenal_gland);
			 $new_tissue_expression->setArteryAorta($artery_aorta);
			 $new_tissue_expression->setArteryCoronary($artery_coronary);
			 $new_tissue_expression->setArteryTibial($artery_tibial);
			 $new_tissue_expression->setBrain0($brain_0);
			 $new_tissue_expression->setBrain1($brain_1);
			 $new_tissue_expression->setBrain2($brain_2);
			 $new_tissue_expression->setBreastMammaryTissue($breast_mammary_tissue);
			 $new_tissue_expression->setColonSigmoid($colon_sigmoid);
			 $new_tissue_expression->setColonTransverse($colon_transverse);
			 $new_tissue_expression->setEsophagusGastroesophagealJunction($esophagus_gastroesophageal_junction);
			 $new_tissue_expression->setEsophagusMucosa($esophagus_mucosa);
			 $new_tissue_expression->setEsophagusMuscularis($esophagus_muscularis);
			 $new_tissue_expression->setHeartAtrialAppendage($heart_atrial_appendage);
			 $new_tissue_expression->setHeartLeftVentricle($heart_left_ventricle);
			 $new_tissue_expression->setKidneyCortex($kidney_cortex);
			 $new_tissue_expression->setLiver($liver);
			 $new_tissue_expression->setLung($lung);
			 $new_tissue_expression->setMinorSalivaryGland($minor_salivary_gland);
			 $new_tissue_expression->setMuscleSkeletal($muscle_skeletal);
			 $new_tissue_expression->setNerveTibial($nerve_tibial);
			 $new_tissue_expression->setOvary($ovary);
			 $new_tissue_expression->setPancreas($pancreas);
			 $new_tissue_expression->setPituitary($pituitary);
			 $new_tissue_expression->setProstate($prostate);
			 $new_tissue_expression->setSkin($skin);
			 $new_tissue_expression->setSmallIntestineTerminalIleum($small_intestine_terminal_ileum);
			 $new_tissue_expression->setSpleen($spleen);
			 $new_tissue_expression->setStomach($stomach);
			 $new_tissue_expression->setTestis($testis);
			 $new_tissue_expression->setThyroid($thyroid);
			 $new_tissue_expression->setUterus($uterus);
			 $new_tissue_expression->setVagina($vagina);
			 $new_tissue_expression->setWholeBlood($whole_blood);
	
			 
			 
			 $query = $em->createQuery(
			 		'SELECT p
					    FROM AppBundle:Protein p
					    WHERE p.name = :uniprot_id'
			 		)->setParameter('uniprot_id', $uniprot_id_gtex);
			 
			$protein_array = $query->getResult();
			
			if($protein_array){
				
				$protein = $protein_array[0];
				 		
				if($protein){
				 		
			 		$new_tissue_expression->setProtein($protein);
			 		$protein->setTissueExpression($new_tissue_expression);
			 		$em->persist($protein);
			 		
				}
			}
			
	 		$em->persist($new_tissue_expression);
	 		
	 		$em->flush();
		}
	
		*/
		
		$em = $this->getDoctrine()->getManager();
	
		$protein_query = $em->createQuery('SELECT COUNT(p.id) FROM AppBundle:Protein p');
	
		$protein_count = $protein_query->getSingleScalarResult();
	
		$organism_query = $em->createQuery('SELECT COUNT(o.id) FROM AppBundle:Organism o');
	
		$organism_count = $organism_query->getSingleScalarResult();
	
		$interaction_query = $em->createQuery('SELECT COUNT(i.id) FROM AppBundle:Interaction i');
	
		$interaction_count = $interaction_query->getSingleScalarResult();
		
		$domain_instance_query = $em->createQuery('SELECT COUNT(d.id) FROM AppBundle:Domain d');
		
		$domain_instance_count = $domain_instance_query->getSingleScalarResult();
	
		$domain_query = $em->createQuery('SELECT COUNT(d.id) FROM AppBundle:Domain d');
	
		$domain_count = $domain_query->getSingleScalarResult();
	
		$announcement_query = $em->createQuery(
				'SELECT a
			    FROM AppBundle:Announcement a
			    WHERE a.show_on_home_page = :show_on_home_page
			    ORDER BY a.show_on_home_page ASC'
				)->setParameter('show_on_home_page', '1');
	
		$announcements = $announcement_query->getResult();

		$announcements = array_reverse($announcements);

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
		$home_page = $admin_settings->getHomePage();
		
		$login_status = false;
		
		$is_fully_authenticated = $this->get('security.context')
		->isGranted('IS_AUTHENTICATED_FULLY');
		
		if($is_fully_authenticated){
		    $login_status =  true;
		}
		
		$admin_status = false;
		
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			$admin_status = true;
		}
		
		return $this->render('home.html.twig', array(
		        'announcements' => $announcements,
		        'protein_count' => $protein_count,
		        'organism_count' => $organism_count,
		        'interaction_count' => $interaction_count,
		        'domain_count' => $domain_count,
		        'domain_instance_count' => $domain_instance_count,
		        'title' => $title,
		        'home_page' => $home_page,
		        'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
		        'short_title' => $short_title,
		        'footer' => $footer,
		        'login_status' => $login_status,
				'admin_status' => $admin_status
		));
	

	}
	
	public function count($entity){
		
		$sql = 'SELECT COUNT(i.id) FROM AppBundle:' . $entity . ' i';
		
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery($sql);
		
		$count = $query->getSingleScalarResult();
		
		return $count;
		
	}

}

?>
