<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Test controller.
 *
 
 */
class TestController extends Controller
{
	
	/**
	 * Test
	 * @Route("/test/{pubmed_id}", name="test")
	 * @Method({"GET", "POST"})
	 */
	public function testAction($pubmed_id, Request $request)
	{
		$node_array = array();
		$edge_array = array();
		$pubmed_id_array_all = array();		
		$pubmed_id_array_1 = self::getCitedPubMedIdsFromPMID($pubmed_id);	
		$pubmed_id_array_2 = self::getCitedPubMedIdsFromPMIDList($pubmed_id_array_1);
		$pubmed_id_array_all[] = $pubmed_id;
		$pubmed_id_array_all = array_merge($pubmed_id_array_all, $pubmed_id_array_1);
		foreach($pubmed_id_array_2 as $key => $linkset){
			if(array_key_exists("linksetdbs",$linkset)){
				$linksetdbs =  $linkset['linksetdbs'][0];
				$links = $linksetdbs['links'];
				$pmid = $linkset['ids'][0];
				foreach($links as $link){
					$edge_array[] = [$pmid, $link];			
				}		
				$pubmed_id_array_all = array_merge($pubmed_id_array_all, $links);
			}
		}
		$pubmed_id_array_all = array_unique($pubmed_id_array_all);
		$pubmed_id_array_all = array_values($pubmed_id_array_all);
		$pubmed_metadata_array = self::getPubMedMetaData($pubmed_id_array_all);
		$year_array = array(1);	
		foreach($pubmed_id_array_all as $pubmed_id){
			if(array_key_exists($pubmed_id, $pubmed_metadata_array)){
				$node_array[] = $pubmed_metadata_array["$pubmed_id"];
				$year = $pubmed_metadata_array["$pubmed_id"][1];
				$year_array[] = $year;
			}else{
				$node_array[] = [$pubmed_id, 1];	
			}
		}
		
		$year_array = array_unique($year_array);
		$year_array = array_values($year_array);
		rsort($year_array);

		/*
		
		
		
		$citation_array_2 = self::getCitations($citation_1);
		$citation_array_3 = array_merge($citation_array_3, $citation_array_2);
		
		array_push($citation_array_3, $term);
		
		
		$node_array
		
		
		
		$citation_array_3 = array_unique($citation_array_3);
		$citation_array_3 = array_values($citation_array_3);
		
		
		foreach ($citation_array_3 as $id1){
			
			$id2_array = self::getCitations($id1);
			
			foreach($id2_array as $id2){
				if (in_array($id2, $citation_array_3)){
					
					$edge_array[] = array($id2, $id1 );
				}
				
			}
		}
		
		
		*/
		
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
		
		return $this->render('test.html.twig', array(
				'title' => $title,
				'home_page' => $home_page,
				'main_color_scheme' => $main_color_scheme,
				'header_color_scheme' => $header_color_scheme,
				'logo_color_scheme' => $logo_color_scheme,
				'button_color_scheme' => $button_color_scheme,
				'short_title' => $short_title,
				'footer' => $footer,
				'login_status' => $login_status,
				'admin_status' => $admin_status,
				'year_array' => $year_array,
				'node_array' => $node_array,
				'edge_array' => $edge_array,
		));
		
		
	}
	
	
	public function getCitedPubMedIdsFromPMID($pubmed_id){
		
		$url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/elink.fcgi?dbfrom=pubmed&linkname=pubmed_pubmed_refs&retmode=json&id=" . $pubmed_id;
		$str= @file_get_contents($url);
		
		$results_array = json_decode($str, true);
		
		return $results_array['linksets'][0]['linksetdbs'][0]['links'];
		
		
	}
	
	public function getCitedPubMedIdsFromPMIDList($citation_array_1){
		
		$query_string = '';
		
		foreach($citation_array_1 as $citation_1){
			$query_string .= '&id=' . $citation_1;
		}
		$url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/elink.fcgi?dbfrom=pubmed&linkname=pubmed_pubmed_refs&retmode=json" . $query_string;
		$str= @file_get_contents($url);
		
		$results_array = json_decode($str, true);
		
		return $results_array['linksets'];

	}
	
	public function getPubMedMetaData($pubmed_id_array){

		
		$pubmed_id_array_chunk_array = array_chunk($pubmed_id_array, 200);
		
		
		$metadata_array = array();
		
		
		foreach($pubmed_id_array_chunk_array as $pubmed_id_array_chunk){
			
			$query_string = join(',', $pubmed_id_array_chunk);
			
			$url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&retmode=json&id=" . $query_string;

			$str= @file_get_contents($url);
			
			$results_array = json_decode($str, true);
			$merge_array = array();
			$matches = null;
			if($results_array['result']){
				foreach($results_array['result'] as $pmid => $result){
					if(array_key_exists('pubdate', $result)){
						$pub_date = $result['pubdate'];
						$title = $result['title'];
						//$pmc = $result['pmc'];
						preg_match('/^.*([0-9]{4})/', $pub_date, $matches);
						$date = $matches[0];
						$merge_array[$pmid] = [$pmid, $date, $title];
						
					}
				} 
			}


			$metadata_array = $metadata_array + $merge_array;

		}
		
		
		return $metadata_array;
		
	}
	
}

?>
