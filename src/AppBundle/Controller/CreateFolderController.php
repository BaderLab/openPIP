<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * CreateFolder controller.
 *

 */
class CreateFolderController extends Controller
{
	
	/**
	 * about
	 * @Route("/createfolder/{dir_name}", name="createfolder")
	 * @Route("/admin/createfolder/{dir_name}", name="admin_createfolder")
	 * @Method({"GET", "POST"})
	 */
	public function CreateFolderAction($dir_name, Request $request)
	{	

		// use this in windows server
		$sp_char='\ ';
		// use this in ubuntu server
		// $sp_char='/ ';

		$sp_char=substr_replace($sp_char,"", -1);
		// dump($sp_char);die;

		$root=$this->getParameter('kernel.root_dir');
		$path=$root.$sp_char."..".$sp_char."web".$sp_char."uploads".$sp_char.$dir_name;
		
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$dir_name.'\ ';
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$filename;
		// dump($path);die;

		$filesystem = new Filesystem();
		$filesystem->mkdir($path, 0777);
		// $filesystem->remove($path);	
		$path=null;


		$url_new= $this->generateUrl('file_manager', ['upload_directory' => $dir_name]);
		$response = new RedirectResponse($url_new);
		return $response;

	}


	/**
	 * about
	 * @Route("/deletefolder/{dir_name}", name="deletefolder")
	 * @Route("/admin/deletefolder/{dir_name}", name="admin_deletefolder")
	 * @Method({"GET", "POST"})
	 */
	public function DeleteFolderAction($dir_name, Request $request)
	{	
		// use this in windows server
		$sp_char='\ ';
		// use this in ubuntu server
		// $sp_char='/ ';

		$sp_char=substr_replace($sp_char,"", -1);
		// dump($sp_char);die;

		$root=$this->getParameter('kernel.root_dir');
		$path=$root.$sp_char."..".$sp_char."web".$sp_char."uploads".$sp_char.$dir_name;
		
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$dir_name.'\ ';
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$filename;
		// dump($path);die;

		$filesystem = new Filesystem();
		// $filesystem->mkdir($path, 0777);
		$filesystem->remove($path);	
		$path=null;


		$url_new= $this->generateUrl('file_manager', ['upload_directory' => $dir_name]);
		$response = new RedirectResponse($url_new);
		return $response;

	}
	
}

?>
