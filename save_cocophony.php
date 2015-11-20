<?php

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
    echo "Connected successfully"; 

} catch(PDOException $e) {

    echo "Connection failed: " . $e->getMessage();

}

//Add geolocation data
try
{

	//Prepare SQL and bind parameters for insert
	$stmt = $conn->prepare("INSERT INTO Geo (latitude, longitude)
							VALUES (:latitude, :longitude)");
	$stmt->bindParam(':longitude', $longitude);
	$stmt->bindParam(':latitude', $latitude);

	//user and sound

	//Get location
	$longitude = ($requestLongitude) ? $requestLongitude : 50.3765715;
	$latitude = -($requestLatitude) ? $requestLatitude : 4.119986299999937;

	$stmt->execute();

	echo "Insert successful";

	//Prepare SQL and bind parameters for get
	$stmt = $conn->prepare("SELECT geo_id, latitude, longitude, time, user_id FROM Geo");

	//Execute SQL
	$stmt->execute();

	echo "Getting results...";
	$geos = array_values($stmt->fetchAll(PDO::FETCH_CLASS, "Geo"));
	
	echo json_encode($geos, JSON_NUMERIC_CHECK | JSON_FORCE_OBJECT | 128);

} catch(PDOException $e) {
	echo "Error executing geolocation insert SQL: ".$e->getMessage();
}

    //Close our connection
    $conn = null;

?>