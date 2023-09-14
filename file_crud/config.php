<?php
$con = mysqli_connect('localhost','root','','h_ms');
if(!$con){
    echo "Connection Failed";
}
session_start();
?>