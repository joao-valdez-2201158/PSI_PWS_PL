<?php

require 'vendor/autoload.php';
use Carbon\Carbon;


session_start();

if($_SERVER['REQUEST_METHOD']=='GET'){ //se for GET
    include_once 'view/travelflightair/userform.php';
} else { //se for POST
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nif = $_POST['nif'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $birthday = $_POST['birthday'];


    include_once "model/travelflightair/User.php";
}



?>

