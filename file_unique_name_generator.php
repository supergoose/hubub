<?php

$target_dir = $_POST['uploadDirectory']; //uploads/sounds/hubub
$file_type = $_POST['fileType'];

$fileExists = true;
$target_file = "";
while($fileExists == true)
{
	$target_file = uniqid($file_type, false) . "." . $file_type;
	$fileExists = file_exists($target_dir . $target_file);
}

echo $target_file;
?>