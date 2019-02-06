<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * contact controller.
 */
class ContactController extends Controller {

    /**
     * contact
     *
     * @Route("/contact/", name="contact")
     * @Route("/admin/contact/", name="admin_contact")
     * @Method({"GET", "POST"})
     */
    public function contactAction(Request $request) {
        $admin_settings = $this->getDoctrine ()->getRepository ( 'AppBundle:Admin_Settings' )->find ( 1 );
         

        $contact = $admin_settings->getContact();
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
        
        $admin_status = false;
        
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        	$admin_status = true;
        }
        
        return $this->render('contact.html.twig', array(
                'contact' => $contact,
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
                'short_title' => $short_title,
		        'title' => $title,
		        'footer' => $footer,
        		'login_status' => $login_status,
        		'admin_status' => $admin_status,
        		'page' => 'contact'
        ));
    }
}
?>