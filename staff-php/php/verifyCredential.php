<?php 
$user = "";
$pass = "";

$user = $_GET["user"];
$pass = $_GET["pass"];

include("../../conn/connection.php");
$dbconn = mysqli_connect($host, $username, $password, $database);
$loadCredential = mysqli_query($dbconn, 
    "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND role = 'staff'"
);

$id = "";
$username = "";
$password = "";

while($res = mysqli_fetch_array($loadCredential)){
    $id = $res["user_id"];
    $username = $res["username"];
    $password = $res["password"];
}

if($user === $username && $pass === $password){
    session_start();
    $_SESSION['loguser'] = $id;
    echo($id);
} else {
    echo("0");
}
?>