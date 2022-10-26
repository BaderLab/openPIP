<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Interaction;
use AppBundle\Utils\Functions;
use AppBundle\Entity\Domain;
use AppBundle\Entity\Protein;
use AppBundle\Entity\Identifier;
use AppBundle\Entity\Annotation;
use AppBundle\Entity\Annotation_Type;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Home controller.
 *
INSERT INTO `annotation`(`id`, `annotation`, `identifier`, `annotation_type`, `type_name`) VALUES

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
	    
			

		$rand_protein=self::getrandomprotein();
		// var_dump($rand_protein);
		// die();

		$functions = $this->get('app.functions');
		$counts = self::getCounts();
		$protein_count = $counts->protein_count;
		$organism_count = $counts->organism_count;
		$interaction_count = $counts->interaction_count;
		$domain_count = $counts->domain_count;	
		$announcements = self::getAnnouncements();
		$admin_settings =  $functions->getAdminSettings();	
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
		$home_page = $admin_settings->getHomePage();
		$mission_title = $admin_settings->getMissionTitle();
		$mission_text = $admin_settings->getMissionText();
		$method_title = $admin_settings->getMethodTitle();
		$method_text = $admin_settings->getMethodText();

		$url = $admin_settings->getUrl();
		$login_status = $functions->getLoginStatus();
		$admin_status = $functions->GetAdminStatus();

		return $this->render('home2.html.twig', array(
		        'announcements' => $announcements,
		        'protein_count' => $protein_count,
		        'organism_count' => $organism_count,
		        'interaction_count' => $interaction_count,
		        'domain_count' => $domain_count,
		        'title' => $title,
		        'url' => $url,
		        'home_page' => $home_page,
		        'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
		        'short_title' => $short_title,
		        'footer' => $footer,
		        'login_status' => $login_status,
				'admin_status' => $admin_status,
				'page' => 'home',
				'mission_title'=> $mission_title,
				'mission_text'=> $mission_text,
				'method_title'=> $method_title,
				'method_text'=> $method_text,
				'rand_protein'=> $rand_protein

		));



		/*
					
					$dataFile = "Interactor A Gene Name,Interactor B Gene Name,Interactor A Ensembl ID,Interactor B Ensembl ID,Interactor A Uniprot ID, Interactor B Uniprot ID,Interactor A Entrez ID,Interactor B Entrez ID,Confidence Score\r\n";
					
					
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT * FROM `interaction` WHERE `removed` = 0";
					$result = $connection->query($query);
					$count = 0;
					while($row = $result->fetch_assoc()) {
						$score = $row['score'];
						$interactor_A_index = $row['interactor_A'];
						$interactor_B_index = $row['interactor_B'];
						
						$interactor_A = $this->getDoctrine()
						->getRepository(Protein::class)
						->find($interactor_A_index);
						
						$interactor_B = $this->getDoctrine()
						->getRepository(Protein::class)
						->find($interactor_B_index);

						
						$uniprot_A = $interactor_A->getUniprotId();
						$ensembl_A = $interactor_A->getEnsemblId();
						$entrez_A = $interactor_A->getEntrezId();
						$gene_name_A = $interactor_A->getGeneName();
						
						$uniprot_B = $interactor_B->getUniprotId();
						$ensembl_B = $interactor_B->getEnsemblId();
						$entrez_B = $interactor_B->getEntrezId();
						$gene_name_B = $interactor_B->getGeneName();
						
						$dataFile = $dataFile .  $gene_name_A . "," . $gene_name_B . "," . $ensembl_A . "," . $ensembl_B . "," . $uniprot_A . "," . $uniprot_B . "," . $entrez_A . "," . $entrez_B . "," . $score . "\r\n";
					}
					
					
					$h = fopen('/home/mmee/Desktop/file.txt', 'w');
					fwrite($h, $dataFile);
					
					
					*/
					
					/*
					
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					$h1 = fopen('/home/mmee/Desktop/test_1.sql', 'w');
					$h2 = fopen('/home/mmee/Desktop/test_2.sql', 'w');
					
					$handle = fopen('/home/mmee/Desktop/yeast_interactome.tsv', 'r');
					$file_row = 0;
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$file_row++;
						if($file_row > 1){
							try{
								list ($ensembl_id_A, $ensembl_id_B) = $file_data;
								$interactor_A = self::getProteinFromEnsemblID($ensembl_id_A);
								$interactor_B = self::getProteinFromEnsemblID($ensembl_id_B);
								
								if($interactor_A && $interactor_B){
									
									$id_A = $interactor_A->getId();
									$id_B = $interactor_B->getId();
									
									$query = "INSERT INTO `interaction`(`id`, `removed`, `interactor_A`, `interactor_B`) VALUES ('',0,$id_A,$id_B)";
									$result = $connection->query($query);
								}
								
							}catch(Exception $e) {
							}
						}
					}
					

				
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					$h1 = fopen('/home/mmee/Desktop/test_1.sql', 'w');
					$h2 = fopen('/home/mmee/Desktop/test_2.sql', 'w');
					
					$handle = fopen('/home/mmee/Desktop/yeast_genes.tsv', 'r');
					$file_row = 0;
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$file_row++;
						if($file_row > 1){
							try{
								list ($ensembl_id, $uniprot, $entrez) = $file_data;

								
								$query = "INSERT INTO `protein`(`id`, `uniprot_id`, `ensembl_id`, `entrez_id`) VALUES ('', '$uniprot', '$ensembl_id', '$entrez');";

								
								fwrite($h1, $query . "\n");
								
								$query = "INSERT INTO `identifier`(`id`, `identifier`, `naming_convention`) VALUES ('', '$uniprot', 'uniprotkb');";
						
								fwrite($h2, $query . "\n");
								$query = "INSERT INTO `identifier`(`id`, `identifier`, `naming_convention`) VALUES ('', '$ensembl_id', 'ensembl');";

								fwrite($h2, $query . "\n");
								
							}catch(Exception $e) {
							}
						}
					}
					
				
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query2 = "SELECT * FROM `protein`";
					$result2 = $connection->query($query2);
					$count = 0;
					//$handle3 = fopen('/home/mmee/Desktop/test2.txt', 'w');
					while($row = $result2->fetch_assoc()) {
						$count++;
						
						$protein_id = $row['id'];
						$ensembl_id = $row['ensembl_id'];
						$uniprot_id = $row['uniprot_id'];
						$gene_name = $row['gene_name'];
						
						$query = "INSERT INTO `identifier`(`id`, `identifier`, `naming_convention`) VALUES ('', '$gene_name', 'gene_name');";
						$connection->query($query);
						
						if($ensembl_id != null && $ensembl_id != ''){
							$query3 = "SELECT * FROM `identifier` WHERE `identifier` = '$ensembl_id'";
							$result3 = $connection->query($query3);
							while($row2 = $result3->fetch_assoc()) {
								$identifier_id = $row2['id'];
								$query4 = "INSERT INTO `protein_identifier`(`identifier_id`, `protein_id`) VALUES ('$identifier_id', '$protein_id')";
								$connection->query($query4);
								
							}
						}
						
						if($uniprot_id != null && $uniprot_id != ''){
							$query3 = "SELECT * FROM `identifier` WHERE `identifier` = '$uniprot_id'";
							$result3 = $connection->query($query3);
							while($row2 = $result3->fetch_assoc()) {
								$identifier_id = $row2['id'];
								$query4 = "INSERT INTO `protein_identifier`(`identifier_id`, `protein_id`) VALUES ('$identifier_id', '$protein_id')";
								$connection->query($query4);
								
							}
						}
						
						if($gene_name != null && $gene_name != ''){
							$query3 = "SELECT * FROM `identifier` WHERE `identifier` = '$gene_name'";
							$result3 = $connection->query($query3);
							while($row2 = $result3->fetch_assoc()) {
								$identifier_id = $row2['id'];
								$query4 = "INSERT INTO `protein_identifier`(`identifier_id`, `protein_id`) VALUES ('$identifier_id', '$protein_id')";
								$connection->query($query4);
								
							}
						}
						
					}
					
					*/
				/*
					$h2 = fopen('/home/mmee/Desktop/test_2.sql', 'w');
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT * FROM `annotation` WHERE `annotation_type` = 5 ";
					$result = $connection->query($query);
					$count = 0;
					while($row = $result->fetch_assoc()) {
						$annotation_id = $row['id'];
						$interaction_id = $row['identifier'];
						$count++;
						if($count == 1){
							fwrite($h2, "INSERT INTO `annotation_interaction` (`interaction_id`, `annotation_id`) VALUES"  . "\n");
							fwrite($h2, "('$interaction_id','$annotation_id'),"  . "\n");
						}elseif($count < 300){
							fwrite($h2, "('$interaction_id','$annotation_id'),"  . "\n");
						}elseif($count == 300){
							fwrite($h2, "('$interaction_id','$annotation_id');"  . "\n");
							$count = 0;
						}
					}
					
				
					$h2 = fopen('/home/mmee/Desktop/test_2.sql', 'w');
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT `ensembl_id` FROM `protein` WHERE 1";
					$result = $connection->query($query);
					$ensembl_id_array = array();
					while($row = $result->fetch_assoc()) {
						$ensembl_id_array[] = $row['ensembl_id'];
					}

					$query = "SELECT * FROM `annotation` WHERE `annotation_type` = '1'";
					$result = $connection->query($query);
					$count = 0;
					while($row = $result->fetch_assoc()) {
						$annotation_id = $row['id'];
						$ensembl_id = $row['identifier'];
						if(in_array($ensembl_id, $ensembl_id_array)){
							$query2 = "SELECT * FROM `protein` WHERE `ensembl_id` = '$ensembl_id'";
							$result2 = $connection->query($query2);
							while($row2 = $result2->fetch_assoc()) {
							$protein_id = $row2['id'];
							//$query = "INSERT INTO `annotation_protein`(`protein_id`, `annotation_id`) VALUES ('$protein_id','$annotation_id');";
							//fwrite($h2, $query . "\n");
							$count++;
							if($count == 1){
								fwrite($h2, "INSERT INTO `annotation_protein` (`protein_id`, `annotation_id`) VALUES"  . "\n");
								fwrite($h2, "('$protein_id','$annotation_id'),"  . "\n");
							}elseif($count < 300){
								fwrite($h2, "('$protein_id','$annotation_id'),"  . "\n");
							}elseif($count == 300){
								fwrite($h2, "('$protein_id','$annotation_id');"  . "\n");
								$count = 0;
							}
							//$connection->query($query);
							}
						}
					}

				/*
					$query = "SELECT * FROM `annotation`";
					
					
					$this->container->get('profiler')->disable();
					$handle = fopen('/home/mmee/Desktop/huri_project/PSI_MI_Huri_20180629_full.txt', 'r');
					
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT `ensembl_id` FROM `protein` WHERE 1";
					$result = $connection->query($query);
					$ensembl_id_array = array();
					while($row = $result->fetch_assoc()) {
						$ensembl_id_array[] = $row['ensembl_id'];
					}
					

					$published_dataset_array = array("Yang et al.(2016)","Rolland et al.(2014)","Rual et al.(2005)","Yu et al.(2011)","Venkatesan et al.(2009)");
					
					$dataset_array = array("Yang et al.(2016)" => "6", "unpublished space III" => "2", "unpublished GSM test space" => "3",
						"Rolland et al.(2014)" => "1", "unpublished pilot screen" => "10",  "Rual et al.(2005)" => "5",
						"Yu et al.(2011)" => "4", "unpublished GS test space" => "7", "Venkatesan et al.(2009)" => "8");
						
					$h = fopen('/home/mmee/Desktop/test_1.txt', 'w');
					$h2 = fopen('/home/mmee/Desktop/test_2.txt', 'w');
					$h3 = fopen('/home/mmee/Desktop/test_3.txt', 'w');
					$count = 0;

					$interaction_categories_array = array();
					$interaction_dataset_array = array();
					
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$count++;
						fwrite($h2, $count . "\n");
						if($count > 1){
							try{
								list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $alt_interactor_B_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method,
									$publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database,
									$interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B,
									$experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A,
									$xref_inteqractor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism,
									$interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum,
									$negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B,
									$identification_method_paddrticipant_A, $identification_method_participant_B) = $file_data;
							
								
							$interactor_A_ensembl_id = self::getEnsemblID($alt_interactor_A_id);
							$interactor_B_ensembl_id = self::getEnsemblID($alt_interactor_B_id);

							$interactor_A_id = false;
							$interactor_B_id = false;	                        
							
							$query = "SELECT * FROM `protein` WHERE `ensembl_id` = '$interactor_A_ensembl_id'";

							$result = $connection->query($query);
							$interactor_A_array = array();
							if($result){
								while($row = $result->fetch_assoc()) {
									$interactor_A_array[] = $row['id'];
								}
							}

							if(array_key_exists(0, $interactor_A_array)){
								$interactor_A_id = $interactor_A_array[0];
							}
							$query = "SELECT * FROM `protein` WHERE `ensembl_id` = '$interactor_B_ensembl_id'";
							$result = $connection->query($query);

							$interactor_B_array = array();
							if($result){
								while($row = $result->fetch_assoc()) {
									$interactor_B_array[] = $row['id'];
								}
							}

							if(array_key_exists(0, $interactor_B_array)){
								$interactor_B_id = $interactor_B_array[0];
							}
							
							if($interactor_A_id && $interactor_B_id){
						
								$query = "SELECT * FROM `interaction` WHERE (`interactor_A` = '$interactor_A_id' AND `interactor_B` = '$interactor_B_id') OR (`interactor_A` = '$interactor_B_id' AND `interactor_B` = '$interactor_A_id')";
								$result = $connection->query($query);
								$interaction_array = array();
								
								if($result){
									while($row = $result->fetch_assoc()) {
										$interaction_array[] = $row['id'];
									}
								}
								$interaction_id = false;
								if(array_key_exists(0, $interaction_array)){
									$interaction_id = $interaction_array[0];
								}
								
								if($interaction_id){
			
									if($interaction_detection_method == 'psi-mi:"MI:1356"(validated two hybrid)'){
										$query = "INSERT INTO `interaction_interaction_category`(`interaction_category_id`, `interaction_id`) VALUES ('2','$interaction_id')";
										$connection->query($query);
									}elseif($interaction_detection_method == 'psi-mi:"MI:0397"(two hybrid array)'){
										$query = "INSERT INTO `interaction_interaction_category`(`interaction_category_id`, `interaction_id`) VALUES ('3','$interaction_id')";
										$connection->query($query);
									}elseif($interaction_detection_method == 'psi-mi:"MI:1112"(two hybrid prey pooling approach)'){
										$query = "INSERT INTO `interaction_interaction_category`(`interaction_category_id`, `interaction_id`) VALUES ('3','$interaction_id')";
										$connection->query($query);
									}
									
									if(in_array($publication_first_author, $published_dataset_array)){
										$query = "INSERT INTO `interaction_interaction_category`(`interaction_category_id`, `interaction_id`) VALUES ('1','$interaction_id')";
										$connection->query($query);
									}
									
									$dataset_id = $dataset_array[$publication_first_author];
									$query = "INSERT INTO `interaction_dataset`(`dataset_id`, `interaction_id`) VALUES ('$dataset_id','$interaction_id')";
									$connection->query($query);

								}
							}
									
							}catch(Exception $e) {
							}
						}
					}
					
					$handle = fopen('/home/mmee/Desktop/huri_project/LitBM-17.mitab', 'r');

					$file_row = 0;
					
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$file_row++;
						fwrite($h3, $file_row . "\n");
						if($file_row > 1){
							try{
								
								list ($V1, $V2, $V3, $V4, $V5, $V6, $V7, $V8, $V9, $V10, $V11, $V12, $V13, $V14, $V15) = $file_data;
								$annotation_array = array();
								$interactor_A_gene_name = self::getGeneName($V5);
								$interactor_B_gene_name = self::getGeneName($V6);
								$interactor_A_uniprot_id = self::getUniprotId($V1);
								$interactor_B_uniprot_id = self::getUniprotId($V2);
								
								if($interactor_A_gene_name && $interactor_B_gene_name){
									
									$interactor_A_id = false;
									$interactor_B_id = false;
									
									$query = "SELECT * FROM `protein` WHERE `gene_name` = '$interactor_A_gene_name'";
									
									$result = $connection->query($query);
									$interactor_A_array = array();
									if($result){
										while($row = $result->fetch_assoc()) {
											$interactor_A_array[] = $row['id'];
										}
									}
									
									if(array_key_exists(0, $interactor_A_array)){
										$interactor_A_id = $interactor_A_array[0];
									}
									$query = "SELECT * FROM `protein` WHERE `gene_name` = '$interactor_B_gene_name'";
									$result = $connection->query($query);
									
									$interactor_B_array = array();
									if($result){
										while($row = $result->fetch_assoc()) {
											$interactor_B_array[] = $row['id'];
										}
									}
									
									if(array_key_exists(0, $interactor_B_array)){
										$interactor_B_id = $interactor_B_array[0];
									}
									
									
									if($interactor_A_id && $interactor_B_id){
										
										$query = "SELECT * FROM `interaction` WHERE (`interactor_A` = '$interactor_A_id' AND `interactor_B` = '$interactor_B_id') OR (`interactor_A` = '$interactor_B_id' AND `interactor_B` = '$interactor_A_id')";
										$result = $connection->query($query);
										$interaction_array = array();
										
										if($result){
											while($row = $result->fetch_assoc()) {
												$interaction_array[] = $row['id'];
											}
										}
										$interaction_id = false;
										if(array_key_exists(0, $interaction_array)){
											$interaction_id = $interaction_array[0];
										}
										
										if($interaction_id){
											$query = "INSERT INTO `interaction_interaction_category`(`interaction_category_id`, `interaction_id`) VALUES ('4','$interaction_id')";
											$connection->query($query);

											$query = "INSERT INTO `interaction_dataset`(`dataset_id`, `interaction_id`) VALUES ('9','$interaction_id')";
											$connection->query($query);
											
										}
								}   
							}   
						}catch(Exception $e) {
							}
						}  
					}
				*/    /* 
					$h3 = fopen('/home/mmee/Desktop/test_3.txt', 'w');
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT `annotation_json`, `identifier` FROM `annotation` GROUP BY  (`annotation_json`, `identifier`) WHERE `id` > 1192784 ";
					$result = $connection->query($query);

					while($row = $result->fetch_assoc()) {
						
						$annotation_json = $row['annotation_json'];

						$id_array = array();
						$query2 = "SELECT * FROM `annotation` WHERE `annotation_json` = '$annotation_json'";
						fwrite($h3, $query2 . "\n");
						$result2 = $connection->query($query2);
						while($row2 = $result2->fetch_assoc()) {
						$id_array[] = $row2['id'];
						}
						foreach($id_array as $key => $id) {
							if($key === 0) continue;
							$query2 = "DELETE FROM `annotation` WHERE `id` = '$id'";
							$connection->query($query2);
						}
					}
					
					TRUNCATE TABLE `annotation`;
				
				
					
				/*
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$handle1 = fopen('/home/mmee/Desktop/huri_project/interaction_detection_methods_classification.csv', 'r');
					$file_row1 = 0;
					$int_detec_meth_array = array();
					$h1 = fopen('/home/mmee/Desktop/test_1.txt', 'w');
					fwrite($h1, 'START1' . "\n");
					while ($file_data = fgetcsv($handle1, 0, ",")){
						$file_row1++;
						if($file_row1 > 1){
							list ($mi_id, $name, $class)  = $file_data;
							$int_detec_meth_array[$mi_id] = $class;
							
						}
					}
					fwrite($h1, 'START2' . "\n");
					$handle = fopen('/home/mmee/Desktop/huri_project/LitBM-17.mitab', 'r');
					$h2 = fopen('/home/mmee/Desktop/test_2.sql', 'w');
					$file_row = 0;
					$not_found = array();
					$annotation_interaction_array = array();
					$count = 0;
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$file_row++;
						
						if($file_row > 1){
							//fwrite($h2, $file_row . "\n");
							try{
								
								list ($V1, $V2, $V3, $V4, $V5, $V6, $V7, $V8, $V9, $V10, $V11, $V12, $V13, $V14, $V15) = $file_data;
								$annotation_array = array();
								$interactor_A_gene_name = self::getGeneName($V5);
								$interactor_B_gene_name = self::getGeneName($V6);
								$interactor_A_uniprot_id = self::getUniprotId($V1);
								$interactor_B_uniprot_id = self::getUniprotId($V2);
								
								if($interactor_A_gene_name && $interactor_B_gene_name){
									
									$interactor_A_id = false;
									$interactor_B_id = false;
									
									$query = "SELECT * FROM `protein` WHERE `gene_name` = '$interactor_A_gene_name'";
									
									$result = $connection->query($query);
									$interactor_A_array = array();
									if($result){
										while($row = $result->fetch_assoc()) {
											$interactor_A_array[] = $row['id'];
										}
									}
									
									if(array_key_exists(0, $interactor_A_array)){
										$interactor_A_id = $interactor_A_array[0];
									}
									$query = "SELECT * FROM `protein` WHERE `gene_name` = '$interactor_B_gene_name'";
									$result = $connection->query($query);
									
									$interactor_B_array = array();
									if($result){
										while($row = $result->fetch_assoc()) {
											$interactor_B_array[] = $row['id'];
										}
									}
									
									if(array_key_exists(0, $interactor_B_array)){
										$interactor_B_id = $interactor_B_array[0];
									}
									
									
									if($interactor_A_id && $interactor_B_id){
										
										$query = "SELECT * FROM `interaction` WHERE (`interactor_A` = '$interactor_A_id' AND `interactor_B` = '$interactor_B_id') OR (`interactor_A` = '$interactor_B_id' AND `interactor_B` = '$interactor_A_id')";
										$result = $connection->query($query);
										$interaction_array = array();
										
										if($result){
											while($row = $result->fetch_assoc()) {
												$interaction_array[] = $row['id'];
											}
										}
										$interaction_id = false;
										if(array_key_exists(0, $interaction_array)){
											$interaction_id = $interaction_array[0];
										}
										
										if($interaction_id){
											$pmid_string = $V9;
											$pmid_array = preg_split('/:/', $pmid_string);
											$pmid = $pmid_array[1];
											
											$method_string = $V7;
											$method_array = preg_split('/:/', $method_string);
											
											$method_string2 = $method_array[2];
											$method_array2 = preg_split('/"/', $method_string2);
											$method_id = $method_array2[0];
											
											$method_array3 = preg_match('/.*\((.*)\).* /', $method_string);
											$method_name = $method_array3[0];
											
											$annotation_array['pmid'] = $pmid;
											$annotation_array['experiment_type'] = $method_id;
											
											$class = $int_detec_meth_array[$method_id];
											if($class == 'B'){
												$annotation_array['binary_type'] = 'binary';
											}elseif($class == 'I'){
												$annotation_array['binary_type'] = 'non_binary';
											}elseif($class == 'N'){
												$annotation_array['binary_type'] = 'na';
											}
											$annotation_array_json = json_encode($annotation_array);
											
											$count++;
											if($count == 1){
												fwrite($h2, "INSERT INTO `annotation`(`id`, `annotation`, `identifier`, `annotation_type`, `type_name`) VALUES"  . "\n");
												fwrite($h2, "('','$annotation_array_json','$interaction_id','4','litbm_interaction'),"  . "\n");
											}elseif($count < 300){
												fwrite($h2, "('','$annotation_array_json','$interaction_id','4','litbm_interaction'),"  . "\n");
											}elseif($count == 300){
												fwrite($h2, "('','$annotation_array_json','$interaction_id','4','litbm_interaction');"  . "\n");
												$count = 0;
											}
										}
									}
								}
								
							}catch(Exception $e) {
							}
						}
					}
					
					
				/*
					
					fwrite($h1, 'START3' . "\n");
					$annotation_type = $this->getDoctrine()
					->getRepository(Annotation_Type::class)
					->find('4');
					$count2 = 0;
					foreach($annotation_interaction_array as $interaction_id => $annotation_array){
						$count2++;
						fwrite($h1, $count2 . "\n");
						$interaction = self::getInteractionById($interaction_id);
						foreach($annotation_array as $annotation_interaction){
							$annotation_json = json_encode($annotation_interaction);
							$annotation = new Annotation();
							$annotation->setAnnotation($annotation_json);
							$annotation->setAnnotationType($annotation_type);
							$annotation->setIdentifier($interaction_id);
							$annotation->setTypeName('litbm_interaction');
							$interaction->addAnnotation($annotation);
							$annotation->addInteraction($interaction);
									$em = $this->getDoctrine()->getManager();
					$em->getConnection()->getConfiguration()->setSQLLogger(null);
							$em->persist($annotation);
							$em->persist($interaction);
							$em->flush();
						}
					}
				*/

				/*
					$this->container->get('profiler')->disable();
					$handle = fopen('/home/mmee/Desktop/huri_project/LitBM-17.mitab', 'r');
					
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					$query = "SELECT * FROM `interaction`";
					$result = $connection->query($query);
					$interaction_array = array();
					while($row = $result->fetch_assoc()) {
						$interactor_A = $row['interactor_A'];
						$interactor_B = $row['interactor_B'];
						$interaction_array[] = $interactor_A . '_' . $interactor_B;
					}
					$interaction_array2 = array();

					$count = 0;
					$handle3 = fopen('/home/mmee/Desktop/test2.txt', 'w');
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$count++;
						fwrite($handle3, $count . "\n");
						if($count > 1){
							try{
								list ($V1, $V2, $V3, $V4, $V5, $V6, $V7, $V8, $V9, $V10, $V11, $V12, $V13, $V14, $V15) = $file_data;
								
								$interactor_A_gene_name = self::getGeneName($V5);
								$interactor_B_gene_name = self::getGeneName($V6);
								$interactor_A_uniprot_id = self::getUniprotId($V1);
								$interactor_B_uniprot_id = self::getUniprotId($V2);

								
								if($interactor_A_gene_name && $interactor_B_gene_name){
									
									$interactor_A = self::getProteinFromGeneName($interactor_A_gene_name);
									$interactor_B = self::getProteinFromGeneName($interactor_B_gene_name);
									
									if($interactor_A && $interactor_B){

										$id_A = $interactor_A->getId();
										$id_B = $interactor_B->getId();
										
										$forward = $id_A . '_' . $id_B;
										$reverse = $id_B . '_' . $id_A;
										
										if(!in_array($forward, $interaction_array) && !in_array($reverse, $interaction_array)){

											$query = "INSERT INTO `interaction`(`id`, `removed`, `interactor_A`, `interactor_B`) VALUES ('',0,$id_A,$id_B)";
											$result = $connection->query($query);
											$interaction_array[] = $forward;
											$interaction_array2[] = $forward;
										
										}elseif(!in_array($forward, $interaction_array2) && !in_array($reverse, $interaction_array2)){
										
											$interaction_id = self::getInteraction($interactor_A, $interactor_B);
											$query = "UPDATE `interaction` SET `removed`= 0 WHERE `id` = $interaction_id";
											$result = $connection->query($query);
											$interaction_array2[] = $forward;
										
										}else{
										
										}
									}
								}
							}catch(Exception $e) {
							}
						}
					}
				*/    

				/*
					$this->container->get('profiler')->disable();
					$handle = fopen('/home/mmee/Desktop/huri_project/LitBM-17.mitab', 'r');
					
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT `uniprot_id` FROM `protein` WHERE 1";
					$result = $connection->query($query);
					$uniprot_id_array = array();
					while($row = $result->fetch_assoc()) {
						$uniprot_id_array[] = $row['uniprot_id'];
					}
					
					$query = "SELECT `gene_name` FROM `protein` WHERE 1";
					$result = $connection->query($query);
					$gene_name_array = array();
					while($row = $result->fetch_assoc()) {
						$gene_name_array[] = $row['gene_name'];
					}
					
					
					scp -r transfer 
					sudo scp -r transfer/ openpip@192.168.81.209:/home/openpip/move

					
					$count = 0;
					$handle3 = fopen('/home/mmee/Desktop/test2.txt', 'w');
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$count++;
						fwrite($handle3, $count . "\n");
						if($count > 1){
							try{
								list ($V1, $V2, $V3, $V4, $V5, $V6, $V7, $V8, $V9, $V10, $V11, $V12, $V13, $V14, $V15) = $file_data;
									
								$interactor_A_gene_name = self::getGeneName($V5);
								$interactor_B_gene_name = self::getGeneName($V6);
								$interactor_A_uniprot_id = self::getUniprotId($V1);
								$interactor_B_uniprot_id = self::getUniprotId($V2);
								
								if(in_array($interactor_A_gene_name, $gene_name_array) == false && in_array($interactor_A_uniprot_id, $uniprot_id_array) == false ){
									if($interactor_A_uniprot_id != $interactor_A_gene_name){
										$protein = new Protein;
										$protein->setGeneName($interactor_A_gene_name);
										$interactor_A_uniprot_id = self::getUniprotId($V1);
										$protein->setUniprotId($interactor_A_uniprot_id);
										$doctrine_manager = $this->getDoctrine()->getManager();
										$doctrine_manager->getConfiguration()->setSQLLogger(null);
										$doctrine_manager->persist($protein);
										$doctrine_manager->flush();
										$gene_name_array[] = $interactor_A_gene_name;
										$uniprot_id_array[] = $interactor_A_uniprot_id;
									}
								}
								
								if(in_array($interactor_B_gene_name, $gene_name_array) == false && in_array($interactor_B_uniprot_id, $uniprot_id_array) == false ){
									if($interactor_B_uniprot_id != $interactor_B_gene_name){
										$protein = new Protein;
										$protein->setGeneName($interactor_B_gene_name);
										$protein->setUniprotId($interactor_B_uniprot_id);
										$doctrine_manager = $this->getDoctrine()->getManager();
										$doctrine_manager->getConfiguration()->setSQLLogger(null);
										$doctrine_manager->persist($protein);
										$doctrine_manager->flush();
										$gene_name_array[] = $interactor_B_gene_name;
										$uniprot_id_array[] = $interactor_B_uniprot_id;
									}
								}
									
							}catch(Exception $e) {
							}
						}
					}
					
				*//*

					$em = $this->getDoctrine()->getManager();
					$em->getConnection()->getConfiguration()->setSQLLogger(null);
					$repository = $this->getDoctrine()->getRepository('AppBundle:Protein');
					
					$interactions=$repository->findAll();
					
					$protein_counts=array();
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT * FROM `interaction` WHERE `removed` = 0";
					$result = $connection->query($query);
					
					
					while($row = $result->fetch_assoc()){
						$interactor_A = $row['interactor_A'];
						$interactor_B = $row['interactor_B'];
						
						if($row['removed'] == 0){
							if($interactor_A == $interactor_B){
								if(!array_key_exists($interactor_A, $protein_counts)){
									$protein_counts[$interactor_A] = 1;
								}else{
									$protein_counts[$interactor_A] = $protein_counts[$interactor_A] + 1;
								}
							}else{
								if(!array_key_exists($interactor_A, $protein_counts)){
									$protein_counts[$interactor_A] = 1;
								}else{
									$protein_counts[$interactor_A] = $protein_counts[$interactor_A] + 1;
								}
								if(!array_key_exists($interactor_B, $protein_counts)){
									$protein_counts[$interactor_B] = 1;
								}else{
									$protein_counts[$interactor_B] = $protein_counts[$interactor_B] + 1;
								}
							}
						}
					}
					$h2 = fopen('/home/mmee/Desktop/test_2.sql', 'w');
					
					foreach($protein_counts as $protein_id => $count){
						$query = "UPDATE `protein` SET `number_of_interactions_in_database`= '$count' WHERE `id` = '$protein_id';";
						fwrite($h2, $query  . "\n");
						//$connection->query($query);
					}
					

					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT * FROM `protein` GROUP BY `gene_name` HAVING COUNT(`gene_name`) > 1";
					$result = $connection->query($query);
					$count = 0;
					$handle = fopen('/home/mmee/Desktop/test2.txt', 'w');
					while($row = $result->fetch_assoc()) {
						
						$original_protein_id = $row['id'];
						$gene_name = $row['gene_name'];
						
								$em = $this->getDoctrine()->getManager();
					$em->getConnection()->getConfiguration()->setSQLLogger(null);
						$query = $em->createQuery("SELECT p FROM AppBundle:Protein p WHERE p.gene_name = :gene_name");
						$query->setParameter('gene_name', $gene_name);
						$results = $query->getResult();
						
						if(count($results == 2)){
							
							$original_protein = $results[0];
							$duplicate_protein = $results[1];
							$duplicate_protein_id = $duplicate_protein->getId();
							
							$em->remove($duplicate_protein);
							$em->flush();
					
							
							$duplicate_protein_ensembl_id = $duplicate_protein->getEnsemblId();
							
							$original_protein->setEnsemblId($duplicate_protein_ensembl_id);
							$em->persist($original_protein);
							$em->flush();
								
							
							$query = $em->createQuery("SELECT i FROM AppBundle:Interaction i WHERE i.interactor_A = :interactor_A OR i.interactor_B = :interactor_B");
							$query->setParameter('interactor_A', $original_protein);
							$query->setParameter('interactor_B', $original_protein);
							
							$original_interactions = $query->getResult();
							$original_interaction_array = array();
							
							foreach($original_interactions as $original_interaction){
								
								$int_A = $original_interaction->getInteractorA();
								$int_B = $original_interaction->getInteractorB();
								
								$int_A_id = $int_A->getId();
								$int_B_id = $int_B->getId();
								$original_interaction_array[] = $int_A_id . '_' . $int_B_id;
							
							}
							//fwrite($handle, json_encode($original_interaction_array));
						
							
							$query = $em->createQuery("SELECT i FROM AppBundle:Interaction i WHERE i.interactor_A = :interactor_A OR i.interactor_B = :interactor_B");
							$query->setParameter('interactor_A', $duplicate_protein);
							$query->setParameter('interactor_B', $duplicate_protein);
							
							$duplicate_interactions = $query->getResult();
							
							foreach($duplicate_interactions as $duplicate_interaction){
								$int_A = $duplicate_interaction->getInteractorA();
								$int_B = $duplicate_interaction->getInteractorB();
								$int_A_id = $int_A->getId();
								$int_B_id = $int_B->getId();
								$test_1 = '';
								if($int_A_id == $duplicate_protein_id){
									$test_1 = $original_protein_id . '_' . $int_B_id;
								}
								$test_2 = '';
								if($int_B_id == $duplicate_protein_id){
									$test_2 = $int_A_id . '_' . $original_protein_id;
								}
								if(in_array($test_1, $original_interaction_array) || in_array($test_2, $original_interaction_array)){
									$em->remove($duplicate_interaction);
									$em->flush();
								}else{
									if($int_A_id == $duplicate_protein_id){
										$duplicate_interaction->setInteractorA($original_protein);
										$em->persist($duplicate_interaction);
										$em->flush();
										
									}elseif($int_B_id == $duplicate_protein_id){
										$duplicate_interaction->setInteractorB($original_protein);
										$em->persist($duplicate_interaction);
										$em->flush();
									}
								}
							}
							
							
						}
					}
					
					*/	
					/*
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query2 = "SELECT * FROM `protein` WHERE id > 13923";
					$result2 = $connection->query($query2);
					$count = 0;
					$handle3 = fopen('/home/mmee/Desktop/test2.txt', 'w');
					while($row = $result2->fetch_assoc()) {
						$count++;
						fwrite($handle3, $count . "\n");
						$protein_id = $row['id'];
						$uniprot_id = $row['uniprot_id'];
						$gene_name_current = $row['gene_name'];
						$sequence = null;
						$description = null;
						$entrez_id = null;
						$gene_name = null;
						$protein_name = null;
						$ensembl_id = null;
						
						$url = "http://www.uniprot.org/uniprot/$uniprot_id.xml";
						try{
							$str= @file_get_contents($url);   
							if($str != FALSE){
								$str=str_replace('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://uniprot.org/uniprot http://www.uniprot.org/support/docs/uniprot.xsd"', "", $str);
								$crawler = new Crawler($str);
								#Sequence
								try{
									$sequence_xml = $crawler->filter('uniprot > entry > sequence');
									if($sequence_xml->count()){$sequence = $sequence_xml->text();}
								}catch(Exception $e) {}
								
								#Gene Name
								try{
									$gene_name_xml = $crawler->filter('uniprot > entry > gene > name');
									if($gene_name_xml->count()){$gene_name = $gene_name_xml->text();}
								}catch(Exception $e) {}
								
								#Protein Name
								try{
									$protein_name_xml = $crawler->filter('uniprot > entry > protein > recommendedName > fullName');
									if($protein_name_xml->count()){$protein_name = $protein_name_xml->text();}
								}catch(Exception $e) {}
								
								#Description
								try{
									$description_xml = $crawler->filter('uniprot > entry > comment[type="function"] > text');
									if($description_xml->count()){$description = $description_xml->text();}
								}catch(Exception $e) {}

								#entrez_gene_id
								try{
									$entrez_gene_xml = $crawler->filter('uniprot > entry > dbReference[type="GeneID"]');
									if($entrez_gene_xml->count()){$entrez_id = $entrez_gene_xml->attr("id");}
								}catch(Exception $e) {}
								
								#ensembl_gene_id
								try{
									$ensembl_xml = $crawler->filter('uniprot > entry > dbReference[type="Ensembl"] > property[type="gene ID"]');
									if($ensembl_xml->count()){$ensembl_id = $ensembl_xml->attr("value");}
								}catch(Exception $e) {}
								
								
								
								$sql = 'UPDATE `protein` SET ';
								$update_array = array();
								
								if($gene_name != null && $gene_name_current == null){
									$update_array[] = "`gene_name`= '$gene_name'";
								}
								
								if($protein_name != null){
									$update_array[] = "`protein_name`= '$protein_name'";
								}
						
								if($entrez_id != null){
									$update_array[] = "`entrez_id`= '$entrez_id'";
								}
								
								if($description != null){
									$description = $connection->real_escape_string($description);
									$update_array[] = "`description`= '$description'";
								}
							
								if($sequence != null){
									$sequence = $connection->real_escape_string($sequence);
									$update_array[] = "`sequence`= '$sequence'";
								}
							
								if($ensembl_id != null){
									$ensembl_id = $connection->real_escape_string($ensembl_id);
									$update_array[] = "`ensembl_id`= '$ensembl_id'";
								}
							
								$updates = join(',', $update_array);
								$sql = $sql . $updates .  " WHERE `id`= '$protein_id'";
								$connection->query($sql);
								
								$sequence = null;
								$description = null;
								$entrez_id = null;
								$gene_name = null;
								$protein_name = null;
								$ensembl_id = null;
						}
						}catch(Exception $e) {
							$sequence = null;
							$description = null;
							$entrez_id = null;
							$gene_name = null;
							$protein_name = null;
						}      
				}
				*/ 

				/*
					
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query2 = "SELECT * FROM `protein`  WHERE `id` > 13744";
					$result2 = $connection->query($query2);
					$count = 0;
					//$handle3 = fopen('/home/mmee/Desktop/test2.txt', 'w');
					while($row = $result2->fetch_assoc()) {
						$count++;
						
						$protein_id = $row['id'];
						$ensembl_id = $row['ensembl_id'];
						$uniprot_id = $row['uniprot_id'];
						$gene_name = $row['gene_name'];
						
						
						
						if($ensembl_id != null && $ensembl_id != ''){
							$query3 = "SELECT * FROM `identifier` WHERE `identifier` = '$ensembl_id'";
							$result3 = $connection->query($query3);
							while($row2 = $result3->fetch_assoc()) {
								$identifier_id = $row2['id'];
								$query4 = "INSERT INTO `protein_identifier`(`identifier_id`, `protein_id`) VALUES ('$identifier_id', '$protein_id')";
								$connection->query($query4);
								
							}
						}
						
						if($uniprot_id != null && $uniprot_id != ''){
							$query3 = "SELECT * FROM `identifier` WHERE `identifier` = '$uniprot_id'";
							$result3 = $connection->query($query3);
							while($row2 = $result3->fetch_assoc()) {
								$identifier_id = $row2['id'];
								$query4 = "INSERT INTO `protein_identifier`(`identifier_id`, `protein_id`) VALUES ('$identifier_id', '$protein_id')";
								$connection->query($query4);
								
							}
						}
						
						if($gene_name != null && $gene_name != ''){
							$query3 = "SELECT * FROM `identifier` WHERE `identifier` = '$gene_name'";
							$result3 = $connection->query($query3);
							while($row2 = $result3->fetch_assoc()) {
								$identifier_id = $row2['id'];
								$query4 = "INSERT INTO `protein_identifier`(`identifier_id`, `protein_id`) VALUES ('$identifier_id', '$protein_id')";
								$connection->query($query4);
								
							}
						}
						
					}
					*/
					
					/*
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query2 = "SELECT * FROM `protein` WHERE `id` > 13744";
					$result2 = $connection->query($query2);
					$count = 0;
					//$handle3 = fopen('/home/mmee/Desktop/test2.txt', 'w');
					while($row = $result2->fetch_assoc()) {
						$count++;
					
						$id = $row['id'];
						$ensembl_id = $row['ensembl_id'];
						$uniprot_id = $row['uniprot_id'];
						$gene_name = $row['gene_name'];
						
						
						
						if($ensembl_id != null && $ensembl_id != ''){
							$query3 = "INSERT INTO `identifier`(`id`, `identifier`, `naming_convention`) VALUES ('','$ensembl_id','ensembl')";
							$connection->query($query3);
						}
						
						if($uniprot_id != null && $uniprot_id != ''){
							$query4 = "INSERT INTO `identifier`(`id`, `identifier`, `naming_convention`) VALUES ('','$uniprot_id','uniprotkb')";
							$connection->query($query4);
						}
						
						if($gene_name != null && $gene_name != ''){
							$query5 = "INSERT INTO `identifier`(`id`, `identifier`, `naming_convention`) VALUES ('','$gene_name','gene_name')";
							$connection->query($query5);
						}
						
					}
					
				*/
					/*
					$this->container->get('profiler')->disable();
					$handle = fopen('/home/mmee/Desktop/huri_project/PSI_MI_Huri_20180629_full.txt', 'r');	    
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();  
					$query = "SELECT * FROM `interaction` WHERE `removed` = 0";
					$result = $connection->query($query);
					$interaction_array = array();
					while($row = $result->fetch_assoc()) {      
						$interactor_A = $row['interactor_A'];
						$interactor_B = $row['interactor_B'];   
						$interaction_array[] = $interactor_A . '_' . $interactor_B;
					}
					//$interaction_array2 = array();
					$count = 0;
					$handle2 = fopen('/home/mmee/Desktop/test.txt', 'w');
					$handle3 = fopen('/home/mmee/Desktop/test2.txt', 'w');
					
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$count++;
					fwrite($handle3, $count . "\n");
						if($count > 1){
							try{
								list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $alt_interactor_B_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method,
									$publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database,
									$interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B,
									$experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A,
									$xref_interactor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism,
									$interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum,
									$negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B,
									$identification_method_paddrticipant_A, $identification_method_participant_B) = $file_data;
									
								$interactor_A_ensembl_id = self::getEnsemblID($alt_interactor_A_id);
								$interactor_B_ensembl_id = self::getEnsemblID($alt_interactor_B_id);
								
								if($interactor_A_ensembl_id && $interactor_B_ensembl_id){
									
									$interactor_A = self::getProteinFromEnsemblID($interactor_A_ensembl_id);
									$interactor_B = self::getProteinFromEnsemblID($interactor_B_ensembl_id);
									
									if($interactor_A && $interactor_B){
			
										
										$id_A = $interactor_A->getId();
										$id_B = $interactor_B->getId();
										
										$forward = $id_A . '_' . $id_B;
										$reverse = $id_B . '_' . $id_A;
										
										if(!in_array($forward, $interaction_array) && !in_array($reverse, $interaction_array)){
											
											$interaction_id = self::getInteraction($interactor_A, $interactor_B);
											$query = "UPDATE `interaction` SET `removed`= 0 WHERE `id` = $interaction_id";
											$result = $connection->query($query);
											$interaction_array[] = $forward;
											
										}
										
										/*
										$id_A = $interactor_A->getId();
										$id_B = $interactor_B->getId();
										
										$forward = $id_A . '_' . $id_B;
										$reverse = $id_B . '_' . $id_A; 
										
										if(!in_array($forward, $interaction_array) && !in_array($reverse, $interaction_array)){
											
											$score=null;
											if($confidence_value != '-'){
												$array = explode(": ",$confidence_value);
												$score = $array[1];
											}
											$query = "INSERT INTO `interaction`(`id`, `score`, `removed`, `interactor_A`, `interactor_B`) VALUES ('',$score,0,$id_A,$id_B)";
											$result = $connection->query($query);
											$interaction_array[] = $forward;
											$interaction_array2[] = $forward;
											
										}elseif(!in_array($forward, $interaction_array2) && !in_array($reverse, $interaction_array2)){
											
											$interaction_id = self::getInteraction($interactor_A, $interactor_B);
											$query = "UPDATE `interaction` SET `removed`= 0 WHERE `id` = $interaction_id";
											$result = $connection->query($query);
											$interaction_array2[] = $forward;
											
										}else{
											
										}
										
									}else{
										
										fwrite($handle2, $count . "\n");
									}
								}else{
									
									fwrite($handle2, $count . "\n");
								}

							}catch(Exception $e) {
							}
						}
					}
				*/

					/*
					$handle = fopen('/home/mmee/Desktop/huri_project/uniprot_reviewed.tab', 'r');
					$handle2 = fopen('/home/mmee/Desktop/test.txt', 'w');
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					$count = 0;
					fwrite($handle2, 'START' . "\n");
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$count++;
						
						if($count > 1){
							
							try{
								list ($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) = $file_data;
								$array = explode(",",$b);
								if(count($array) > 1){
									foreach($array as $id){
										try{
											$query = "UPDATE `protein` SET `protein_name`= \"$g\",`uniprot_id`= \"$d\" WHERE `ensembl_id` = \"$id\"";
											fwrite($handle2, $query . "\n");
											$result = $connection->query($query);
										}catch(Exception $e) {
										}  
									}
								}
							}catch(Exception $e) {
							}
						}
					}
					
					
					$this->container->get('profiler')->disable();
					$handle = fopen('tab/home/mmee/Desktop/huri_project/PSI_MI_Huri_20180629_full.txt', 'r');
					
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$query = "SELECT `ensembl_id` FROM `protein` WHERE 1";
					$result = $connection->query($query);
					$ensembl_id_array = array();
					while($row = $result->fetch_assoc()) {
						$ensembl_id_array[] = $row['ensembl_id'];
					}
					
					$count = 0;
					
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$count++;
						
						if($count > 1){
							try{
								list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $alt_interactor_B_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method,
									$publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database,
									$interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B,
									$experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A,
									$xref_interactor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism,
									$interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum,
									$negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B,
									$identification_method_paddrticipant_A, $identification_method_participant_B) = $file_data;
									
									$interactor_A_ensembl_id = self::getEnsemblID($alt_interactor_A_id);
									$interactor_B_ensembl_id = self::getEnsemblID($alt_interactor_B_id);
									
									if(in_array($interactor_A_ensembl_id, $ensembl_id_array) == false){
										$protein = new Protein;
										$protein->setEnsemblId($interactor_A_ensembl_id);
										$doctrine_manager = $this->getDoctrine()->getManager();
										$doctrine_manager->getConfiguration()->setSQLLogger(null);
										$doctrine_manager->persist($protein);
										$doctrine_manager->flush();
										$ensembl_id_array[] = $interactor_A_ensembl_id;
									}
									
									if(in_array($interactor_B_ensembl_id, $ensembl_id_array) == false){
										$protein = new Protein;
										$protein->setEnsemblId($interactor_B_ensembl_id);
										$doctrine_manager = $this->getDoctrine()->getManager();
										$doctrine_manager->getConfiguration()->setSQLLogger(null);
										$doctrine_manager->persist($protein);
										$doctrine_manager->flush();
										$ensembl_id_array[] = $interactor_B_ensembl_id;
									}
									
							}catch(Exception $e) {
							}
						}
					}
					
					
					
					
					
					
					SELECT * FROM `protein`
					GROUP BY `gene_name`
					HAVING COUNT(`gene_name`) > 1
					
					SELECT * FROM `protein`
					GROUP BY `ensembl_id`
					HAVING COUNT(`ensembl_id`) > 1
					
					*/
					/*
					$functions = $this->get('app.functions');
					$connection =  $functions->mysql_connect();
					
					$this->container->get('profiler')->disable();
					$handle = fopen('/home/mmee/Desktop/huri_project/PSI_MI_Huri_20180629_full.txt', 'r');
					$h = fopen('/home/mmee/Desktop/test_1.txt', 'w');
					$h2 = fopen('/home/mmee/Desktop/test_2.txt', 'w');
					
					$dataset_array = array("Yang et al.(2016)" => "Yang-16", "unpublished space III" => "HI-III", "unpublished GSM test space" => "unpublished GSM test space", 
						"Rolland et al.(2014)" => "HI-II-14", "unpublished pilot screen" => "unpublished pilot screen",  "Rual et al.(2005)" => "HI-I-05",
						"Yu et al.(2011)" => "Yu-11", "unpublished GS test space" => "unpublished GS test space", "Venkatesan et al.(2009)" => "Venkatesan-09");

					$repository = $this->getDoctrine()->getRepository('AppBundle:Annotation_Type');
					$annotation_type=$repository->find('5');
					$count = 0;
					
					while ($file_data = fgetcsv($handle, 0, "\t")){
						$count++;
						fwrite($h, $count . "\n");
						if($count > 244945){
							try{
								list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $alt_interactor_B_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method,
									$publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database,
									$interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B,
									$experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A,
									$xref_interactor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism,
									$interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum,
									$negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B,
									$identification_method_paddrticipant_A, $identification_method_participant_B) = $file_data;

									if($annotation_interactor_A != '-' && $annotation_interactor_B != '-'){      
									
										$interactor_A_ensembl_id = self::getEnsemblID($alt_interactor_A_id);
										$interactor_B_ensembl_id = self::getEnsemblID($alt_interactor_B_id);
										
										$interactor_A = self::getProteinFromEnsemblID($interactor_A_ensembl_id);
										$interactor_B = self::getProteinFromEnsemblID($interactor_B_ensembl_id);
										if($interactor_A && $interactor_B){
											$interaction_id = self::getInteraction($interactor_A, $interactor_B);
											$interaction = self::getInteractionById($interaction_id);
											
											if($interaction){
												$annotations = $interaction->getAnnotations();
					
												$interactor_A_gene_name = $interactor_A->getGeneName();
												$interactor_B_gene_name = $interactor_B->getGeneName();
												
												$orf_A_id = self::getOrfId($interactor_A_alias);
												$orf_B_id = self::getOrfId($interactor_B_alias);
												$assay_version = self::getAssayVersion($annotation_interactor_A, $annotation_interactor_B);
												$num_screens = self::getNumberOfScreens($interaction_annotation);
												
												$experiment_annotation = array('dataset' => $dataset_array[$publication_first_author], 'dna_binding_domain' => $interactor_A_gene_name, 'activation_binding_domain' => $interactor_B_gene_name, 'orf_A_id' => $orf_A_id, 'orf_B_id' => $orf_B_id, 'assay_version' => $assay_version, 'num_screens' => $num_screens);
												$experiment_annotation_json = json_encode($experiment_annotation);
												
												$check = true;
												foreach($annotations as $anno){
													$annotation_json = $anno->getAnnotation();
													if($annotation_json == $experiment_annotation_json){
														$check = false;
													}   
												}
												if($check){
													
													$query = " INSERT INTO `annotation`(`id`, `annotation`, `identifier`, `annotation_type`, `type_name`) VALUES ('','$experiment_annotation_json','$interaction_id','5','experiment')";
													$result = $connection->query($query);
													
												/*
													$annotation = new Annotation();
													$annotation->setAnnotation($experiment_annotation_json);
													$annotation->setIdentifier($interaction_id);
													$annotation->setAnnotationType($annotation_type);
													$annotation->setTypeName('experiment');
													$interaction->addAnnotation($annotation);
													$annotation->addInteraction($interaction);
															$em = $this->getDoctrine()->getManager();
					$em->getConnection()->getConfiguration()->setSQLLogger(null);
													$em->persist($annotation);
													$em->persist($interaction);
													$em->flush();
													
												}
											}
										}
									}
							
								//$assay_version = self::getAssayVersion($annotation_interactor_A, $annotation_interactor_B);
								//$assay_version_array["$assay_version"] = $assay_version_array["$assay_version"] +1;
								
							// if($assay_version == null){
								// fwrite($h2, $annotation_interactor_A . $annotation_interactor_B . "\n");
							// }
							
						}catch(Exception $e) {
						}
						}
					}
			*/

	}
	
	public function getrandomprotein()
	{
		$protein_array=array();
	    
		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
		$query = $em->createQuery(
			"SELECT i.gene_name
				FROM AppBundle:Protein i"
				// WHERE i.id = :id"
			);
		$query->setMaxResults( 100 );
		// $query->setParameter('id', $interaction_id);
		$interaction_array = $query->getResult();

		foreach($interaction_array as $protein){
			$protein_array[]=$protein['gene_name'];
		}
		$List = implode(';', $protein_array);
		return $List;
		var_dump($List);
		die();



	}

	public function getInteractionById($interaction_id){
	    
	    		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
	    $query = $em->createQuery(
	        "SELECT i
				FROM AppBundle:Interaction i
				WHERE i.id = :id"
	        );
	    $query->setParameter('id', $interaction_id);
	    $interaction_array = $query->getResult();
	    
	    if(array_key_exists(0, $interaction_array)){
	        return $interaction_array[0];
	    }else{
	        return false;
	    }

	}
	
	public function getInteraction($interactor_A, $interactor_B){
	    
	    $interactor_A_id= $interactor_A->getId();
	    $interactor_B_id= $interactor_B->getId();
	    
	    $functions = $this->get('app.functions');
	    $connection =  $functions->mysql_connect();
	    
	    $query = "SELECT * FROM `interaction` WHERE (`interactor_A` = $interactor_A_id AND `interactor_B` = $interactor_B_id) OR (`interactor_A` = $interactor_B_id AND `interactor_B` = $interactor_A_id)";
	    $result = $connection->query($query);
	    $interaction_array = array();
	    
	    if($result){
	        while($row = $result->fetch_assoc()) {
	            $interaction_array[] = $row['id'];
	        }
	    }
	    mysqli_close($connection);
	    
	    if(array_key_exists(0, $interaction_array)){
	        return $interaction_array[0];
	    }else{
	        return false;
	    }
	}
	
	public function getEnsemblID($interactor_id_string){
	    
	    preg_match('/.*:(ENSG.*)\..*/', $interactor_id_string, $matches);	
	    
	    $ensembl_id = $matches[1];
	    return $ensembl_id;
	}
	
	public function getGeneName($interactor_id_string){
	    
	    preg_match('/uniprotkb:"?([a-zA-Z0-9\-]*).*\(gene name\).*/', $interactor_id_string, $matches);
	    
	    $ensembl_id = $matches[1];
	    return $ensembl_id;
	}
	
	public function getUniprotId($interactor_id_string){
	    
	    preg_match('/uniprotkb:(.*)/', $interactor_id_string, $matches);
	    
	    $ensembl_id = $matches[1];
	    return $ensembl_id;
	}
	
	public function getProteinFromEnsemblID($ensembl_id){
	    
	    		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
	    
	    $query = $em->createQuery(
	        "SELECT p
				    FROM AppBundle:Protein p
				    WHERE p.ensembl_id = :p_ensembl_id");
	    
	    $query->setParameter('p_ensembl_id', $ensembl_id);
	    $results = $query->getResult();

	    if(array_key_exists(0, $results)){
	        return $results[0];
	    }else{
	        return false;
	    }
	}
	
	public function getProteinFromGeneName($gene_name){
	    
	    		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
	    
	    $query = $em->createQuery(
	        "SELECT p
				    FROM AppBundle:Protein p
				    WHERE p.gene_name = :gene_name");
	    
	    $query->setParameter('gene_name', $gene_name);
	    $results = $query->getResult();
	    
	    if(array_key_exists(0, $results)){
	        return $results[0];
	    }else{
	        return false;
	    }
	}
	
	public function experimentHandler($interactor_A, $interactor_B, $interactor_A_alias, $interactor_B_alias, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation){
	    
	    $interactor_A_gene_name = $interactor_A->getGeneName();
	    $interactor_B_gene_name = $interactor_B->getGeneName();
	    $orf_A_id = self::getOrfId($interactor_A_alias);
	    $orf_B_id = self::getOrfId($interactor_B_alias);
	    $assay_version = self::getAssayVersion($annotation_interactor_A, $annotation_interactor_B);
	    $num_screens = self::getNumberOfScreens($interaction_annotation);
	    
	    $experiment_annotation = array('dataset' => 'HI-III', 'dna_binding_domain' => $interactor_A_gene_name, 'activation_binding_domain' => $interactor_B_gene_name, 'orf_A_id' => $orf_A_id, 'orf_B_id' => $orf_B_id, 'assay_version' => $assay_version, 'num_screens' => $num_screens);
	    $experiment_annotation_json = json_encode($experiment_annotation);
	    
	    return $experiment_annotation_json;
	}
	
	
	
	public function getNumberOfScreens($interaction_annotation){
	    
	    $matches_num_screens = '';    
	    preg_match('/comment:"Found in screens ([0-9,]*)\."/', $interaction_annotation, $matches_num_screens);	    
	    $num_screens_string = $matches_num_screens[1];
	    $num_screens_array = explode(",", $num_screens_string);
	    $num_screens = count($num_screens_array);
	    
	    return $num_screens;
	}
	
	public function getOrfId($interactor_alias){
	    $matches = '';
	    
	    preg_match('/human orfeome collection:([0-9]*)\(author assigned name\)/', $interactor_alias, $matches);
	    
	    $orf_id = $matches[1];
	    
	    return $orf_id;
	}
	
	public function getAssayVersion($annotation_interactor_A, $annotation_interactor_B){

	    $assay_version = null;
	    
	    if(preg_match('/.*pDEST-DB.*/',$annotation_interactor_A) &&
	        preg_match('/.*pDEST-AD.*/',$annotation_interactor_B)){
	            if(preg_match('/.*Y8930.*/',$annotation_interactor_A) ){
	                $assay_version = 1;
	            }elseif(preg_match('/.*MaV203.*/',$annotation_interactor_A)){
	                $assay_version = 0;
	            }       
	    }elseif(preg_match('/.*pDEST-DB.*/',$annotation_interactor_A) &&
	        preg_match('/.*pQZ213.*/',$annotation_interactor_B)){
	            
	            $assay_version = 2;
	            
	    }elseif(preg_match('/.*pQZ212.*/',$annotation_interactor_A) &&
	        preg_match('/.*pDEST-AD.*/',$annotation_interactor_B)){
	            
	            $assay_version = 3;
	            
	    }elseif(preg_match('/.*pQZ212.*/',$annotation_interactor_A) &&
	        preg_match('/.*pQZ213.*/',$annotation_interactor_B)){
	            
	            $assay_version = 4;
	            
	    }elseif(preg_match('/.*pDEST-DB.*/',$annotation_interactor_A) &&
	        preg_match('/.*pAR68.*/',$annotation_interactor_B)){
	            
	            $assay_version = 6;
	            
	    }elseif(preg_match('/.*pQZ212.*/',$annotation_interactor_A) &&
	        preg_match('/.*pAR68.*/',$annotation_interactor_B)){
	            
	            $assay_version = 8;
	            
	    }
	    
	    return $assay_version;
	
	}
	
	
	
	private function count($entity){
		
		$sql = 'SELECT COUNT(i.id) FROM AppBundle:' . $entity . ' i';		
				$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
		$query = $em->createQuery($sql);
		$count = $query->getSingleScalarResult();
		
		return $count;
		
	}

	private function getCounts(){
					
		$protein_count = self::count('Protein');			
		$organism_count = self::count('Organism');	
		$sql = 'SELECT COUNT(i.id) FROM AppBundle:Interaction i WHERE i.removed = 0';
				$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
		$query = $em->createQuery($sql);
		$interaction_count = $query->getSingleScalarResult();
		$domain_count =  self::count('Domain');
		
		$counts = new \stdClass();
		
		$counts->protein_count = $protein_count;
		$counts->organism_count = $organism_count;
		$counts->interaction_count = $interaction_count;
		$counts->domain_count = $domain_count;
		
		return $counts;
	}
	
	private function getAnnouncements(){
	
				$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);	
		$announcement_query = $em->createQuery(
			'SELECT a
			    FROM AppBundle:Announcement a
			    WHERE a.show_on_home_page = :show_on_home_page
			    ORDER BY a.show_on_home_page ASC'
			)->setParameter('show_on_home_page', '1');
			
		$announcements = $announcement_query->getResult();
		$announcements = array_reverse($announcements);
		
		return $announcements;
	}
	
	public function isNewIdentifier($identifier, $naming_convention){
		
				$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
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
	
	public function getIdentifier($identifier){
		
				$em = $this->getDoctrine()->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
		$query = $em->createQuery(
				"SELECT i
							FROM AppBundle:Identifier i
							WHERE i.identifier = :identifier
							AND i.naming_convention = :naming_convention"
				);
		
		$query->setParameter('identifier', $identifier);
		$query->setParameter('naming_convention', 'uniprotkb');
		$results = $query->getResult();

		return $results[0];
	
	}

}

?>




