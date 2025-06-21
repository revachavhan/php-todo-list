<?php
// db.example.php

// Update the values below with your own MySQL credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "todo_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
