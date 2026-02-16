<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "itsurveydb";

try{


$conn = new PDO("mysql:host=$servername;dbname=$database",$username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//echo "Connected Succesfully"

} catch(PDOException $e){
echo "connection Failed" .$e->getMessage();
}

?>