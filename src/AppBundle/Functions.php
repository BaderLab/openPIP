<?php
// src/AppBundle/Utils/Function.php
namespace AppBundle\Utils;

class Functions
{
	
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
		/*
		$servername = "127.0.0.1";
		$username = "root";
		$password = null;
		$dbname = "tor_ibin";
		*/
	    
	    
	    $servername = "127.0.0.1";
	    $username = "root";
	    $password = null;
	    $dbname = "YeRI";
	    /*
		$servername = "localhost";
		$username = "root";
		$password = "SQL-tor-ibin";
		$dbname = "tor_ibin";
		*/
		$connection = new \mysqli($servername, $username, $password, $dbname);
		
		return $connection;
		
		
	}

	
	
}