<?php
// 1. Initialize variables (Your Style)
$name = ""; 
$name = $_GET['name'];

$type = ""; 
$type = $_GET['type'];

$category = ""; 
$category = $_GET['category'];

// 2. Database connection
include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

// 3. Perform the Insert
// Status defaults to 'Available' as per your SQL schema
$save = mysqli_query($dbconn, "INSERT INTO units (unit_name, unit_type_id, category_id, status) 
    VALUES ('$name', '$type', '$category', 'Available')");

// 4. Output result
if($save){
    echo "success";
} else {
    echo "Database Error: " . mysqli_error($dbconn);
}
?>