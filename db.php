<?php
$servername = "localhost";
$username = "root"; // Change this if your username is different
$password = ""; // Change this if your password is different
$dbname = "task_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
