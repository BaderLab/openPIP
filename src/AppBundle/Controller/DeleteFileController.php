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
	 * @Route("/deletefile/{dir_name}/{filename}", name="deletefile")
	 * @Route("/admin/deletefile/{dir_name}/{filename}", name="admin_deletefile")
	 * @Method({"GET", "POST"})
	 */
	public function deleteFileAction($dir_name, $filename, Request $request)
	{	
		// use this in windows server
		$sp_char='\ ';
		// use this in ubuntu server
		$sp_char='/ ';

		$sp_char=substr_replace($sp_char,"", -1);
		// dump($sp_char);die;

		$root=$this->getParameter('kernel.root_dir');
		$path=$root.$sp_char."..".$sp_char."web".$sp_char."uploads".$sp_char.$dir_name.$sp_char.$filename;
		
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$dir_name.'\ ';
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$filename;
		// dump($path);die;

		$filesystem = new Filesystem();
		$filesystem->remove($path);	
		$path=null;


		$url_new= $this->generateUrl('file_manager', ['upload_directory' => $dir_name]);
		$response = new RedirectResponse($url_new);
		return $response;

	}

	
}

?>
