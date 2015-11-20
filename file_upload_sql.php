<?php

include("db_connect.php");

//Returns -1 if there was an error
function fileUploadComplete($filename = null)
{

	if($filename == null)
	{
		die("Error: No filename for file upload");
	}

	$conn = connectToDb();

	try
	{

		//Prepare SQL and bind parameters for insert
		$stmt = $conn->prepare("INSERT INTO Uploaded_Files (filename)
								VALUES (:filename)");
		$stmt->bindParam(':filename', $filename);
		$stmt->execute();

		return $conn->insert_id;

	} catch(PDOException $e) {
		die("Exception in SQL INSERT: ".$e);
	}

	closeDb();

}

?>