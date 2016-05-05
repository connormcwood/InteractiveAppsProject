<?php
$servername = "localhost";
$dbusername = "root"; //cmcgarty-wood
$dbpassword = ""; //mehjbni
$dbname = "cmcgarty-wood";

// Create connection
//$conn = new mysqli($servername, $username, $password);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors',1);

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
?> 
