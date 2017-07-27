<?php


$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

/*
curl_setopt($ch, CURLOPT_URL, 'http://www.pantherdb.org/webservices/garuda/search.jsp?type=organism');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=organism');
*/



//Set the Url
curl_setopt($ch, CURLOPT_URL, 'http://pantherdb.org/webservices/garuda/enrichment.jsp?');



//Create a POST array with the file in it
$postData = array('geneList' => '@C:\\Users\\Miles\\Desktop\\test\\test.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

curl_setopt($ch, CURLOPT_POSTFIELDS, 'organism=HUMAN&enrichmentType=function');



// Execute the request
$response = curl_exec($ch);



print $response;




?>