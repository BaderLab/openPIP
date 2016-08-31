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
         
        $title = $admin_settings->getTitle ();
        $about = $admin_settings->getAbout ();
        $color_scheme = $admin_settings->getColorScheme ();
        $short_title = $admin_settings->getShortTitle ();

        $login_status = false;
        
        $is_fully_authenticated = $this->get('security.context')
        ->isGranted('IS_AUTHENTICATED_FULLY');
        
        if($is_fully_authenticated){
            $login_status =  true;
        }
        return $this->render('about.html.twig', array(
                'about' => $about,
                'color_scheme' => $color_scheme,
                'short_title' => $short_title,
                'login_status' => $login_status
        ));
    }
}
?>