<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

$res_id = "";
$res_id = $_GET['res_id'];
$unit_id = "";
$unit_id = $_GET['unit_id'];

$query1 = mysqli_query($db, "UPDATE reservations SET status = 'Checked-Out' WHERE reservation_id = '$res_id'");

$query2 = mysqli_query($db, "UPDATE units SET status = 'Maintenance' WHERE unit_id = '$unit_id'");

if ($query1 && $query2) {
    echo "success";
} else {
    echo "Error: " . mysqli_error($db);
}
?>