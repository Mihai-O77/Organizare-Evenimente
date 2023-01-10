<?php
require_once ("captcha.php");

if(isset($_POST["sendcontact"])){ 
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$_POST["g-recaptcha-response"];
        $response = file_get_contents($url);
        $responseData= json_decode($response);
        if ($responseData->success){

        require_once ("functions.inc.php");
    
        $namefrom = $_POST['nume'];
        $from = $_POST['email'];

    $subiect = $_POST['subiect'];
    $message = $_POST['mesaj'];
    $to = "proiect.mihai.machete@gmail.com";
    $name = "Mihai";
    $atachament = false;
    $pathattach = "";

    sendMail($message, $from, $to , $name, $subiect, $pathattach,$atachament, $namefrom);
    header("location: ../index.php"); 
    exit();
}
}
else{
    header("location: ../index.php?error=captcha"); 
    exit();
}
}
else{
    header("location: ../index.php"); 
    exit();
 }