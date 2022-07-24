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
