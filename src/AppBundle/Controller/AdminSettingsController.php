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
use AppBundle\Entity\Admin_Settings;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Interaction_Category;
use AppBundle\Form\Interaction_CategoryType;
/**
 * Admin Settings Controller
 */
class AdminSettingsController extends Controller
{
    /**
     * Admin Settings
     *
     * @Route("/admin/settings/", name="admin_settings")
     * @Method({"GET", "POST"})
     */
    public function adminSettingsAction(Request $request)
    {
        $admin_settings = $this->getDoctrine()
        ->getRepository('AppBundle:Admin_Settings')
        ->find(1);

        $title = $admin_settings->getTitle();
        $url = $admin_settings->getUrl();
        $home_page = $admin_settings->getHomePage();
        $about = $admin_settings->getAbout();
        $faq = $admin_settings->getFaq();
        $contact = $admin_settings->getContact();
        $download = $admin_settings->getDownload();
        $footer = $admin_settings->getFooter();
        $show_downloads = $admin_settings->getShowDownloads();
        $show_download_all = $admin_settings->getShowDownloadAll();
        $main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
        $short_title = $admin_settings->getShortTitle();
        $query_node_color = $admin_settings->getQueryNodeColor();
        $interactor_node_color = $admin_settings->getInteractorNodeColor();
        /*
        $published_edge_color = $admin_settings->getPublishedEdgeColor();
        $validated_edge_color = $admin_settings->getValidatedEdgeColor();
        $verified_edge_color = $admin_settings->getVerifiedEdgeColor();
        $literature_edge_color = $admin_settings->getLiteratureEdgeColor();
        */
        
        $interaction_categories_array = array();
        
        $interaction_categories = $this->getDoctrine()
        ->getRepository('AppBundle:Interaction_Category')
        ->findAll();
        
        
        
        foreach ($interaction_categories as $interaction_category){
        	
        	$interaction_category_order = $interaction_category->getOrder();
        	$category_name = $interaction_category->getcategoryName();
        	$category_name_edge_color = $category_name . '_edge_color';
        	
        	$interaction_categories_array[$interaction_category_order] = array($interaction_category, $category_name_edge_color);
        	
        	
        }
        
        ksort($interaction_categories_array);
        
        $interaction_categories_array = array_values($interaction_categories_array);

        
        
        
        
        $form = $this->createForm('AppBundle\Form\Admin_SettingsType', $admin_settings);
        
        

        
        
        
        $form->add('submit', SubmitType::class, array(
                'label' => 'Update',
                'attr'  => array('class' => 'btn btn-success')
        ));
        
        if ( $show_downloads == true){
        $form->add('show_downloads', CheckboxType::class, array(
                'label' => 'Show Dataset Downloads',
                'required' => false,
                'attr' => array('value' => 'true', 'checked' => 'checked')));
        }else{
            $form->add('show_downloads', CheckboxType::class, array(
                    'label' => 'Show Dataset Downloads',
                    'required' => false,
                    'attr' => array('value' => 'true')));
        }
        
        if ( $show_download_all == true){
        $form->add('show_download_all', CheckboxType::class, array(
                'label' => 'Show Download All Datasets',
                'required' => false,
                'attr' => array('value' => 'true', 'checked' => 'checked')));
        }else{
            $form->add('show_download_all', CheckboxType::class, array(
                    'label' => 'Show Download All Datasets',
                    'required' => false,
                    'attr' => array('value' => 'true')));            
            
            
        }
        
        
        
        
        $form->handleRequest($request);
        
        $updated = false;
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $admin_settings = $form->getData();
            $title = $admin_settings->getTitle();
            $url =  $admin_settings->getUrl();
            $home_page = $admin_settings->getHomePage();
            $about = $admin_settings->getAbout();
            $faq = $admin_settings->getFaq();
            $contact = $admin_settings->getContact();
            $download = $admin_settings->getDownload();
            $main_color_scheme = $admin_settings->getMainColorScheme();
            $header_color_scheme = $admin_settings->getHeaderColorScheme();
            $logo_color_scheme = $admin_settings->getLogoColorScheme();
            $button_color_scheme = $admin_settings->getButtonColorScheme();
            $query_node_color = $admin_settings->getQueryNodeColor();
            $interactor_node_color = $admin_settings->getInteractorNodeColor();
            
            /*
            $published_edge_color = $admin_settings->getPublishedEdgeColor();
            $validated_edge_color = $admin_settings->getValidatedEdgeColor();
            $verified_edge_color = $admin_settings->getVerifiedEdgeColor();
            $literature_edge_color = $admin_settings->getLiteratureEdgeColor();
            */
            
            
            $em->persist($admin_settings);
            $em->flush();
            
            
            
            
            
            
            $updated = true;
        }

        return $this->render('admin_settings_2.html.twig', array(
                'form' => $form->createView(),
                'title' => $title,
                'home_page' => $home_page,
                'about' => $about,
        		'faq' => $faq,
                'contact' => $contact,
                'download' => $download,
                'footer' => $footer,
                'show_downloads' => $show_downloads,
                'show_download_all' => $show_download_all,
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
                'query_node_color' => $query_node_color,
        		'interactor_node_color' => $interactor_node_color,
        		'url' => $url,
        		'interaction_categories_array' => $interaction_categories_array,
                'short_title' => $short_title,
                'updated' => $updated

        ));
    }

}
?>