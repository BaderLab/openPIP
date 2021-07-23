<?php


namespace AppBundle\Controller;


// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
// use Symfony\Component\HttpFoundation\File\UploadedFile;
// use Symfony\Component\HttpFoundation\HeaderUtils;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\StreamedResponse;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DropzoneController extends Controller
{

    /**
     * @Route("/admin/media/upload")
     * @Template()
     */
    public function showUploadAction()
    {
        // just show the template
        return [];
    }

    /**
     * @Route("/admin/media/upload/process/{dir_name}", name="upload_media")
     */
    public function uploadAction($dir_name)
    {
        $output = array('uploaded' => false);

        $request = $this->get('request');
        $files = $request->files;
        // dump($files);die;

        // configuration values
        $directory = $this->getParameter('brochures_directory').'/'.$dir_name;

        // $file will be an instance of Symfony\Component\HttpFoundation\File\UploadedFile
        foreach($files as $uploadedFile) {
            // name the resulting file
            $name = $uploadedFile->getClientOriginalName();;
            $file = $uploadedFile->move($directory, $name);
            
            if ($file) { 
                $output['uploaded'] = true;
                $output['fileName'] = $name;
             }
            // do something with the actual file
            unset($file);
        }


        $url_new= $this->generateUrl('file_manager', ['upload_directory' => 'gallery']);
		$response = new RedirectResponse($url_new);
		return $response;
        // return data to the frontend
        return new JsonResponse($output);
    }


    /**
     * @Route("/admin/dropzone", name="admin_dropzone", options={"expose": true})  
     * @Method({"POST"})
     */
    public function dropzoneAction(Request $request)
    {
        /* @var UploadedFile $uploadedFile */
        $dump($request);die;
        $uploadedFile = $request->files->get('reference');
        dump($uploadedFile);die;
    }


}
