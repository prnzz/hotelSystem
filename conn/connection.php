<?php 
// 1. Connection Parameters
$host     = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port     = 4000;
$username = '3A8Qaxa7CLKWSYn.root';
$password = 'QD6jztGtWC7p3jDM'; // Use your generated password
$database = 'test'; 

// 2. Initialize and Setup SSL (Required for TiDB Cloud)
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL); 

// 3. Establish the Connection
if (!mysqli_real_connect($conn, $host, $username, $password, $database, $port)) {
    die("Connection failed: " . mysqli_connect_error());
}

// 4. Set Character Set
mysqli_set_charset($conn, "utf8mb4");
?>