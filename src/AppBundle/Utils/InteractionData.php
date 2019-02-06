<?php
// src/AppBundle/Utils/Function.php
namespace AppBundle\Utils;


use AppBundle\Entity\Interaction;

use AppBundle\Utils\PublicationStatus;
use AppBundle\Utils\Functions;
use Doctrine\ORM\EntityManager;


class InteractionData
{
	private $functions;
	private $em;
	
	
	public function __construct(EntityManager $em, Functions $functions, PublicationStatus $publication_status) { 
		
		$this->publication_status = $publication_status;
		$this->functions = $functions;
		$this->em = $em;
	}

	public function getInteractorsOfQueryArray($query_protein_array){
		
		$interactor_array = array();
		
		foreach($query_protein_array as  $query_protein){
			
			$interactions = self::getInteractionsMySQL($query_protein);

			if($interactions){
				foreach($interactions as $interaction){
					
					
					
					
					$interactor_array[] = $interaction['interactor_A'];
					$interactor_array[] = $interaction['interactor_B'];
					
				}
			}
		}
		
		$interactor_array = array_unique($interactor_array);
		$interactor_array = array_values($interactor_array);
		
		return $interactor_array;
		
	}
	
	
	public function getInteractionsAmongInteractorsOfQueryArray($interactor_array){
		
		$functions = $this->functions;
		
		
		$connection =  $functions->mysql_connect();
		
		
		
		
		
		
		
		
		$A_array = array();
		$B_array = array();
		
		foreach($interactor_array as $interactor_id){
			
			$A_array[] = "interactor_A = $interactor_id";
			$B_array[] = "interactor_B = $interactor_id";
		}
		
		$A = join(' OR ', $A_array);
		$B = join(' OR ', $B_array);
	
		$query = "SELECT * FROM `interaction` WHERE ($A) AND ($B)";
		
		$result = $connection->query($query);
		
		$interaction_array = array();
		
		if($result){
			while($row = $result->fetch_assoc()) {
				$interaction_array[] = $row;
			}
		}
		
		mysqli_close($connection);
		
		if($interaction_array){
			return $interaction_array;
		}else{
			return false;
		}
		
	}
	
	public function getInteractionsAmongInteractorsOfQueryArrayWithParameters($query_protein_array, $parameter_array){
		
		$published_parameter = $parameter_array[0];
		$validated_parameter = $parameter_array[1];
		$verified_parameter = $parameter_array[2];
		$literature_parameter = $parameter_array[3];
		$score = $parameter_array[4];
		
		$functions = $this->functions;
		
		$connection =  $functions->mysql_connect();
		
		$interactor_array = array();
		
		foreach($query_protein_array as  $query_protein){
			
			$interactions = self::getInteractionsMySQL($query_protein);
			
			if($interactions){
				foreach($interactions as $interaction){

					$interactor_array[] = $interaction['interactor_A'];
					$interactor_array[] = $interaction['interactor_B'];
					
				}
			}
		}
		
		$interactor_array = array_unique($interactor_array);
		$interactor_array = array_values($interactor_array);
		
		$A_array = array();
		$B_array = array();
		
		foreach($interactor_array as $interactor_id){
			
			$A_array[] = "interactor_A = $interactor_id";
			$B_array[] = "interactor_B = $interactor_id";
		}
		
		$A = join(' OR ', $A_array);
		$B = join(' OR ', $B_array);
		
		$query = "SELECT * FROM `interaction` WHERE ($A) AND ($B)";
		
		if($score){
			
			$query = $query + " AND score = $score";
			
		}
		
		$result = $connection->query($query);
		
		$interaction_array = array();
		
		if($result){
			while($row = $result->fetch_assoc()) {
				$interaction_array[] = $row;
			}
		}
		
		mysqli_close($connection);
		
		
		if($interaction_array){
			
			$output_interaction_array = array();
			
			foreach( $interaction_array as $interaction){
				
				$interaction_id = $interaction['id'];
				
				$publication_status = self::getPublicationStatus($interaction_id);
				
				$filter = false;
				
				if($published_parameter){
					
					$publication_status->getPublished();
					$filter = true;
				}
				
				if($validated_parameter){
					
					$publication_status->getValidated();
					$filter = true;
				}
				
				if($verified_parameter){
					
					$publication_status->getVerified();
					$filter = true;
				}
				
				if($literature_parameter){
					
					$publication_status->getLiterature();
					$filter = true;
				}
				
				if($filter){
				
					$output_interaction_array[] = $interaction;
				}
				
			}
			

			
			return $output_interaction_array;
			
		}else{
			return false;
		}
		
	}

	
	public function getPublicationStatus($interaction_id){
		

		$em = $this->em;
		
		$repository = $em->getRepository('AppBundle:Dataset');
		$query = $repository->createQueryBuilder('ds')
		->innerJoin('ds.interactions', 'i')
		->where('i.id = :interaction_id')
		->setParameter('interaction_id', $interaction_id )
		->getQuery();
		$dataset_result_array = $query->getResult();
		
		$publication_status = $this->publication_status;

		
		$i = 0;
		
		foreach($dataset_result_array as $dataset_result){
			
			$interaction_status = $dataset_result->getInteractionStatus();
			$t = 0;
			if($interaction_status == 'published'){
				$t = 4;
				$publication_status->setPublished(true);
			}elseif($interaction_status == 'validated'){
				$t = 3;
				$publication_status->setValidated(true);
			}elseif($interaction_status == 'verified'){
				$t = 2;
				$publication_status->setVerified(true);
			}elseif($interaction_status == 'literature'){
				$t = 1;
				$publication_status->setLiterature(true);
			}
			if ($t > $i){
				$highest_publication_status = $interaction_status;
				$i = $t;
			}
			
		}
		
		$publication_status->setHighestPublicationStatus($highest_publication_status);
		
		return $publication_status;
		
	}
	
	
	
	public function getInteractionsMySQL($query_protein){
		
		
		$functions = $this->functions;
		
		$connection =  $functions->mysql_connect();
		
		
		$interactor_id = $query_protein->getID();
		
		$query = "SELECT * FROM `interaction` WHERE interactor_A = $interactor_id OR interactor_B = $interactor_id";
		
		$result = $connection->query($query);
		
		$interaction_array = array();
		
		while($row = $result->fetch_assoc()) {
			$interaction_array[] = $row;
		}
		
		mysqli_close($connection);
		
		if($interaction_array){
			return $interaction_array;
		}else{
			return false;
		}
		
	}
	
	
	

}

?>