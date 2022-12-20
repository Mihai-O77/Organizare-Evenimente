<?php

session_start();

if(isset($_POST["confirm"])){

    require_once "connection.db.php";
    require_once "functions.inc.php";
$ndate = $_POST["date"];
$array_servici = array();
$array_decor = array();
$array_catering = array();

if(isset($_POST["cameraman"])){
 $cameraman = array("Cameraman" => $_POST["video"]);
 $array_servici = array_merge($array_servici, $cameraman);
}

if(isset($_POST["fotograf"])){
 $fotograf = array("Fotograf" => $_POST["foto"]);
 $array_servici = array_merge($array_servici, $fotograf);
}

if(isset($_POST["dj"])){
 $dj = array("Dj" => $_POST["djs"]);
 $array_servici = array_merge($array_servici, $dj);
}

if(isset($_POST["formatie"])){
  if(isset($_POST["music"])){
    $musics = $_POST["music"];
    $music_type = "";
    foreach($musics as $music){
        $music_type .= $music ."," ;
    }
    $music = rtrim($music_type, ",");
    $array_music = array("Formatie" => $music);
    $array_servici = array_merge($array_servici, $array_music);
  }
}

if(isset($_POST["artificii"])){
    $artificii = array("Artificii" => $_POST["artificii"]);
    $array_servici = array_merge($array_servici, $artificii);
}

if(isset($_POST["animatori"])){
    $animatori = array("Animatori" => $_POST["animatori"]);
    $array_servici = array_merge($array_servici, $animatori);
}

if(isset($_POST["decor"])){
      $decors = $_POST["decor"];
      $decor_type = "";
      foreach($decors as $dec){
          $decor_type .= $dec ."," ;
      }
      $decor = rtrim($decor_type, ",");
      $arraydecor = array("Decor" => $decor);
      $array_decor = array_merge($array_decor, $arraydecor);
}

if(isset($_POST["decor"])){
    $decors = $_POST["decor"];
    $decor_type = "";
    foreach($decors as $dec){
        $decor_type .= $dec ."," ;
    }
    $decor = rtrim($decor_type, ",");
    $arraydecor = array("Decor" => $decor);
    $array_decor = array_merge($array_decor, $arraydecor);
}

if(isset($_POST["mancare"])){
    $mancares = $_POST["mancare"];
    $mancare_type = "";
    foreach($mancares as $manc){
        $mancare_type .= $manc ."," ;
    }
    $mancare = rtrim($mancare_type, ",");
    $array_mancare = array("Catering" => $mancare);
    $array_catering = array_merge($array_catering, $array_mancare);
}

if(empty($array_servici) && empty($array_decor) && empty($array_catering)){
    header("location: ../nunta.php?error=emptyoptions");
    exit(); 
}

if(empty($_POST["date"])){
    header("location: ../nunta.php?error=emptydate");
    exit();
}

if(isset($_POST["date"])){
   $date = $_POST["date"];
   $date = strtotime($date);
   $date = date("Y/m/d", $date);
   $now = date("Y/m/d");
   $date = date_create($date);
   $now = date_create($now);
   $diff = date_diff($now, $date);
   $diff = $diff->format("%r%a");

   if($diff<7){
      header("location: ../nunta.php?error=invaliddate");
      exit();
   }
}

  

$userNunta = $_SESSION["userid"];
$servicii = json_encode($array_servici);
$decor = json_encode($array_decor);
$catering = json_encode($array_catering);

createNunta($conn, $userNunta, $servicii, $decor, $catering, $ndate);
}

