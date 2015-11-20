<?php
$requestLatitude = $_POST['latitude'];
$requestLongitude = $_POST['longitude'];

//echo "lat: ".$requestLatitude." long: ".$requestLongitude;

//now we just need to write some sweet SQL to grab the list of sounds :)
//Database connection credentials
$servername = "localhost";
$username = "clairbec_andy";
$password = "f?PH(!?~(GWe";

$requestLatitude = $_POST['latitude'];
$requestLongitude = $_POST['longitude'];

class Geo {
	public $geo_id;
	public $latitude;
	public $longitude;
	public $time;
	public $user_id;
}

class User {
	public $user_id;
	public $username;
}

try 
{
    
    $conn = new PDO("mysql:host=$servername;dbname=clairbec_andy", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 

} catch(PDOException $e) {

    echo "Connection failed: " . $e->getMessage();

}

//Add geolocation data
try
{

	//Prepare SQL and bind parameters for get
	$stmt = $conn->prepare("SELECT geo_id, latitude, longitude, time, user_id FROM Geo");

	//Execute SQL
	$stmt->execute();

	//echo "Getting results...";
	$geos = array_values($stmt->fetchAll(PDO::FETCH_CLASS, "Geo"));
	
	echo json_encode($geos, JSON_NUMERIC_CHECK | 128);

} catch(PDOException $e) {
	echo "Error executing geolocation insert SQL: ".$e->getMessage();
}

    //Close our connection
    $conn = null;

?>