<?php
session_start();
if(!empty($_SESSION['loguser'])){
    echo "1";
} else {
    echo "0";
}