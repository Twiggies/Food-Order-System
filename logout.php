<?php

session_start();
include_once("OrderingSystem.php");
$system = new OrderingSystem();

$pageTitle = "Fast Food Order - Login"; //change "Template" to whatever needed

$doLogout = true;

if ($doLogout == true) {
    $system->logout();
    echo "<script> window.alert('Logout Successful'); window.location.replace('login.php')</script>";
    exit();
}
?>