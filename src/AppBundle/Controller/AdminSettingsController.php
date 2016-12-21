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
        $home_page = $admin_settings->getHomePage();
        $about = $admin_settings->getAbout();
        $documentation = $admin_settings->getDocumentation();
        $download = $admin_settings->getDownload();
        $footer = $admin_settings->getFooter();
        $show_downloads = $admin_settings->getShowDownloads();
        $show_download_all = $admin_settings->getShowDownloadAll();
        $main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
        $short_title = $admin_settings->getShortTitle();

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
            $home_page = $admin_settings->getHomePage();
            $about = $admin_settings->getAbout();
            $documentation = $admin_settings->getDocumentation();
            $download = $admin_settings->getDownload();
            $main_color_scheme = $admin_settings->getMainColorScheme();
            $header_color_scheme = $admin_settings->getHeaderColorScheme();
            $logo_color_scheme = $admin_settings->getLogoColorScheme();
            $button_color_scheme = $admin_settings->getButtonColorScheme();
            $em->persist($admin_settings);
            $em->flush();
            $updated = true;
        }

        return $this->render('admin_settings.html.twig', array(
                'form' => $form->createView(),
                'title' => $title,
                'home_page' => $home_page,
                'about' => $about,
                'documentation' => $documentation,
                'download' => $download,
                'footer' => $footer,
                'show_downloads' => $show_downloads,
                'show_download_all' => $show_download_all,
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,                
                'short_title' => $short_title,
                'updated' => $updated

        ));
    }

}
?>