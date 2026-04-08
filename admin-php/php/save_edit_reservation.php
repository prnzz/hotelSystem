<?php

$id = ""; $id = $_GET['id'];
$name = ""; $name = $_GET['name'];
$contact = ""; $contact = $_GET['contact'];
$checkin = ""; $checkin = $_GET['checkin'];
$checkout = ""; $checkout = $_GET['checkout'];
$unit = ""; $unit = $_GET['unit'];
$total = ""; $total = $_GET['total'];

include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

$getIdQuery = mysqli_query($dbconn, "SELECT customer_id FROM reservations WHERE reservation_id = '$id'");
$row = mysqli_fetch_array($getIdQuery);
$customer_id = $row['customer_id'];

$updateCustomer = mysqli_query($dbconn, "UPDATE customers SET 
    guest_name = '$name', 
    contact = '$contact' 
    WHERE customer_id = '$customer_id'");

$updateRes = mysqli_query($dbconn, "UPDATE reservations SET 
    check_in_date = '$checkin', 
    expected_check_out = '$checkout', 
    unit_id = '$unit', 
    total_bill = '$total' 
    WHERE reservation_id = '$id'");

if($updateCustomer && $updateRes){
    echo "success";
} else {
    echo "error: " . mysqli_error($dbconn);
}
?>