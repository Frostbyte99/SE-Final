<?php

//class
require('Class.php');

//Get login info
$user = $_POST['user_name'];
$pass = $_POST['password'];

//set session var
session_start();
$_SESSION["pass_user"] = $user;

//Create Object
$login1Obj = new log;
$login1Obj->user_login($user, $pass);
?>