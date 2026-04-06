<?php

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


if($name == "" || $category == "" || $category == "0" || $type == "" || $type == "0"){
    echo "Please fill in all fields.";
    exit;
}

// 5. Perform the Insert
$save = mysqli_query($dbconn, "INSERT INTO units (unit_name, unit_type_id, category_id, status) 
    VALUES ('$name', '$type', '$category', 'Available')");

// 6. Output result
if($save){
    echo "success";
} else {
    echo "Database Error: " . mysqli_error($dbconn);
}
?>