<?php

//class
require('Class.php');

//Get login info
$last = $_POST['LN'];
$Gphone = $_POST['Gphone'];
$Gemail = $_POST['Gemail'];

//set session var
$_SESSION["last"] = $last;
$_SESSION["Gphone"] = $Gphone;
$_SESSION["Gemail"] = $Gemail;

//Create Object
$login2Obj = new redirect;
$login2Obj->goto_askguest();
?>