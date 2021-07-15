<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Upload_Files;
use AppBundle\Form\Upload_FilesType;
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
	public function uploadAction($upload_directory, Request $request)
	{

		$product = new Upload_Files();
        $form = $this->createForm(Upload_FilesType::class, $product);
        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $product->getBrochure();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }	

		$product->setBrochure($fileName);

		return $this->redirect($this->generateUrl('faq'));
        }

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

		function listfiles($dir) {
	    	static $alldirs = array();
	    	$dirs = glob($dir . '/*');
	    	if (count($dirs) > 0) {
	    		foreach ($dirs as $d){
	    			$subject = $d;
	    			$pattern = '/[^\/]*$/';
	    			$matches = array();
	    			preg_match($pattern, $subject, $matches);
	    			$name = $matches[0];
	    			$alldirs[] = $name;
	    			// $alldirs[] = $subject;
	    		}
	    	}
			dump($alldirs);
	    	return $alldirs;
	    }

		
		$files_folder='../web/uploads/'.$upload_directory;
	    
	    $directories = listdirs('../web/uploads');
		$files_in_directories= listfiles($files_folder);

		

	    $admin_settings = $this->getDoctrine()
	    ->getRepository('AppBundle:Admin_Settings')
	    ->find(1);
	    
	    $footer = $admin_settings->getFooter();
	    $main_color_scheme = $admin_settings->getMainColorScheme();
        $header_color_scheme = $admin_settings->getHeaderColorScheme();
        $logo_color_scheme = $admin_settings->getLogoColorScheme();
        $button_color_scheme = $admin_settings->getButtonColorScheme();
	    $short_title = $admin_settings->getShortTitle();
	    $title = $admin_settings->getTitle();
	    
	    // 

	    return $this->render('file_manager_test.html.twig', array(
				'uploaded_files' => $files_in_directories,
				'upload_directory' => $upload_directory,
				'directories' => $directories,
	            'footer' => $footer,
                'main_color_scheme' => $main_color_scheme,
                'header_color_scheme' => $header_color_scheme,
                'logo_color_scheme' => $logo_color_scheme,
                'button_color_scheme' => $button_color_scheme,
		        'short_title' => $short_title,
		        'title' => $title,
				'form' => $form->createView(),
		));
		
	}

	private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}

?>
