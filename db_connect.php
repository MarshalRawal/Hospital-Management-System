<?php
// Database configuration for XAMPP
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password is empty
$dbname = "hospital_system"; // Your exact database name

// 1. Create the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// 2. Check the connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
} 
?>