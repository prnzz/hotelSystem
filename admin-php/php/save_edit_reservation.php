<?php
// 1. Initialize variables (Your Style)
$id = ""; $id = $_GET['id'];
$name = ""; $name = $_GET['name'];
$contact = ""; $contact = $_GET['contact'];
$checkin = ""; $checkin = $_GET['checkin'];
$checkout = ""; $checkout = $_GET['checkout'];
$unit = ""; $unit = $_GET['unit'];
$total = ""; $total = $_GET['total'];

// 2. Database connection
include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

// 3. First, find the customer_id associated with this reservation
$getIdQuery = mysqli_query($dbconn, "SELECT customer_id FROM reservations WHERE reservation_id = '$id'");
$row = mysqli_fetch_array($getIdQuery);
$customer_id = $row['customer_id'];

// 4. Update the Customers Table
$updateCustomer = mysqli_query($dbconn, "UPDATE customers SET 
    guest_name = '$name', 
    contact = '$contact' 
    WHERE customer_id = '$customer_id'");

// 5. Update the Reservations Table
$updateRes = mysqli_query($dbconn, "UPDATE reservations SET 
    check_in_date = '$checkin', 
    expected_check_out = '$checkout', 
    unit_id = '$unit', 
    total_bill = '$total' 
    WHERE reservation_id = '$id'");

// 6. Check if both updates were successful
if($updateCustomer && $updateRes){
    echo "success";
} else {
    echo "error: " . mysqli_error($dbconn);
}
?>