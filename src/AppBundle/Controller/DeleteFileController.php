<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * deleteFile controller.
 *

 */
class DeleteFileController extends Controller
{
	
	/**
	 * about
	 * @Route("/deletefile/{filename}", name="deletefile")
	 * @Route("/admin/deletefile/{filename}", name="admin_deletefile")
	 * @Method({"GET", "POST"})
	 */
	public function deleteFileAction($filename, Request $request)
	{
		$root=$this->getParameter('kernel.root_dir');
		$path=$root."\..\web\uploads\gallery\ ";
		$path=substr_replace($path ,"", -1);
		$path=$path.$filename;
		// dump($path);die;

		$filesystem = new Filesystem();
		$filesystem->remove($path);	
		$path=null;


		$url_new= $this->generateUrl('file_manager', ['upload_directory' => 'gallery']);
		$response = new RedirectResponse($url_new);
		return $response;

	}

	
}

?>
