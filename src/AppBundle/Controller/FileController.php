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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



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

		// $product = new Upload_Files();
        // $form = $this->createForm(Upload_FilesType::class, $product);
		// $defaultData = array('message' => 'Type your message here');
		$form = $this->createFormBuilder()
			->add('brochure', FileType::class, array('label' => 'FILE UPLOAD (all format supported)', 'multiple' => true))
			->add('save', SubmitType::class, ['label' => 'Start Upload'])
            ->getForm();
			// ->add('name', TextType::class)
			// ->add('email', EmailType::class)
			// ->add('message', TextareaType::class)
			// ->add('send', SubmitType::class)
			// ->getForm();

        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            // $files = $product->getBrochure();
			// dump($request);die;
			
			$my_file=$request->files->get('form')['brochure'];
			// dump($my_file);die;

			foreach($my_file as $file)
			{
				// $path = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
				// array_push ($this->paths, $path);
				// $file->move($this->getUploadRootDir(), $path);
				// dump($file);die;
				
				$fileNameOriginal = $file->getClientOriginalName();

				$save_dir=$this->getParameter('brochures_directory').'/'.$upload_directory;
          	 	$fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

				// Move the file to the directory where brochures are stored
				try {
					$file->move(
						$save_dir,
						$fileNameOriginal
					);
				} catch (FileException $e) {
					// ... handle exception if something happens during file upload
				}	
				
				// dump($file);die;

				unset($file);
	
			}

			
			// dump($fileNameOriginal);die;

            
		// $product->setBrochure($fileName);

		$url_new= $this->generateUrl('file_manager', ['upload_directory' => $upload_directory]);
		$response = new RedirectResponse($url_new);
		return $response;
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
			// dump($alldirs);
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
