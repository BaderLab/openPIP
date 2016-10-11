<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * About controller.
 */
class AboutController extends Controller {

    /**
     * About
     *
     * @Route("/about/", name="about")
     * @Route("/admin/about/", name="admin_about")
     * @Method({"GET", "POST"})
     */
    public function aboutAction(Request $request) {
        $admin_settings = $this->getDoctrine ()->getRepository ( 'AppBundle:Admin_Settings' )->find ( 1 );
         

        $about = $admin_settings->getAbout ();
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();

        $login_status = false;
        
        $is_fully_authenticated = $this->get('security.context')
        ->isGranted('IS_AUTHENTICATED_FULLY');
        
        if($is_fully_authenticated){
            $login_status =  true;
        }
        return $this->render('about.html.twig', array(
                'about' => $about,
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
                'short_title' => $short_title,
		        'title' => $title,
		        'footer' => $footer,
                'login_status' => $login_status
        ));
    }
}
?>