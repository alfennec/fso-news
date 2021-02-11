<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db = "api_fso";


	/*$server       = "localhost";
    $username     = "bermed";
    $password     = "45619poi";
    $db   		  = "api_news";*/
	

    $conn = mysqli_connect($server, $username, $password, $db);
    mysqli_set_charset($conn,"utf8");

?>