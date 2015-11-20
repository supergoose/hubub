<?php

function connectToDb()
{

	$servername = "localhost";
	$username = "clairbec_andy";
	$password = "f?PH(!?~(GWe";

	try 
	{
	    
	    $conn = new PDO("mysql:host=$servername;dbname=clairbec_andy", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    return $conn;

	} catch(PDOException $e) {
		return $e;

	}
}

function closeDb()
{
	$conn = null;
}

?>