<?php
$res_id = "";
$res_id = $_GET['res_id'];
$amount = "";
$amount = $_GET['total'];
$method = "";
$method = $_GET['method'];

include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

$savePayment = mysqli_query($dbconn, "INSERT INTO payments (reservation_id, amount, payment_method, payment_date) VALUES ('$res_id', '$amount', '$method', NOW())");

$getReservation = mysqli_query($dbconn, "SELECT unit_id, total_bill FROM reservations WHERE reservation_id = '$res_id'");
$rRow = mysqli_fetch_array($getReservation);
$unit_id = $rRow['unit_id'];
$total_bill = $rRow['total_bill'];

$getPaid = mysqli_query($dbconn, "SELECT SUM(amount) AS total_paid FROM payments WHERE reservation_id = '$res_id'");
$pRow = mysqli_fetch_array($getPaid);
$total_paid = $pRow['total_paid'];

$payment_status = "Unpaid";

if ($total_paid <= 0) {
    $payment_status = "Unpaid";
} else if ($total_paid < $total_bill) {
    $payment_status = "Partial";
} else {
    $payment_status = "Paid";
}

$updateReservation = mysqli_query($dbconn, "UPDATE reservations SET payment_status = '$payment_status' WHERE reservation_id = '$res_id'");

$updateUnit = true;
if ($payment_status == "Paid") {
    $updateUnit = mysqli_query($dbconn, "UPDATE units SET status = 'Occupied' WHERE unit_id = '$unit_id'");
}

if ($savePayment && $updateReservation && $updateUnit) {
    echo "success";
} else {
    echo "error";
}
?>