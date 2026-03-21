<?php
// 1. Initialize variables (Your Style)
$id = ""; 
$id = $_GET['id'];

$name = ""; 
$name = $_GET['name'];

$status = ""; 
$status = $_GET['status'];

// 2. Database connection
include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

// 3. Update the base table 'units'
$save = mysqli_query($dbconn, "UPDATE units SET 
    unit_name = '$name', 
    status = '$status' 
    WHERE unit_id = '$id'");

// 4. Feedback logic
if($save){
    echo "success";
} else {
    echo "Database Error: " . mysqli_error($dbconn);
}
?>