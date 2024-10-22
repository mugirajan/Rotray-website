<?php
	$servername = "localhost";
$username = "rotary";
$password = "kia@Seltos1";
$dbname = "rotary";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}