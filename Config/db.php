<?php
$servername = "localhost"; // Change this to your database server name if different
$username = "root@localhost"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "your_database_name"; // Replace with your database name

// Create connection
$conn = new mysqli("localhost", "root", "","laundry_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
