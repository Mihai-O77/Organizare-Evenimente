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
 $serv = verifServicii($_POST["video"]);
 $cameraman = array("Cameraman" => $serv);
 $array_servici = array_merge($array_servici, $cameraman);
}

if(isset($_POST["fotograf"])){
 $serv = verifServicii($_POST["foto"]);   
 $fotograf = array("Fotograf" => $serv);
 $array_servici = array_merge($array_servici, $fotograf);
}

if(isset($_POST["dj"])){
 $serv = verifServicii($_POST["djs"]);   
 $dj = array("Dj" => $serv);
 $array_servici = array_merge($array_servici, $dj);
}

if(isset($_POST["formatie"])){
  if(isset($_POST["music"])){
    $musics = $_POST["music"];
    $music_type = "";
    foreach($musics as $music){
        $serv = verifServicii($music);
        $music_type .= $serv ."," ;
    }
    $music = rtrim($music_type, ",");
    $array_music = array("Formatie" => $music);
    $array_servici = array_merge($array_servici, $array_music);
  }
}

if(isset($_POST["artificii"])){
    $serv = verifServicii($_POST["artificii"]);
    $artificii = array("Artificii" => $serv);
    $array_servici = array_merge($array_servici, $artificii);
}

if(isset($_POST["animatori"])){
    $serv = verifServicii($_POST["artificii"]);
    $animatori = array("Animatori" => $serv);
    $array_servici = array_merge($array_servici, $animatori);
}

if(isset($_POST["decor"])){
      $decors = $_POST["decor"];
      $decor_type = "";
      foreach($decors as $dec){
          $serv = verifServicii($dec);
          $decor_type .= $serv ."," ;
      }
      $decor = rtrim($decor_type, ",");
      $arraydecor = array("Decor" => $decor);
      $array_decor = array_merge($array_decor, $arraydecor);
}

if(isset($_POST["mancare"])){
    $mancares = $_POST["mancare"];
    $mancare_type = "";
    foreach($mancares as $manc){
        $serv = verifServicii($manc);
        $mancare_type .= $serv ."," ;
    }
    $mancare = rtrim($mancare_type, ",");
    $array_mancare = array("Catering" => $mancare);
    $array_catering = array_merge($array_catering, $array_mancare);
}

if(isset($_POST["menu"])){
    $serv = verifServicii($_POST["meniu"]);
    $menu = array("Meniu"=>$serv);
    $array_catering = array_merge($array_catering, $menu);
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

if(isset($_POST["event"])){ 
  if($event = verifEvent($_POST["event"])){   
$userNunta = $_SESSION["userid"];
$servicii = json_encode($array_servici);
$decor = json_encode($array_decor);
$catering = json_encode($array_catering);
createEvents($conn, $userNunta, $servicii, $decor, $catering, $ndate, $event);
}else{
    header("location: ../index.php");
    exit();
}
}

}

