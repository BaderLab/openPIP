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

/**
 * Search controller.
 */
class DownloadController extends Controller
{
		
	/**
	 * Interactor Fasta
	 *
	 * @Route("/download/multi_fasta/{search_term}", name="multi_fasta", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function multi_fastaAction($search_term)
	{

		$request = $this->getRequest();
		
		$query_parameters_array = self::getQueryParameters($request);
		
		$search_query_array = explode(",", $search_term);
		
		$fasta_sequences = self::getSequencesFastaFormat($search_query_array, $query_parameters_array);

		$response = new Response();
		
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Disposition', 'attachment;filename= download_multi_fasta.fa');
		
		$response->setContent($fasta_sequences);
		
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
		
		$response = new Response();
		
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Disposition', 'attachment;filename= interactor_csv.csv');
		
		$response->setContent($search_term);
		
		return $response;
		
	}
	
	/**
	 * Interactor Csv
	 *
	 * @Route("/download/interactor_csv/{search_term}", name="interactor_csv", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function interactor_csvAction($search_term)
	{
		
		$request = $this->getRequest();
		
		$query_parameters_array = self::getQueryParameters($request);
		
		$search_query_array = explode(",", $search_term);
		
		$interactor_csv = self::getCsvInteractorData($search_query_array, $query_parameters_array);
		
		$response = new Response();
		
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Disposition', 'attachment;filename= interactor_csv.csv');
		
		$response->setContent($interactor_csv);
		
		return $response;
		
	}
		
	/**
	 * Interaction Csv
	 *
	 * @Route("/download/interaction_csv/{search_term}", name="interaction_csv", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function interaction_csvAction($search_term)
	{
		
		$request = $this->getRequest();
		
		$query_parameters_array = self::getQueryParameters($request);
		
		$search_query_array = explode(",", $search_term);
		
		$csv = self::getInteractionsCsvFormat($search_query_array, $query_parameters_array);
		
		$response = new Response();
		
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Disposition', 'attachment;filename=' . 'interactions_csv.csv');
		
		$response->setContent($csv);
		
		return $response;
	}
	
	
	/**
	 * Interaction PSI-MITAB
	 *
	 * @Route("/download/psi_mitab/{search_term}", name="psi_mitab", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function psi_mitabAction($search_term)
	{
			
		$request = $this->getRequest();
		
		$query_parameters_array = self::getQueryParameters($request);
		
		$search_query_array = explode(",", $search_term);
			
		$psi_mitab = self::getPsiMitabData($search_query_array, $query_parameters_array);

		$response = new Response();
		
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Disposition', 'attachment;filename=' . 'psi_mitab.tab');
		
		$response->setContent($psi_mitab);
		
		return $response;
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
		$query_interactor_id_array = array();
		$interactor_array = array();
		
		foreach($query_protein_array as  $query_protein){
			
			$protein_id =  $query_protein->getId();
			
			$query_interactor_id_array[] = $protein_id;
			
			$interaction_data = $this->get('app.interaction_data');
			
			$interactions = $interaction_data->getInteractionsInListWithParameters($query_interactor_id_array, $status_array);
			
			if($interactions){
				
				foreach($interactions as $interaction){
					
					$interactor_A_id = $interaction['interactor_A'];
					$interactor_B_id = $interaction['interactor_B'];
					
					$interactor_array[] = $interactor_A_id;
					$interactor_array[] = $interactor_B_id;
					
				}
			}
		}
		
		$interactor_array = array_unique($interactor_array);
		$interactor_array = array_values($interactor_array);

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
		$query_interactor_id_array = array();
		$interactor_array = array();
		
		foreach($query_protein_array as  $query_protein){
			
			$protein_id =  $query_protein->getId();
			
			$query_interactor_id_array[] = $protein_id;
			
			$interaction_data = $this->get('app.interaction_data');
			
			$interactions = $interaction_data->getInteractionsInListWithParameters($query_interactor_id_array, $status_array);
			
			if($interactions){
				
				foreach($interactions as $interaction){
					
					$interactor_A_id = $interaction['interactor_A'];
					$interactor_B_id = $interaction['interactor_B'];
					
					$interactor_array[] = $interactor_A_id;
					$interactor_array[] = $interactor_B_id;
					
				}
			}
		}
		
		$interactor_array = array_unique($interactor_array);
		$interactor_array = array_values($interactor_array);

		foreach($interactor_array as $interactor_id){
			
			$intoractor = $this->getDoctrine()
			->getRepository('AppBundle:Protein')
			->find($interactor_id);

			$protein_gene_name =  $intoractor->getGeneName();
			
			$csv .= "$protein_gene_name, ";

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
				$csv_array = self::getInteractorInteractorInteractionsCsvFormat($query_protein_array, $query_parameters_array);
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
			$protein_A_name = $intoractor_A->getName();
			
			$protein_B_gene_name = $intoractor_B->getGeneName();
			$protein_B_name = $intoractor_B->getName();
			
			$csv[] = "$protein_A_name,$protein_B_name,$protein_A_gene_name,$protein_B_gene_name\r\n";
		}
		
		return $csv;
	}
	
	public function getInteractionsWithInteractorInteractorFilterAndCsvFormat($query_protein_array, $query_parameters_array){
		
		$csv = array();
		
		$query_interactor_id_array = array();
		
		$published_parameter = $query_parameters_array[0];
		$validated_parameter = $query_parameters_array[1];
		$verified_parameter = $query_parameters_array[2];
		$literature_parameter = $query_parameters_array[3];
		$score_parameter = $query_parameters_array[5];
		
		$status_array = array($published_parameter, $validated_parameter, $verified_parameter, $literature_parameter, $score_parameter);
		
		foreach($query_protein_array as  $query_protein){
			
			$interactions = self::getInteractions($query_protein, $status_array);
			
			if($interactions){
				
				foreach($interactions as $interaction){
					
					$interactor_A = $interaction->getInteractorA();
					$interactor_B = $interaction->getInteractorB();
					
					$interactor_A_id = $interactor_A->getId();
					$interactor_B_id = $interactor_B->getId();
					
					$query_interactor_id_array[] = $interactor_A_id;
					$query_interactor_id_array[] = $interactor_B_id;
					
				}
			}
		}
		
		$query_interactor_id_array= array_unique($query_interactor_id_array);
		
		$query_interactor_id_array= array_values($query_interactor_id_array);

		$interaction_data = $this->get('app.interaction_data');
		
		$interactions = $interaction_data->getInteractionsInListWithParameters($query_interactor_id_array, $status_array);
		
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
				$protein_A_name = $intoractor_A->getName();
				
				$protein_B_gene_name = $intoractor_B->getGeneName();
				$protein_B_name = $intoractor_B->getName();
				
				$csv[] = "$protein_A_name,$protein_B_name,$protein_A_gene_name,$protein_B_gene_name\r\n";
			}
			
		}
				
		return $csv;
	}
	
	
	public function getInteractionsPsiMiTabFormat($search_query_array, $query_parameters_array){
		
		$query_protein_array = self::getProteinQueryArray($search_query_array);
		$psi_mitab = null;
		$psi_mitab_array = array();
		
		$filter_parameter = $query_parameters_array[4];
		
		switch ($filter_parameter) {
			
			case 'query_query':
				$psi_mitab_array = self::getInteractionsWithQueryQueryFilterAndPsiMiTabFormat($query_protein_array, $query_parameters_array);
				break;
				
			case 'None':
				$psi_mitab_array = self::getInteractorInteractorInteractionsPsiMiTabFormat($query_protein_array, $query_parameters_array);
				break;
				
			default:
				
		}
		
		$psi_mitab_array = array_unique($psi_mitab_array);
		$psi_mitab_array = array_values($psi_mitab_array);
		
		$psi_mitab = "ID(s) interactor A\tID(s) interactor B\tAlt. ID(s) interactor A\tAlt. ID(s)interactor B\tAlias(es) interactor A\tAlias(es) interactor B\tInteraction detection method(s)\tPublication 1st author(s)\tPublication Identifier(s)\tTaxid interactor A\tTaxid interactor B\tInteraction type(s)\tSource database(s)\tInteraction identifier(s)\tConfidence value(s)\tExpansion method(s)\tBiological role(s)interactor A\tBiological role(s) interactor B\tExperimental role(s) interactor A\tExperimental role(s) interactor B\tType(s) interactor A\tType(s) interactor B\tXref(s) interactor A\tXref(s) interactor B\tInteraction Xref(s)\tAnnotation(s) interactor A\tAnnotation(s) interactor B\tInteraction annotation(s)\tHost organism(s)\tInteraction parameter(s)\tCreation date\tUpdate date\tChecksum(s) interactor A\tChecksum(s) interactor B\tInteraction Checksum(s)	Negative\tFeature(s) interactor A\tFeature(s) interactor B\tStoichiometry(s) interactor A\tStoichiometry(s) interactor B\tIdentification method participant A\tIdentification method participant B\r\n";
		
		foreach($psi_mitab_array as $psi_mitab_line){
			
			$psi_mitab .= $psi_mitab_line;
		}
		
		return $psi_mitab;
		
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
			$protein_A_name = $intoractor_A->getName();
			
			$protein_B_gene_name = $intoractor_B->getGeneName();
			$protein_B_name = $intoractor_B->getName();
			
			$psi_mitab_array[] = "$protein_A_name\t$protein_B_name\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
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
				
				$intoractor_A = $this->getDoctrine()
				->getRepository('AppBundle:Protein')
				->find($interactor_A_id);
				
				$intoractor_B = $this->getDoctrine()
				->getRepository('AppBundle:Protein')
				->find($interactor_B_id);
				
				$protein_A_gene_name = $intoractor_A->getGeneName();
				$protein_A_name = $intoractor_A->getName();
				
				$protein_B_gene_name = $intoractor_B->getGeneName();
				$protein_B_name = $intoractor_B->getName();
				
				$psi_mitab_array[] = "$protein_A_name\t$protein_B_name\t-\t-\t$protein_A_gene_name\t$protein_B_gene_name\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
				
			}
			
		}
		
		
		return $psi_mitab_array;
	}






}

?>