<?php

//Blob upload
$file = $_FILES["sound"];

if(!empty($file))
{
	echo "Houston, we have a file.";

	

}else{
	echo "No file detected";
}

?>