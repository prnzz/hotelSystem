<?php
// These match the names in your Railway Variables screenshot
$host     = getenv('MYSQLHOST');
$username = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');
$database = getenv('MYSQLDATABASE'); // This will be 'railway' based on your photo
$port     = getenv('MYSQLPORT');

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>