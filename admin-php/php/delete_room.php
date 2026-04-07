<?php 
$unit_id = $_GET['unit_id'];

include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['unit_id']) || empty($_GET['unit_id'])) {
    die("Invalid unit ID.");
}

$unit_id = mysqli_real_escape_string($db, $_GET['unit_id']);

$findRoom = mysqli_query($db, "SELECT * FROM units WHERE unit_id = '$unit_id'");

if (mysqli_num_rows($findRoom) > 0) {
    $deleteRoom = mysqli_query($db, "DELETE FROM units WHERE unit_id = '$unit_id'");

    if ($deleteRoom) {
        echo "Unit deleted successfully.";
    } else {
        echo "Error deleting unit: " . mysqli_error($db);
    }
} else {
    echo "Unit not found.";
}
?>