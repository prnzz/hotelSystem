<?php
session_start();
if(!empty($_SESSION['loguser'])){
    echo "0";
} else {
    echo "1";
}