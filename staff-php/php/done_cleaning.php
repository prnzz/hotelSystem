<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

$unit_id = "";
$unit_id = $_GET['unit_id'];

$query = mysqli_query($db, "UPDATE units SET status = 'Available' WHERE unit_id = '$unit_id'");

if ($query) {
    echo "success";
} else {
    echo "Error: " . mysqli_error($db);
}
?>