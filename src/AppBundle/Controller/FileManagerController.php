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
class FileManagerController extends Controller
{


	
	/**
	 * Lists all Announcement entities.
	 *
	 * @Route("/admin/file_manager/{upload_directory}", name="file_manager")
	 * 
	 */
	public function uploadAction($upload_directory)
	{
		/*
		Request $request
	    $file = new File();
	    $form = $this->createFormBuilder($file)
	    
	        -> add('file', FileType::class, array('attr' => array('name' => 'files[]', 'multiple' => true, 'webkitdirectory' => '')))

	        ->getForm();
	
	    $form->handleRequest($request);
	
	    if ($form->isValid()) {
	        $em = $this->getDoctrine()->getManager();
	        $file->upload();
	        $em->persist($file);
	        $em->flush();
	
	        return $this->redirectToRoute('file_manager');
	    }
	    
	    
*/
		
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
	    
	    $color_scheme = $admin_settings->getColorScheme();
	    $short_title = $admin_settings->getShortTitle();
	    return $this->render('admin_file_manager.html.twig', array(
	    		'upload_directory' => $upload_directory,
				'directories' => $directories,
                'color_scheme' => $color_scheme,
		        'short_title' => $short_title
		));
		
	}
}

?>