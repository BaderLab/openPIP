<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Identifier;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use AppBundle\Entity\Interaction_Category;
use AppBundle\Utils\Functions;
use AppBundle\Entity\Annotation_Type;
/**
 * Search controller.

 */
class SearchOldController extends Controller
{
	/**
	 * Search Home
	 *
	 * @Route("/search_old", name="search")
	 * @Route("/admin/search_old/", name="admin_search")
	 * @Method({"GET", "POST"})
	 */
	public function searchAction(Request $request)
	{
		$functions = $this->get('app.functions');
		$form = self::getSearchForm();
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			$option_array = self::getSearchFormData($form);			
			return $this->redirectToRoute('search_results', $option_array);
		}

		$annotation_types = self::getAnnotationTypes();
		$annotation_field_array = self::getAnnotationFieldArray($annotation_types);
		$annotation_form_array = self::getAnnotationFormArray($annotation_types);

		$interaction_categories_array = self::getInteractionCategories();
		$admin_settings =  $functions->getAdminSettings();	
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
		$header_color_scheme = $admin_settings->getHeaderColorScheme();
		$logo_color_scheme = $admin_settings->getLogoColorScheme();
		$button_color_scheme = $admin_settings->getButtonColorScheme();
		$login_status = $functions->getLoginStatus();
		$admin_status = $functions->GetAdminStatus();
		
		$example_1 = $admin_settings->getExample1();
		$example_2 = $admin_settings->getExample2();
		$example_3 = $admin_settings->getExample3();
		$url = $admin_settings->getUrl();
		
