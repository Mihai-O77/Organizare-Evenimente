<?php
require_once 'connection.db.php';
require_once 'functions.inc.php';


if (isset($_POST['pret'])){
$produse = $_POST['produse'];
$preturi = $_POST['preturi'];
$fp = fopen("../meniuri/preturi.txt", 'w');
$listaPret = array_combine($produse,$preturi);
//  $prodpret = json_encode($listaPret);
 $row = "";
foreach($listaPret as $prod => $pret){
    $row .= "{\"".$prod."\": ".$pret."}\n"; 
    
}
fwrite($fp,$row, strlen($row));
fclose($fp);
header("location: ../manager.php");
}
if(isset($_POST['confirmare'])){
$event = $_POST['event'];
$idcda = $_POST['id'];
$serie = serie($event);
$serie .= $idcda; 
    confirmcda($conn, $idcda, $serie);
}