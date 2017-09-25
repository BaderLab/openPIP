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
 * Search controller.

 */
class SearchController extends Controller
{
	/**
	 * Search Home
	 *
	 * @Route("/search", name="search")
	 * @Route("/admin/search/", name="admin_search")
	 * @Method({"GET", "POST"})
	 */
	public function searchAction(Request $request)
	{
	
		$tissue_array = self::defineTissueArray();
		$subcellular_location_array = self::defineSubcellularLocationArray();
		$interaction_categories_array = self::getInteractionCategories();
		
		$form = self::getSearchForm($tissue_array, $subcellular_location_array, $interaction_categories_array);
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			$option_array = self::getSearchFormData($form);
			return $this->redirectToRoute('search_results', $option_array);
		}
		
		$admin_settings = self::getAdminSettings();
		
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
		$header_color_scheme = $admin_settings->getHeaderColorScheme();
		$logo_color_scheme = $admin_settings->getLogoColorScheme();
		$button_color_scheme = $admin_settings->getButtonColorScheme();
		$example_1 = $admin_settings->getExample1();
		$example_2 = $admin_settings->getExample2();
		$example_3 = $admin_settings->getExample3();
		$url = $admin_settings->getUrl();
		
		$login_status = self::checkLoginStatus();
		$admin_status = self::checkAdminStatus();
		
