<?php
$unit_id = "";
$unit_id = $_GET['unit_id'];

$name = "";
$name = $_GET['name'];

$type = "";
$type = $_GET['type'];

$category = "";
$category = $_GET['category'];

$new_unit_type = "";
$new_unit_type = isset($_GET['new_unit_type']) ? trim($_GET['new_unit_type']) : "";

$new_price_per_day = "";
$new_price_per_day = isset($_GET['new_price_per_day']) ? trim($_GET['new_price_per_day']) : "";

include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);

if($new_unit_type != ""){
    $check = mysqli_query($dbconn, "SELECT unit_type_id FROM unit_types WHERE unit_type_name = '$new_unit_type'");

    if(mysqli_num_rows($check) > 0){
        $row = mysqli_fetch_array($check);
        $type = $row['unit_type_id'];

        mysqli_query($dbconn, "UPDATE unit_types 
            SET price_per_day = '$new_price_per_day' 
            WHERE unit_type_id = '$type'");
    } else {
        $save_type = mysqli_query($dbconn, "INSERT INTO unit_types (unit_type_name, price_per_day) 
            VALUES ('$new_unit_type', '$new_price_per_day')");

        if($save_type){
            $type = mysqli_insert_id($dbconn);
        } else {
            echo "Database Error: " . mysqli_error($dbconn);
            exit;
        }
    }
}

if($unit_id == "" || $name == "" || $category == "" || $category == "0" || $type == "" || $type == "0"){
    echo "Please fill in all fields.";
    exit;
}

$update = mysqli_query($dbconn, "UPDATE units 
    SET unit_name = '$name',
        unit_type_id = '$type',
        category_id = '$category'
    WHERE unit_id = '$unit_id'");

if($update){
    echo "success";
} else {
    echo "Database Error: " . mysqli_error($dbconn);
}
?>