<?php
$servername = "localhost";
$username = "proflujo";
$password = "letmein1!";
$dbname = "rotary_event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
