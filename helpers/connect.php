<?php
$servername = "localhost";
$dbusername = "pmauser";
$dbpassword = "password";
$dbname = "CBT";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
