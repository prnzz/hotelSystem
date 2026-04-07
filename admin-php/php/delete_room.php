<?php 
$unit_id = $_GET['unit_id'];

include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

$deleteRoom = mysqli_query($db, "DELETE FROM roomlist WHERE unit_id = '$unit_id'");

?>