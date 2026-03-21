<?php
$res_id = "";
$res_id = $_GET['reservation_id'];

include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

    $getInfo = mysqli_query($db, "SELECT unit_id, customer_id FROM reservations WHERE reservation_id = '$res_id'");
    $row = mysqli_fetch_array($getInfo);

    $unit_id = "";
    $unit_id =  $row['unit_id'];

    $customer_id = "";
    $customer_id = $row['customer_id'];

    $delRes = mysqli_query($db, "DELETE FROM reservations WHERE reservation_id = '$res_id'");

    if ($delRes) {
        if ($customer_id) {
            mysqli_query($db, "DELETE FROM customers WHERE customer_id = '$customer_id'");
        }
        if ($unit_id) {
            mysqli_query($db, "UPDATE units SET status = 'Available' WHERE unit_id = '$unit_id'");
        }

        echo "success"; 
    }
?>