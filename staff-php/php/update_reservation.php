<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

if (isset($_GET['action'])) {
    $res_id = mysqli_real_escape_string($db, $_GET['reservation_id']);
    $action = $_GET['action'];

    if ($action == 'confirm') {
        $query = "UPDATE reservations SET status = 'Checked-In' WHERE reservation_id = '$res_id'";
        if (mysqli_query($db, $query)) {
            echo "success";
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } 

    if ($action == 'cancel') {
        $unit_id = mysqli_real_escape_string($db, $_GET['unit_id']);
        
        $query = "UPDATE reservations SET status = 'Cancelled' WHERE reservation_id = '$res_id'";
        $query2 = "UPDATE units SET status = 'Available' WHERE unit_id = '$unit_id'";
        
        if (mysqli_query($db, $query) && mysqli_query($db, $query2)) {
            echo "success";
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }

} else {
    echo "Invalid Request";
}
?>