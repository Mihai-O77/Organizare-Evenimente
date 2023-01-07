<?php
$secretkey = "6Ldh2twjAAAAAKE7TccF_TEvc6A-Z-CwUsRThlfn";

if(isset($_POST["submit"])){
  if(isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])){
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$_POST["g-recaptcha-response"];
    $response = file_get_contents($url);
    $responseData= json_decode($response);
    if($responseData->success){
$username=$_POST["username"];
$password=$_POST["pwd"];

require_once "connection.db.php";
require_once "functions.inc.php";


if(emptyInputLogin($username, $password)){
    header("location: ../login.php?error=emptyinput");
    exit();
   }

loginUser($conn, $username, $password);   

}}
else{
  header("location: ../login.php?error=recaptcha");
  exit();
   }
}
else{
  header("location: ../login.php");
  exit();
}

