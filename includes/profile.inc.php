<?php

if(isset($_POST["updatecont"])){
session_start();
require_once("connection.db.php");
require_once("functions.inc.php");

$username = $_POST["username"];
$fname =  $_POST["firstname"];
$lname = $_POST["lastname"];
$email = $_POST["email"];
$id = $_SESSION["userid"];

if(empty($username) || empty($lname) || empty($fname) || empty($email)){
    header("location: ../profile.php?error=emptyinput");
    exit();
}

if(invalidUsername($username)){
    header("location: ../profile.php?error=invalidusername");
    exit();
   }

if(invalidEmail($email)){
    header("location: ../profile.php?error=invalidemail");
    exit();
}

if(invalidFname($fname)){
    header("location: ../profile.php?error=invalidFname");
    exit();
   }

if(invalidLname($lname)){
    header("location: ../profile.php?error=invalidLname");
    exit();
}

if(newUserExists($conn, $username, $email, $id)){
    header("location: ../profile.php?error=usertaken");
    exit();
}

}