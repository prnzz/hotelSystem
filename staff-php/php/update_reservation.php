<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

if (isset($_GET['action'])) {
    $res_id = mysqli_real_escape_string($db, $_GET['reservation_id']);
    $action = $_GET['action'];

    if ($action == 'confirm') {

        $checkPaymentStatus = mysqli_query($db, "SELECT payment_status, unit_id FROM reservations WHERE reservation_id = '$res_id'");
        $paymentRow = mysqli_fetch_array($checkPaymentStatus);

        if ($paymentRow) {
            $payment_status = $paymentRow['payment_status'];
            $unit_id = $paymentRow['unit_id'];

            if ($payment_status == 'Paid') {
                $query = "UPDATE reservations SET status = 'Checked-In' WHERE reservation_id = '$res_id'";
                $query2 = "UPDATE units SET status = 'Occupied' WHERE unit_id = '$unit_id'";

                if (mysqli_query($db, $query) && mysqli_query($db, $query2)) {
                    echo "success";
                } else {
                    echo "Error: " . mysqli_error($db);
                }
            } else {
                echo "not_paid";
            }
        } else {
            echo "Reservation not found";
        }
    } 

    if ($action == 'cancel') {
        $unit_id = $_GET['unit_id'];

        $deletePayment = "DELETE FROM payments WHERE reservation_id = '$res_id'";

        $query = "UPDATE reservations 
                SET status = 'Cancelled', payment_status = 'Unpaid' 
                WHERE reservation_id = '$res_id'";

        $query2 = "UPDATE units SET status = 'Available' WHERE unit_id = '$unit_id'";

        if (
            mysqli_query($db, $deletePayment) &&
            mysqli_query($db, $query) &&
            mysqli_query($db, $query2)
        ) {
            echo "success";
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }

} else {
    echo "Invalid Request";
}
?>