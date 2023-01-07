<?php
$secretkey = "6Ldh2twjAAAAAKE7TccF_TEvc6A-Z-CwUsRThlfn";

if(isset($_POST["submit"])){
  if(isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])){
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$_POST["g-recaptcha-response"];
    $response = file_get_contents($url);
    $responseData= json_decode($response);
    if($responseData->success){

   $username=$_POST["username"];
   $email=$_POST["email"];
   $password=$_POST["pwd"];
   $passwordr=$_POST["pwdr"];
   $firstName=$_POST["fname"];
   $lastName=$_POST["lname"];

   require_once "connection.db.php";
   require_once "functions.inc.php";

   if(emptyInput($username, $password, $passwordr, $email, $firstName, $lastName)){
    header("location: ../signup.php?error=emptyinput");
    exit();
   }

   if(invalidUsername($username)){
    header("location: ../signup.php?error=invalidusername");
    exit();
   }

   if(invalidEmail($email)){
    header("location: ../signup.php?error=invalidemail");
    exit();
   }

   if(invalidPassword($password)){
    header("location: ../signup.php?error=invalidpassword");
    exit();
   }

   if(pwdMatch($password, $passwordr)){
    header("location: ../signup.php?error=pwdsdontmatch");
    exit();
   }

   if(invalidFname($firstName)){
    header("location: ../signup.php?error=invalidFname");
    exit();
   }

   if(invalidLname($lastName)){
    header("location: ../signup.php?error=invalidLname");
    exit();
   }

   if(userExists($conn, $username, $email)){
    header("location: ../signup.php?error=useralreadyexists");
    exit();
   }
   

   insertUser($conn, $username, $email, $password, $firstName, $lastName);
}}
  else{
    header("location: ../signup.php?error=recaptcha");
    exit();
     }
}
else{
    header("location: ../signup.php");
    exit();
}