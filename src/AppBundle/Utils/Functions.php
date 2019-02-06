<?php
// src/AppBundle/Utils/Function.php
namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class Functions
{

	private $em;
	private $securityContext;
	private $securityAuthorizationChecker;
	
	public function __construct(EntityManager $em, $securityContext, AuthorizationCheckerInterface $securityAuthorizationChecker) {
		
		$this->em = $em;
		$this->securityContext = $securityContext;
		$this->securityAuthorizationChecker = $securityAuthorizationChecker;
	}
	
	
	public function removeDuplicateObjectsFromArray($array) {
		
		$array = array_unique($array, SORT_REGULAR);
		$array = array_values($array);
		
		return $array;
	}
	
	public function removeDuplicates($array) {
		
		$array = array_unique($array);
		$array = array_values($array);
		
		return $array;
	}
	
	
	public function mysql_connect(){
		
		$servername = "127.0.0.1";
		$username = "root";
		$password = null;
		$dbname = "HuRI";
		/*
		$servername = "localhost";
		$username = "root";
		$password = "SQL-tor-ibin";
		$dbname = "tor_ibin";
		*/
		$connection = new \mysqli($servername, $username, $password, $dbname);
		
		return $connection;
		
		
	}
	
	public function getAdminSettings(){
		
		$em = $this->em;
		
		$admin_settings = $em->getRepository('AppBundle:Admin_Settings')->find(1);
		
		return $admin_settings;
	}

	public function getLoginStatus(){
		
		$securityContext = $this->securityContext;
		
		$login_status = false;
		
		$is_fully_authenticated = $securityContext->isGranted('IS_AUTHENTICATED_FULLY');
		
		if($is_fully_authenticated){
			$login_status =  true;
		}
		
		return $login_status;
	}
	
	public function getAdminStatus(){
		
		$securityAuthorizationChecker = $this->securityAuthorizationChecker;
		
		$admin_status = false;
		
		if ($securityAuthorizationChecker->isGranted('ROLE_ADMIN')) {
			$admin_status = true;
		}
		
		return $admin_status;
	}
	
	public function log($string, $num){
		$handle = fopen('D:\\test\\test_' . $num . '.txt', 'w');
		fwrite($handle, $string);
	}
}
