<?php
$host = "localhost"; 
$username = "users"; 
$password = "users1234"; 
$db_name = "users"; 

$conn = mysqli_connect($host, $username, $password, $db_name);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>