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
		$sp_char='/ ';
		$sp_char=substr_replace($sp_char,"", -1);


		$fname=$request->query->get('fname');
		if(!empty($fname)){
			// dump($fname);die;

			$root=$this->getParameter('kernel.root_dir');
			$path=$root.$sp_char."..".$sp_char."web".$sp_char."uploads".$sp_char.$fname;
			$filesystem = new Filesystem();
			$filesystem->mkdir($path, 0777);
			// $filesystem->remove($path);	
			$path=null;

			$url_new= $this->generateUrl('file_manager', ['upload_directory' => $fname]);
			$response = new RedirectResponse($url_new);
			return $response;
		}
		// die;
		

		
		
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$dir_name.'\ ';
		// $path=substr_replace($path ,"", -1);
		// $path=$path.$filename;
		// dump($path);die;

		


		$url_new= $this->generateUrl('file_manager', ['upload_directory' => $dir_name]);
		$response = new RedirectResponse($url_new);
		return $response;

	}

	/**
	 * about
	 * @Route("/createOrganism", name="createOrganism")
	 * @Route("/admin/createOrganism", name="admin_createOrganism")
	 * @Method({"GET", "POST"})
	 */
	public function CreateOrganismAction(Request $request)
	{	


		$organism_name=$request->query->get('organism_name');
		$organism_taxid=$request->query->get('tax_id');
		$organism_description=$request->query->get('organism_description');
		$organism_scientificName=$request->query->get('scientific_name');
		$organism_class=$request->query->get('organism_class');

		
		$organism_data=array(
			'organism_name'=>$organism_name,
			'organism_taxid'=>$organism_taxid,
			'organism_description'=>$organism_description,
			'organism_scientificName'=>$organism_scientificName,
			'organism_class'=>$organism_class,
		);

		$functions = $this->get('app.functions');		
		$connection =  $functions->mysql_connect();
		
		// $interactor_id_string = join(',', $interactor_array);
		// $interactor_id_string = "'" . str_replace(",", "','", $interactor_id_string) . "'";
		
		$query='select * from organism where common_name="'.$organism_name.'"';

		$result = $connection->query($query);
		// mysqli_close($connection);
		// $organism_arrays = array();
		if($result){
			$count =0;
			while($row = $result->fetch_assoc()) {
				$count++;
			}
			if ($count>0){
				$this->addFlash(
					'success',
					'Organism already present with the name: ' .$organism_name
				);
				$url_new= $this->generateUrl('data_manager');
				$response = new RedirectResponse($url_new);
				return $response;
			}
		}
		
		$query='insert into organism (common_name,description,scientific_name,class,taxid_id) VALUES ("';
		$query=$query.$organism_name.'","'.$organism_description.'","'.$organism_scientificName.'","'.$organism_class.'","'.$organism_taxid.'")';
		
		$result = $connection->query($query);
		mysqli_close($connection);

		// $organism_array = array();
		// foreach ($organism_arrays as $organism) {

		// 	$id = $organism['id'];
		// 	$common_name = $organism['common_name'];
		// 	$name=$id.". "."$common_name";
		// 	$organism_array[] = $name;
		// }
		// var_dump($organism_data);
		// die;
		// if(!empty($fname)){
		// 	// dump($fname);die;

		// 	$root=$this->getParameter('kernel.root_dir');
		// 	$path=$root.$sp_char."..".$sp_char."web".$sp_char."uploads".$sp_char.$fname;
		// 	$filesystem = new Filesystem();
		// 	$filesystem->mkdir($path, 0777);
		// 	// $filesystem->remove($path);	
		// 	$path=null;

		// 	$url_new= $this->generateUrl('file_manager', ['upload_directory' => $fname]);
		// 	$response = new RedirectResponse($url_new);
		// 	return $response;
		// }
		// die;
		

		$this->addFlash(
            'success',
            'Organism '.$organism_name. ' created successfully!  '
        );
		

		$url_new= $this->generateUrl('data_manager');
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
		$sp_char='/ ';

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
