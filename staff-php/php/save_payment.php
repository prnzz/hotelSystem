<?php
$res_id = "";
$res_id = $_GET['res_id'];
$amount = "";
$amount = $_GET['amount_paid'];
$method = "";
$method = $_GET['method'];

include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

$savePayment = mysqli_query($dbconn, "INSERT INTO payments (reservation_id, amount, payment_method, payment_date) VALUES ('$res_id', '$amount', '$method', NOW())");

$getUnit = mysqli_query($dbconn, "SELECT unit_id FROM reservations WHERE reservation_id = '$res_id'");
$uRow = mysqli_fetch_array($getUnit);
$unit_id = $uRow['unit_id'];

$updateUnit = mysqli_query($dbconn, "UPDATE units SET status = 'Occupied' WHERE unit_id = '$unit_id'");

if ($savePayment && $updateUnit) {
    echo "success";
} else {
    echo "error";
}
?>