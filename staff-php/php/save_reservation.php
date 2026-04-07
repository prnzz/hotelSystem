<?php
$guest_name = "";
$guest_name = $_GET['guest_name'];
$contact = "";
$contact = $_GET['contact'];
$unit_id = "";
$unit_id = $_GET['unit_id'];
$check_in = "";
$check_in = $_GET['check_in_date'];
$check_out = "";
$check_out = $_GET['expected_check_out'];
$check_in_time = "";
$check_in_time = $_GET['check_in_time'];
$check_out_time = "";
$check_out_time = $_GET['check_out_time'];
$duration = "";
$duration = $_GET['duration_days'];
$total = "";
$total = $_GET['total_bill'];

include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

$saveCustomer = mysqli_query($dbconn, "INSERT INTO customers (guest_name, contact) VALUES ('$guest_name', '$contact')");
$customer_id = mysqli_insert_id($dbconn);

$saveReservation = mysqli_query($dbconn, "INSERT INTO reservations (customer_id, unit_id, check_in_date, check_in_time, expected_check_out, check_out_time, duration_days, total_bill, status) VALUES ('$customer_id', '$unit_id', '$check_in', '$check_in_time', '$check_out', '$check_out_time', '$duration', '$total', 'Pending')");

$updateUnit = mysqli_query($dbconn, "UPDATE units SET status = 'Occupied' WHERE unit_id = '$unit_id'");
?>