<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Domain;
use AppBundle\Entity\Identifier;
use AppBundle\Entity\Protein;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Data controller.
 *
 * @Route("/admin/data_manager")
 */
class DataManagerController extends Controller
{
		
	/**
	 * 
	 *
	 * @Route("/", name="data_manager")
	 * @Method({"GET", "POST"})
	 */
	public function announcement_managerAction(Request $request)
	{
		
		$filename_1 = "C://Users/Miles/Desktop/test_tab.txt";
		$handle_1 = fopen($filename_1 , "r");
		
		while ($data = fscanf($handle_1, "%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\n"))
		{
			list ($interactor_A_id, $interactor_B_id, $alt_interactor_A_id, $interactor_A_alias, $interactor_B_alias, $interaction_detection_method,
					$publication_first_author, $publication_identifier, $taxid_interactor_A, $taxid_interactor_B, $interaction_type, $source_database,
					$interaction_identifier, $confidence_value, $expansion_method, $biological_role_interactor_A, $biological_role_interactor_B,
					$experimental_role_interactor_A, $experimental_role_interactor_B, $type_interactor_A, $type_interactor_B, $xref_interactor_A,
					$xref_interactor_B, $interaction_xref, $annotation_interactor_A, $annotation_interactor_B, $interaction_annotation, $host_organism,
					$interaction_parameter, $creation_date, $update_date, $checksum_interactor_A, $checksum_interactor_B, $interaction_checksum,
					$negative, $feature_interactor_A, $feature_interactor_B, $stoichiometry_interactor_A, $stoichiometry_interactor_B, 
					$identification_method_participant_A, $identification_method_participant_B) = $data;
			
			$interactor_A_id_array = explode(":", $interactor_A_id);
				
			$identifier_naming_convention_interactor_A_id = $interactor_A_id_array[0];
			$identifier_identifier_interactor_A_id = $interactor_A_id_array[1];
			
			
			
			/*
			
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery(
					"SELECT i
					 FROM AppBundle:Identifier i
					 WHERE i.identifier = :identifier
					 AND i.naming_convention = :naming_convention"
					);
			$query->setParameter('identifier', $identifier_identifier_interactor_A_id);
			$query->setParameter('naming_convention', $identifier_identifier_interactor_A_id);
			$identifier_A_results = $query->getResult();
			
			
			$identifier_A = new Identifier();
			$protein_A = new Protein();
				
				
				
			if(!$identifier_A_results){
				
				if($identifier_naming_convention_interactor_A_id == 'uniprotkb'){
					
					$uniprot_accession = $identifier_identifier_interactor_A_id;
					$url = "http://www.uniprot.org/uniprot/$uniprot_accession.xml";

					$crawler = new Crawler();
					$crawler->addXmlContent(file_get_contents($url));
										
					$name = $crawler->filter('default|uniprot entry name')->text();
					$sequence = $crawler->filter('default|uniprot entry sequence')->text();
					$gene_name = $crawler->filter('default|uniprot entry gene name')->text();
					$description = $crawler->filter('default|uniprot entry comment[type="function"] ')->text();
					
					
					$protein_A->setName($name);
					$protein_A->setName($gene_name);
					$protein_A->setName($sequence);
					$protein_A->setName($description);


				}

				
				$identifier_A->setProtein($protein_A);	
				$identifier_A->setIdentifier($identifier_identifier_interactor_A_id);
				$identifier_A->setNamingConvention($identifier_naming_convention_interactor_A_id);
				
				$em->persist($protein_A);
				$em->persist($identifier_A);

											
			}			
		}
		$em->flush();
		return $this->render('data_manager.html.twig', array(

		));
*/
		}	
	}
	
	
	
	
	

	public function getUniprotXML(String $uniprot_accession_number)
	{							
		$crawler = new Crawler();
		$crawler->addXmlContent(file_get_contents("http://www.uniprot.org/uniprot/$uniprot_accession_number.xml"));
		return 	$crawler;
			
	}						
								
	public function addProtein(String $interactor)
	{
		$interactor_array = explode(":", $interactor);
		
		$naming_convention_interactor = $interactor_array[0];
		$identifier_interactor = $interactor_array[1];
		
		$query = $em->createQuery(
				"SELECT *
				 FROM AppBundle:Identifier i
				 WHERE i.identifier = :identifier
				 AND i.naming_convention = :naming_convention"
				);
		$query->setParameter('identifier', $identifier_interactor);
		$query->setParameter('naming_convention', $naming_convention_interactor);
		$identifier_results = $query->getResult();
					
		$identifier = new Identifier();
		$protein = new Protein();
		
		if(!$identifier_results){
			
			if($naming_convention_interactor == 'uniprotkb'){
				
				$uniprot_accession = $identifier_interactor;
					
				$crawler = getUniprotXML($uniprot_accession);
				
				$name = $crawler->filter('default|uniprot entry name')->text();
				$sequence = $crawler->filter('default|uniprot entry sequence')->text();
				$gene_name = $crawler->filter('default|uniprot entry gene name')->text();
				$description = $crawler->filter('default|uniprot entry comment[type="function"] ')->text();
				
				
				$protein->setName($name);
				$protein->setName($gene_name);
				$protein->setName($sequence);
				$protein->setName($description);

			}

			
			$identifier->setProtein($protein);	
			$identifier->setIdentifier($identifier_interactor);
			$identifier->setNamingConvention($naming_convention_interactor);
			$em = $this->getDoctrine()->getManager();
			$em->persist($protein);
			$em->persist($identifier);
			$em->flush();
										
		}
	
	}							
}

?>