		return $this->render('search.html.twig', array(
				'form' => $form->createView(),
				'tissue_array' => $tissue_array,
				'subcellular_location_array' => $subcellular_location_array,
				'main_color_scheme' => $main_color_scheme,
				'header_color_scheme' => $header_color_scheme,
				'logo_color_scheme' => $logo_color_scheme,
				'button_color_scheme' => $button_color_scheme,
				'interaction_categories_array' => $interaction_categories_array,
				'short_title' => $short_title,
				'title' => $title,
				'footer' => $footer,
				'login_status' => $login_status,
				'example_1' => $example_1,
				'example_2' => $example_2,
				'example_3' => $example_3,
				'admin_status' => $admin_status,
				'url' => $url
				
		));
		
	}
	
	public function getSearchFormData($form){
		
		$search_query = $form["identifier"]->getData();
		$min_interaction_score = $form["min_interaction_score"]->getData();
		$text_output = $form["text_output"]->getData();
		
		
		$form_data_array = array();
		$category_array = array();
		$tissue_parameter_array = array();
		$subcellular_location_parameter_array = array();
		
		
		
		$interaction_categories = $this->getDoctrine()
		->getRepository('AppBundle:Interaction_category')
		->findAll();
		
		foreach ($interaction_categories as $interaction_category){
			
			$category_name = $interaction_category->getCategoryName();
			
			$category_name = strtolower($category_name);
			
			$category = $form["$category_name"]->getData();
			
			
			$category_array[$category_name] = $category;
			
			
		}
		
		$tissue_array = array('adipose_subcutaneous', 'adipose_visceral_omentum', 'adrenal_gland', 'artery_aorta', 'artery_coronary', 'artery_tibial', 'brain_0', 'brain_1', 'brain_2', 'breast_mammary_tissue', 'colon_sigmoid', 'colon_transverse', 'esophagus_gastroesophageal_junction', 'esophagus_mucosa', 'esophagus_muscularis', 'heart_atrial_appendage', 'heart_left_ventricle', 'kidney_cortex', 'liver', 'lung', 'minor_salivary_gland', 'muscle_skeletal', 'nerve_tibial', 'ovary', 'pancreas', 'pituitary', 'prostate', 'skin', 'small_intestine_terminal_ileum', 'spleen', 'stomach', 'testis', 'thyroid', 'uterus', 'vagina', 'whole_blood');
		
		
		
		foreach($tissue_array as $tissue){
			
			$tissue_value = $form["$tissue"]->getData();
			
			if($tissue_value == null || $tissue_value == 0){
				$tissue_parameter_array[$tissue] = 0;
			}else{
				
				
				$tissue_parameter_array[$tissue] = $tissue_value;
				
			}
		}
		
		
		$subcellular_location_array = array('aggresome', 'cell_junctions', 'centrosome', 'cytokinetic_bridge', 'cytoplasmic_bodies', 'cytosol', 'endoplasmic_reticulum', 'endosomes', 'focal_adhesion_sites', 'golgi_apparatus', 'intermediate_filaments', 'lipid_droplets', 'lysosomes', 'microtubule_ends', 'microtubule_organizing_center', 'microtubules', 'midbody', 'midbody_ring', 'mitochondria', 'mitotic_spindle', 'nuclear_bodies', 'nuclear_membrane', 'nuclear_speckles', 'nucleoli', 'nucleoli_fibrillar_center', 'nucleoplasm', 'nucleus', 'peroxisomes', 'plasma_membrane', 'rods_and_rings', 'vesicles');
		
		foreach($subcellular_location_array as $subcellular_location ){
			
			$subcellular_location_value = $form["$subcellular_location"]->getData();
			$subcellular_location_parameter_array["$subcellular_location"] = $subcellular_location_value;
			
		}
		
		
		
		$query_query = $form["query_query"]->getData();
		$query_interactor = $form["query_interactor"]->getData();
		
		$form_data_array["category_array"] = $category_array;
		$form_data_array["tissue_parameter_array"] = $tissue_parameter_array;
		$form_data_array["query_query"] = $query_query;
		$form_data_array["query_interactor"] = $query_interactor;
		$form_data_array["min_interaction_score"] = $min_interaction_score;
		
		$pattern = '/[;,\s\t\n]/';
		$search_query_array = preg_split( $pattern, $search_query);
		$search_query_array = array_filter($search_query_array, function($value) { return $value !== ''; });
		$search_query = join(",",$search_query_array);
		
		
		$option_array = array('search_term' => $search_query);
		
		if($text_output){
			
			$option_array['output'] = 'text_output';
		}
		
		if($query_query){
			$option_array['filter'] = 'query_query';
		}
		
		if($query_interactor){
			$option_array['filter'] = 'query_interactor';
		}
		
		if($min_interaction_score){
			$option_array['score'] = $min_interaction_score;
		}
		
		foreach ($category_array as $key => $category){
			
			if(!$category){
				$option_array["$key"] = 'false';
			}
			
		}
		
		foreach ($tissue_parameter_array as $key => $tissue_value){
			
			if($tissue_value > 0){
				
				$option_array["$key"] = $tissue_value;
			}
			
		}
		
		foreach ($subcellular_location_parameter_array as $key => $subcellular_location_value){
			
			if($subcellular_location_value){
				
				$option_array["$key"] = 'true';
			}
			
		}

		return $option_array;
	}

	
	public function getSearchForm($tissue_array, $subcellular_location_array, $interaction_categories_array){
		$form = $this->createForm('AppBundle\Form\SearchType');
		
		foreach($interaction_categories_array as $interaction_category){
			$category_name = $interaction_category[0]->getCategoryName();
			$category_name = strtolower($category_name);	
			$form ->add($category_name, CheckboxType::class, array(
					'required' => false,
					'attr' => array('value' => $category_name, 'checked' => 'checked')));
		}
		
		foreach($tissue_array as $tissue_name => $tissue){
			$form ->add($tissue, CheckboxType::class, array(
					'label' => $tissue_name,
					'required' => false,
					'mapped' => false,
					'attr' => array('value' => $tissue)));
		}
		
		foreach($subcellular_location_array as $subcellular_location_name => $subcellular_location){
			$form ->add($subcellular_location, CheckboxType::class, array(
					'label' => $subcellular_location_name,
					'required' => false,
					'mapped' => false,
					'attr' => array('value' => $subcellular_location)));
		}
		
		$form ->add('text_output', CheckboxType::class, array(
				'label' => 'Text Ouptput',
				'required' => false,
				'mapped' => false,));
		
		return $form;
		
	}
	
	public function getInteractionCategories(){
		
		$interaction_categories_array = array();
		$interaction_categories = $this->getDoctrine()
		->getRepository('AppBundle:Interaction_Category')
		->findAll();
		foreach ($interaction_categories as $interaction_category){			
			$interaction_category_order = $interaction_category->getOrder();			
			$category_name = $interaction_category->getCategoryName();			
			$category_name = strtolower($category_name);
			$interaction_categories_array[$interaction_category_order] = array($interaction_category, $category_name);	
		}	
		ksort($interaction_categories_array);
		
		return $interaction_categories_array;
	}
	
	
	public function defineTissueArray(){
		
		$tissue_array = array('Adipose Subcutaneous' => 'adipose_subcutaneous', 'Adipose Visceral Omentum' => 'adipose_visceral_omentum', 'Adrenal Gland' => 'adrenal_gland', 'Artery Aorta' => 'artery_aorta', 'Artery Coronary' => 'artery_coronary', 'Artery Tibial' => 'artery_tibial',
				'Brain 0' => 'brain_0', 'Brain 1' => 'brain_1', 'Brain 2' => 'brain_2', 'Breast Mammary Tissue' => 'breast_mammary_tissue', 'Colon Sigmoid' => 'colon_sigmoid',
				'Colon Transverse' => 'colon_transverse', 'Esophagus Gastroesophageal Junction' => 'esophagus_gastroesophageal_junction', 'Esophagus Mucosa' => 'esophagus_mucosa',
				'Esophagus Muscularis' => 'esophagus_muscularis', 'Heart Atrial Appendage' => 'heart_atrial_appendage', 'Heart Left Ventricle' => 'heart_left_ventricle',
				'Kidney Cortex' => 'kidney_cortex', 'Liver' => 'liver', 'Lung' => 'lung', 'Minor Salivary Gland' => 'minor_salivary_gland', 'Muscle Skeletal' => 'muscle_skeletal',
				'Nerve Tibial' => 'nerve_tibial', 'Ovary' => 'ovary', 'Pancreas' => 'pancreas', 'Pituitary' => 'pituitary', 'Prostate' => 'prostate',  'Skin' => 'skin',
				'Small Intestine Terminal Ileum' => 'small_intestine_terminal_ileum', 'Spleen' => 'spleen', 'Stomach' => 'stomach',  'Testis' => 'testis',
				'Thyroid' => 'thyroid', 'Uterus' => 'uterus', 'Vagina' => 'vagina', 'Whole Blood' => 'whole_blood');
		
		return $tissue_array;
	}
	
	public function defineSubcellularLocationArray(){
		$subcellular_location_array = array('Aggresome' => 'aggresome', 'Cell Junctions' => 'cell_junctions', 'Centrosome' => 'centrosome',
				'Cytokinetic Bridge' => 'cytokinetic_bridge', 'Cytoplasmic Bodies' => 'cytoplasmic_bodies', 'Cytosol' => 'cytosol', 'Endoplasmic Reticulum' => 'endoplasmic_reticulum',
				'Endosomes' => 'endosomes', 'Focal Adhesion Sites' => 'focal_adhesion_sites', 'Golgi Apparatus' => 'golgi_apparatus', 'Intermediate Filaments' => 'intermediate_filaments',
				'Lipid_droplets' => 'lipid_droplets', 'Lysosomes' => 'lysosomes', 'Microtubule_ends' => 'microtubule_ends', 'Microtubule Organizing Center' => 'microtubule_organizing_center',
				'Microtubules' => 'microtubules', 'Midbody' => 'midbody', 'Midbody Ring' => 'midbody_ring', 'Mitochondria' => 'mitochondria', 'Mitotic Spindle' => 'mitotic_spindle',
				'Nuclear_Bodies' => 'nuclear_bodies', 'Nuclear Membrane' => 'nuclear_membrane', 'Nuclear Speckles' => 'nuclear_speckles', 'Nucleoli' => 'nucleoli',
				'Nucleoli Fibrillar Center' => 'nucleoli_fibrillar_center', 'Nucleoplasm' => 'nucleoplasm', 'Nucleus' => 'nucleus', 'Peroxisomes' => 'peroxisomes',
				'Plasma Membrane' => 'plasma_membrane', 'Rods and Rings' => 'rods_and_rings', 'Vesicles' => 'vesicles');
		
		return $subcellular_location_array;
		
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