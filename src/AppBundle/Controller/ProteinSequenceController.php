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
//use AppBundle\Entity\Interaction_Network;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\ChoiceList\ArrayChoiceList;
use AppBundle\Entity\Dataset_Request;
use AppBundle\Utils\Node;
use AppBundle\Utils\Edge;
use AppBundle\Utils\QueryParameters;
use AppBundle\Utils\PublicationStatus;
use AppBundle\Utils\Functions;
use AppBundle\Entity\Interaction_Category;
use AppBundle\Entity\Interaction_Network;
use AppBundle\Entity\Experiment;

/**
 * Protein Sequence Controller
 */
class ProteinSequenceController extends Controller
{

	/**
	 * Protein Sequence
	 * @Route("/protein_sequence/{search_term}", name="protein_sequence", options={"expose": true}))
	 * @Method({"GET", "POST"})
	 */
	public function ProteinSequenceAction($search_term)
	{
		
		
		$term_array = split(',', $search_term);
		
		$protein_array = [];
		
		foreach($term_array as $term){
			
			$identifier_repository = $this->getDoctrine()
			->getRepository('AppBundle:Identifier');
			
			$identifier = $identifier_repository->findOneByIdentifier($term);
			$identifier_identifier = $identifier->getIdentifier();
			$identifier_naming_convention = $identifier->getNamingConvention();
			$proteins = $identifier->getProteins();
			
			if($proteins){
				$protein_array [] = $proteins;
			}
		}
		
		
		/*
		 $protein_gene_name = $protein->getGeneName();
		 $protein_id = $protein->getId();
		 $protein_name = $protein->getUniprotId();
		 $protein_sequence = $protein->getSequence();
		 $protein_description = $protein->getDescription();
		 */
		
		$admin_settings = self::getAdminSettings();
		
		$main_color_scheme = $admin_settings->getMainColorScheme();
		$header_color_scheme = $admin_settings->getHeaderColorScheme();
		$logo_color_scheme = $admin_settings->getLogoColorScheme();
		$button_color_scheme = $admin_settings->getButtonColorScheme();
		$short_title = $admin_settings->getShortTitle();
		$title = $admin_settings->getTitle();
		$footer = $admin_settings->getFooter();
		
		$login_status = self::checkLoginStatus();
		$admin_status = self::checkAdminStatus();
		
		return $this->render('protein_sequence.html.twig', array(
				'protein_array' => $protein_array,
				'main_color_scheme' => $main_color_scheme,
				'header_color_scheme' => $header_color_scheme,
				'logo_color_scheme' => $logo_color_scheme,
				'button_color_scheme' => $button_color_scheme,
				'short_title' => $short_title,
				'title' => $title,
				'footer' => $footer,
				'login_status' => $login_status,
				'admin_status' => $admin_status
				
		));
	}
	
	
	public function checkLoginStatus(){
		$login_status = false;
		$is_fully_authenticated = $this->get('security.context')
		->isGranted('IS_AUTHENTICATED_FULLY');
		if($is_fully_authenticated){
			$login_status =  true;
		}
		return $login_status;
	}
	
	public function checkAdminStatus(){
		$admin_status = false;
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			$admin_status = true;
		}
		return $admin_status;
	}
	
	public function getAdminSettings(){
		
		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		return $admin_settings;
	}
}
?>	