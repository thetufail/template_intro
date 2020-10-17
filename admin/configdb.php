<?php

$siteurl = "http://localhost/training/";

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "gue55me";
$dbname = "template_intro";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>