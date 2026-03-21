<?php 
// Connection Parameters using Render Environment Variables
$host     = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port     = 4000;
$username = '3A8Qaxa7CLKWSYn.root';
$database = 'test'; 

// This pulls the password securely from Render's settings
$password = getenv('DB_PASSWORD'); 

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL); 

if (!mysqli_real_connect($conn, $host, $username, $password, $database, $port)) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>