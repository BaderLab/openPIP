<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * File controller.
 *
 * 
 */
class FileController extends Controller
{

	/**
	 * Lists all Announcement entities.
	 *
	 * @Route("/admin/file_manager/{upload_directory}", name="file_manager")
	 * 
	 */
	public function uploadAction($upload_directory)
	{

	    function listdirs($dir) {
	    	static $alldirs = array();
	    	$dirs = glob($dir . '/*', GLOB_ONLYDIR);
	    	if (count($dirs) > 0) {
	    		foreach ($dirs as $d){
	    			$subject = $d;
	    			$pattern = '/[^\/]*$/';
	    			$matches = array();
	    			preg_match($pattern, $subject, $matches);
	    			$name = $matches[0];
	    			$alldirs[] = $name;
	    		}
	    	}
	    	return $alldirs;
	    }
	    
	    $directories = listdirs('../web/uploads');
	    $admin_settings = $this->getDoctrine()
	    ->getRepository('AppBundle:Admin_Settings')
	    ->find(1);
	    
	    $main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
	    $short_title = $admin_settings->getShortTitle();
	    $title = $admin_settings->getTitle();
	    
	    
	    return $this->render('file_manager.html.twig', array(
	    		'upload_directory' => $upload_directory,
				'directories' => $directories,
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
		        'short_title' => $short_title,
		        'title' => $title
		));
		
	}
}

?>
