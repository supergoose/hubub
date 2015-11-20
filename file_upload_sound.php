<?php

//Target folder
$target_dir = "uploads/sounds/";
$file_identifier = "sound";

//Flag to discern if this upload is ok
$uploadOk = 1;

$maximumFileSizeKb = 500;
$kb = 1000;

//Get the file type
$path = $_FILES[$file_identifier]["name"];
$fileType = $_FILES[$file_identifier]["type"];
$fileExtensions = explode("/", $fileType);
$fileExtension = $fileExtensions[1];

//Use the files current name - this will have to contact the database to get a new unique identifier

//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$fileExists = true;
while($fileExists == true)
{
	$target_file = uniqid('Sound', false) . "." . $fileExtension;
	$fileExists = file_exists($target_dir . $target_file);
}

$target_path = $target_dir . $target_file;


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) 
{

	echo mime_content_type($_FILES[$file_identifier]["tmp_name"]);

	$mimeType = mime_content_type($_FILES[$file_identifier]["tmp_name"]);
	//Get the files size
    $check = strpos($mimeType, "audio");
    echo "position: " . $check;
    if($check > -1) 
    {
        echo "File is a sound - " . $mimeType . ".";
        $uploadOk = 1;
    } else {
        echo "File is not a sound.";
        $uploadOk = 0;
    }
}

/*
// Check if file already exists
if (file_exists($target_file)) 
{
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
*/

// Check file size
if ($_FILES[$file_identifier]["size"] > $maximumFileSizeKb * $kb) //checks if over 500kb
{
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($fileExtension != "wav" && $fileExtension != "mp3" ) 
{
    echo "Sorry, only WAV or MP3 files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) 
{
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES[$file_identifier]["tmp_name"], $target_path)) 
    {

        //Add this sound file to the database
        include("file_upload_sql.php");
        echo "Upload complete: " . fileUploadComplete($target_path);

        echo "The file ". basename( $_FILES[$file_identifier]["name"]). " has been uploaded to location: " . $target_path;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>