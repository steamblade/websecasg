<?php
// database_config.php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// Establish database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to securely hash the password using bcrypt
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Function to insert user data into the database
function registerUser($username, $password) {
    global $conn;
    $hashedPassword = hashPassword($password);
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    return mysqli_query($conn, $sql);
}
?>