		return $this->render('search.html.twig', array(
				'form' => $form->createView(),
				'main_color_scheme' => $main_color_scheme,
				'header_color_scheme' => $header_color_scheme,
				'logo_color_scheme' => $logo_color_scheme,
				'button_color_scheme' => $button_color_scheme,
				'interaction_categories_array' => $interaction_categories_array,
				'annotation_types' => $annotation_types,
				'annotation_field_array' => $annotation_field_array,
				'annotation_form_array' => $annotation_form_array,
				'short_title' => $short_title,
				'title' => $title,
				'footer' => $footer,
				'login_status' => $login_status,
				'example_1' => $example_1,
				'example_2' => $example_2,
				'example_3' => $example_3,
				'admin_status' => $admin_status,
				'url' => $url,
				'page' => 'search'
				
		));
		
	}
	
	public function getSearchFormData($form){
		
		$form_data_array = self::getFormData($form);	
		$search_query = $form_data_array['search_query'];
		$min_interaction_score = $form_data_array['min_interaction_score'];
		$text_output= $form_data_array['text_output'];
		$category_array = $form_data_array['category_array'];
		$query_query = $form_data_array['query_query'];
		$query_interactor = $form_data_array['query_interactor'];
		$annotation_parameter_array = $form_data_array['annotation_parameter_array'];
		$min_interaction_score = $form_data_array['min_interaction_score'];
		$search_query = self::getSearchQuery($search_query);
	
		$option_array = self::getOptionArray($search_query, $text_output, $query_query, $query_interactor, $min_interaction_score, $category_array, $annotation_parameter_array);

		return $option_array;
	}

	
	public function getSearchForm(){
		
		$form = $this->createForm('AppBundle\Form\SearchType');
		$interaction_categories_array = self::getInteractionCategories();
		$annotation_types = self::getAnnotationTypes();
		
		foreach($annotation_types as $annotation_type){
			$field_array_json = $annotation_type->getFields();
			$field_array_json = str_replace("'","\"",$field_array_json);	
			$type = $annotation_type->getType();
			$show_in_filter = $annotation_type->getShowInFilter();
			if($show_in_filter == 1){
				
				$field_array = json_decode($field_array_json, true);
				
				foreach($field_array as $field_name => $field){
					$form ->add($field, CheckboxType::class, array(
							'label' => $field_name,
							'required' => false,
							'mapped' => false,
							'attr' => array('value' => $field)));
				}
			}	
		}
		
		foreach($interaction_categories_array as $interaction_category){
			$category_name = $interaction_category[0]->getCategoryName();
			$category_name = strtolower($category_name);	
			$form ->add($category_name, CheckboxType::class, array(
					'required' => false,
					'attr' => array('value' => $category_name, 'checked' => 'checked')));
		}
		
		$form ->add('text_output', CheckboxType::class, array(
				'label' => 'Text Ouptput',
				'required' => false,
				'mapped' => false,));
		
		return $form;
		
	}
	
	public function getFormData($form){
		$search_query = $form["identifier"]->getData();
		$min_interaction_score = $form["min_interaction_score"]->getData();
		$text_output = $form["text_output"]->getData();
		
		$interaction_categories = $this->getDoctrine()
		->getRepository('AppBundle:Interaction_category')
		->findAll();
		$category_array = array();
		
		foreach ($interaction_categories as $interaction_category){
			
			$category_name = $interaction_category->getCategoryName();
			$category_name = strtolower($category_name);
			$category = $form["$category_name"]->getData();
			$category_array[$category_name] = $category;
		}
		
		$query_query = $form["query_query"]->getData();
		$query_interactor = $form["query_interactor"]->getData();
		$annotation_types = self::getAnnotationTypes();
		$annotation_field_array = self::getAnnotationFieldArray($annotation_types);
		
		$annotation_parameter_array = array();
		
		foreach($annotation_field_array as $type => $field_array){
			foreach($field_array as $field_name => $field){
				$field_value = $form["$field"]->getData();
				if($field_value == null || $field_value == 0){
					$annotation_parameter_array[$type][$field] = 0;
				}else{
					$annotation_parameter_array[$type][$field] = $field_value;
				}
			}
		}
		
		$form_data_array = array();
		$form_data_array['search_query'] = $search_query;
		$form_data_array['min_interaction_score'] = $min_interaction_score;
		$form_data_array['text_output'] = $text_output;
		$form_data_array['category_array'] = $category_array;
		$form_data_array['query_query'] = $query_query;
		$form_data_array['query_interactor'] = $query_interactor;
		$form_data_array['annotation_parameter_array'] = $annotation_parameter_array;
		
		return $form_data_array;
		
	}
	
	public function getSearchQuery($search_query){
		
		$pattern = '/[;,\s\t\n]/';
		$search_query_array = preg_split( $pattern, $search_query);
		$search_query_array = array_filter($search_query_array, function($value) { return $value !== ''; });
		$search_query = join(",",$search_query_array);
		
		return $search_query;
	}

	public function getOptionArray($search_query, $text_output, $query_query, $query_interactor, $min_interaction_score, $category_array, $annotation_parameter_array){
	
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
		foreach ($annotation_parameter_array as $annotation_parameter){		
			foreach($annotation_parameter as $name => $value){
				if($value){
					$option_array["$name"] = $value;
				}
			}
		}

		return $option_array;
	}
	
	public function getAnnotationFieldArray($annotation_types){

		$annotation_field_array = array();

		foreach($annotation_types as $annotation_type){
			$type = $annotation_type->getType();
			$show_in_filter = $annotation_type->getShowInFilter();
			
			if($show_in_filter == '1'){
	
				$field_array_json = $annotation_type->getFields();				
				$field_array_json = str_replace("'","\"",$field_array_json);	
				$field_array = json_decode($field_array_json, true);
				$annotation_field_array[$type] = $field_array;		
			}
		}
		return $annotation_field_array;
	}

	
	public function getAnnotationFormArray($annotation_types){
		
		$annotation_field_array = array();
		
		foreach($annotation_types as $annotation_type){
			$label= $annotation_type->getLabel();

			$show_in_filter = $annotation_type->getShowInFilter();
			$description = $annotation_type->getDescription();
			
			if($show_in_filter == '1'){
				
				$field_array_json = $annotation_type->getFields();
				$field_array_json = str_replace("'","\"",$field_array_json);
				$field_array = json_decode($field_array_json, true);
				$annotation_field_array[] = array($label, $description, $field_array);
			}
		}
		return $annotation_field_array;
	}
	
	
	public function getAnnotationTypes(){

		$annotation_types = $this->getDoctrine()
		->getRepository('AppBundle:Annotation_Type')
		->findAll();
		
		return $annotation_types;
		
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
			$selected_by_default = $interaction_category->getSelectedByDefault();
			$interaction_categories_array[$interaction_category_order] = array($interaction_category, $category_name, $selected_by_default);	
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
	
	public function handleForm($form){
		if ($form->isSubmitted()) {
			$option_array = self::getSearchFormData($form);
			return $this->redirectToRoute('search_results', $option_array);
		}
	}
	
}


















?>	