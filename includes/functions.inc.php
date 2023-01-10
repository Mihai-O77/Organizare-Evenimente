<?php

//functii sign up

function insertUser($conn, $username, $email, $password,  $firstName, $lastName){
 $insert = "INSERT INTO users ( usersUsername, usersEmail, usersPassword, usersFirst, usersLast) VALUE (?,?,?,?,?)";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $insert)){
    header("location: ../signup.php?error=stmtfail");
    exit();
 }
 $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
 mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPwd, $firstName, $lastName);
 mysqli_stmt_execute($stmt);
 mysqli_stmt_close($stmt);
 header("location: ../login.php");
 exit();
}

function emptyInput($username, $password, $passwordr, $email, $firstName, $lastName){
$result;
if(empty($username) || empty($password) || empty($passwordr) || empty($email) || empty($firstName) || empty($lastName)){
 $result= true;
}
else{
    $result= false;
}
return $result;
}

function invalidUsername($username){
$result;
if(!preg_match("/^[a-zA-Z0-9]+$/", $username)){
$result= true;
}
else{
  $result= false;
}
return $result;
}

function invalidEmail($email){
 $result;
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $result= true;
 }
 else{
    $result= false;
 }
 return $result;
}

function invalidPassword($password){
  $result;
  if(!preg_match("/[\w\W]{5,16}/", $password)){
  $result= true;
  }
  else{
    $result= false;
  }
  return $result;
  }

function pwdMatch($password, $passwordr){
$result;
if($password!==$passwordr){
    $result= true;
}
else{
    $result= false;
}
return $result;
}

function invalidFname($firstName){
    $result;
    if(!preg_match("/^[A-Z][a-z]*(\s[A-Z])?[a-z]*$/", $firstName)){
    $result= true;
    }
    else{
      $result= false;
    }
    return $result;
}

function invalidLname($lastName){
    $result;
    if(!preg_match("/^[A-Z][a-z]*$/", $lastName)){
    $result= true;
    }
    else{
      $result= false;
    }
    return $result;
}

function userExists($conn, $username, $email){
    $select = "SELECT * FROM users WHERE usersUsername = ? OR usersEmail = ?; ";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $select)){
       header("location: ../signup.php?error=stmtfail");
       exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $resultSelect = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultSelect)){
        return $row;
    }
    else{
        return false;
    }
    mysqli_stmt_close($stmt);
    exit();
}

//functii login

function emptyInputLogin($username, $password){
    $result;
    if(empty($username) || empty($password)){
     $result= true;
    }
    else{
        $result= false;
    }
    return $result;
}

function updateUserVisit($conn,$userid){
  $sql = "UPDATE users SET usersVisit=?, usersAccesari=? WHERE usersId = ? ";
  $query = "SELECT usersAccesari FROM users WHERE usersId = $userid;";
  $result = mysqli_query($conn, $query);
  if($row=mysqli_fetch_row($result)){
    $accesari = $row[0];
    $accesari++;
  }
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
      header("location: ../profile.php?error=stmtfailed");
      exit();
  }
  
  mysqli_stmt_bind_param($stmt, "sss",$CURRENT_TIMESTAMP, $accesari, $userid ); 
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

function loginUser($conn, $username, $password){
  $userExist = userExists($conn, $username, $username);
  if($userExist === false){
    header("location: ../login.php?error=wronglogin");
    exit();
  }
  $pwdHashed= $userExist["usersPassword"];
  $checkPwd= password_verify($password, $pwdHashed);
  if($checkPwd === false){
    header("location: ../login.php?error=wronglogin");
    exit();
  }
  else if($checkPwd === true){
    $userid = $userExist['usersId'];
      updateUserVisit($conn,$userid);
    session_start();
    $_SESSION["username"] = $userExist["usersUsername"];
    $_SESSION["userid"] = $userExist["usersId"];
    $_SESSION["fname"] = $userExist["usersFirst"];
    $_SESSION["lname"] = $userExist["usersLast"];
    $_SESSION["email"] = $userExist["usersEmail"];
    $_SESSION["rol"] = $userExist["usersRol"];
    header("location: ../index.php");
    exit();
  }
}


// functii nunta

function menuList($text){
  $lines = file("$text");
  foreach($lines as $line){
    echo "<li>$line</li>";
  }


}

function createEvents($conn, $username, $servicii, $decor, $catering, $data, $event){
  $insert = "INSERT INTO events ( Users, Servicii, Decor, Catering, eventData, eveniment) VALUE (?,?,?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $insert)){
     header("location: ../signup.php?error=stmtfail");
     exit();
  }
  
  mysqli_stmt_bind_param($stmt, "ssssss", $username, $servicii, $decor, $catering, $data, $event);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  $cda = searchComanda($conn,$username,true,0); 
  $email = $cda[0]['usersEmail'];
  $lname = $cda[0]['usersLast'];
  $fname = $cda[0]['usersFirst'];
  $mesg ="<div><img src=\"../images/maillogo.jpeg\" alt='Happy events'></div>
        <hr>
        <h3>".$fname.' '.$lname.", cererea dv. a fost inregistrata !</h3>
        <h4>Multumim pentru alegerea facuta !</h4>
        <p>Veti primi un email de confirmare !</p>";
        $to = $email;
        $name = $fname." ".$lname;
        $subj = "Inregistrare comanda";
        $attach = false;
        $from = "proiect.mihai.machete@gmail.com";
        $namefrom = "Mihai";
        $path = "";
        sendMail($mesg,$from,$to,$name,$subj,$path,$attach,$namefrom);
  header("location: ../profile.php");
  exit();  
}

// functii profil

function newUserExists($conn, $username, $email, $id){
  $select = "SELECT * FROM users WHERE (usersUsername = ? OR usersEmail = ?) AND usersId != ?; ";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $select)){
     header("location: ../profile.php?error=stmtfail");
     exit();
  }
  mysqli_stmt_bind_param($stmt, "sss", $username, $email, $id);
  mysqli_stmt_execute($stmt);
  $resultSelect = mysqli_stmt_get_result($stmt);
  if(mysqli_num_rows($resultSelect) > 0){
      return true;
  }
  else{
      return false;
  }
  mysqli_stmt_close($stmt);
  exit();
}

function updateUser($conn, $username, $email, $fname, $lname, $id){
  $update = "UPDATE users SET usersUsername=?, usersEmail=?, usersFirst=?, usersLast=? WHERE usersId=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $update)){
    header("location: ../profile.php?error=stmtfail");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $fname, $lname, $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  $_SESSION["username"] = $username;
  $_SESSION["email"] = $email;
  $_SESSION["fname"] = $fname;
  $_SESSION["lname"] = $lname;
  $_SESSION["userid"] =$id;
  
  header("location: ../profile.php");
  exit();
}

// functii comenzi

function searchComanda($conn, $user, $adevarat, $selectare){
if($selectare === 1){  
  $select = "SELECT ev.*, us.usersFirst, us.usersLast, us.usersEmail FROM events ev 
             JOIN users us ON ev.Users=us.usersId
             WHERE ev.Id=?; ";
}
else{
  $select = "SELECT ev.*, us.usersFirst, us.usersLast, us.usersEmail FROM events ev 
             JOIN users us ON ev.Users=us.usersId
             WHERE ev.Users=?; "; 
}
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $select)){
  header("location: ../profile.php?error=stmtfail");
  exit();
}
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if(mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_assoc($result)){
    $rows[] = $row;
  }
  if($adevarat === true){
  return $rows;
   }
  else{
    return mysqli_num_rows($result);
  }
}
else{
  return false;
}
mysqli_stmt_close();
exit();
}


function serie($event){
  switch($event){
    case "nunta": $seria="N.2775"; break;
    case "botez": $seria="B.069"; break;
    case "majorat": $seria="M.31057"; break;
    case "aniversare": $seria="A.116578"; break;
    default: $seria="0000"; break;
  }
  return $seria;
}

function listaComenzi($com){
  if($com){
      $comJson = json_encode($com);
      // print_r($comJson);
      $event = $com["eveniment"];
      $seria = serie($event);
      $cdadata = $com["comandaData"];
      $dateEv = $com["eventData"];
      $date = strtotime($dateEv);
      $date = date("Y/m/d", $date);
      $now = date("Y/m/d");
      $status = $com["StatusEv"];
      $id = $com["Id"];
      $seria .= $id;
      if($date < $now){
        $statusAfisare = "Livrat";
      }
      else if($status === "Cerere"){
        $statusAfisare = "In curs de procesare";
      }
      else{
        $statusAfisare = "Confirmat";
      }
      
      $date = date_create($dateEv);
      $now = date_create();
      $zile = date_diff($now, $date);
      $zile = $zile->format("%r%a");
      if($zile < 0){
        $rest = "";
      }
      else{
        $rest = "Mai sunt <span>$zile zile</span> pana la eveniment.";
      }
      $result = [$seria, $dateEv, $comJson, $statusAfisare, $rest, $cdadata];
      return $result;
    
    }else
    { 
      echo "<h2>Nu aveti comenzi </h2>";
    } 
}


function listprices($text){
  $lines = file("$text");
      $listprices=[];
         foreach($lines as $line){
          $list = json_decode($line,true);
          $listprices = array_merge($listprices,$list) ;
         }
         return $listprices;
}

function displayComanda($serv, $text){
$lines = file("$text");
$listprices = listprices($text);
$total = 0;
 if($serv !== "[]"){
  $servicii = json_decode($serv, true);
 
 foreach($servicii as $serv => $sr){
  echo "<div class='listaComenzi'>
         <div id='servicii'>$serv:</div>
         <div>";
       $sr = explode(",", $sr);
       foreach($sr as $s){
        echo "<div class='listaComenzi'>
               <div>$s</div>
               <div style = 'text-align:right'>".$listprices[$s]." Euro</div>
              </div>";
        $pret = $listprices[$s];
        $total += intval($pret);
       }
  echo  "</div>
         </div>
         <hr>";
    }
 } 
 return $total;
}

function verifServicii($serv){
  $verif_serv = ["Pachet mini", "Pachet mediu", "Pachet all remember", "Pachet standard", "Pachet profi",
  "Muzica pentru nunta traditionala", "Muzica pentru nunta moderna","All gen","Muzica de petrecere",
  "Muzica pop dance","Rock","Muzica etno","Muzica populara","Muzica instrumentala","Artificii",
  "Animatori","Aranjamente florare","Buchete nunta","Buchete cununie","Aranjamente baloane",
  "Cabina foto nunta","Candy bar","Ice cream bar","Cocktail bar","Tort nunta","Meniu 1","Meniu 2","Meniu 3",
  "Meniu 4","Decoratiuni botez","Muzica traditionala","Muzica moderna"];
  
  if(in_array($serv, $verif_serv)){
      return $serv;
  }else{
      return false;
  }
}
function verifEvent($event){
  $verif_event = ["nunta", "botez","majorat","aniversare"];
  if(in_array($event, $verif_event)){
      return $event;
  }else{
      return "";
  }
}


//functii manager

function verifComenzi($conn, $status){
    $sql = "SELECT ev.*, us.usersUsername FROM events ev
            JOIN users us ON ev.Users=us.usersId WHERE StatusEv = ?;"; 
     $stmt = mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt, $sql)){
         header("include: ../../signup.php?error=stmtfailed");
         exit();
     }
     mysqli_stmt_bind_param($stmt, "s", $status);
     mysqli_stmt_execute($stmt);
     $result_data = mysqli_stmt_get_result($stmt);
     if (mysqli_num_rows($result_data) > 0){
       
      while($row_data = mysqli_fetch_assoc($result_data)){
          $rows[] = $row_data;       
  }
  return $rows;
  }
  
  else{   
      return false;
  }
  mysqli_stmt_close($stmt);       
}

function preturiList($text){
 $lines = file($text);
 echo "<table>
      <tr><th>Produs</th><th>Pret</th></tr>";
  foreach($lines as $line){
    $list = json_decode($line,true);
    foreach($list as $produs => $pret){
      echo "
      <tr>
      <td><input style='width:250px;' type='text' name='produse[]' value='$produs' readonly></td>
      <td><input style='width:100px; text-align:center;' type='number' name='preturi[]' value='$pret'></td>";
    }
  }
  echo "</table>";    
}

function cererecomanda($serv){
 if($serv !== "[]"){
  $servicii = json_decode($serv, true);
  foreach($servicii as $servi => $sr){
    echo "<div class='listcom'>
          <div id='serv'>$servi : </div><div>";
    $sr = explode(",", $sr);
    foreach($sr as $s){
      echo "<div>$s</div>";
    }
    echo "</div>
         </div>
         <hr>";      
  } 
 }
}


function confirmcda($conn, $id, $serie){
 $sql = "UPDATE events SET StatusEv='Confirmat' WHERE Id=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
  header("location: ../manager.php?error=stmtfailed");
  exit();
 }
 mysqli_stmt_bind_param($stmt, "s", $id);
 mysqli_stmt_execute($stmt);
 mysqli_stmt_close($stmt);
 $cda = searchComanda($conn,$id,true,1);
 $email = $cda[0]['usersEmail'];
 $lname = $cda[0]['usersLast'];
 $fname = $cda[0]['usersFirst'];
$mesg = "<h3>Comanda nr. $serie a fost confirmata !</h3>
<p>Factura este atasata !</p>";
$to = $email;
$name = $fname;
$subj = "Confirmare comanda";
$from = "proiect.mihai.machete@gmail.com";
$namefrom = "Mihai";
$path = "../meniuri/factura.pdf";
$attach = true;
sendMail($mesg,$from,$to,$name,$subj,$path,$attach,$namefrom);      
       header("location: ../manager.php");
       exit();
}

function anularecda($conn, $id){
  $cda = searchComanda($conn,$id,true,1);
  $email = $cda[0]['usersEmail'];
  $lname = $cda[0]['usersLast'];
  $fname = $cda[0]['usersFirst'];
  $mesg ="<div><img src=\"../images/maillogo.jpeg\" alt='Happy events'></div>
        <hr>
        <h3>".$fname.' '.$lname.", cererea dv. a fost anulata !</h3>
        <h4>Incercati sa faceti comanda din nou.</h4>
        <p>Veti primi un email de confirmare !</p>";
        $to = $email;
        $name = $fname." ".$lname;
        $subj = "Anulare comanda";
        $from = "proiect.mihai.machete@gmail.com";
        $namefrom = "Mihai";
        $attach = false;
        $path = "";
        sendMail($mesg,$from,$to,$name,$subj,$path,$attach,$namefrom);
$sql = "DELETE FROM events WHERE Id=?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
      header("location: ../manager.php?error=stmtfailed");
      exit();
  }
  mysqli_stmt_bind_param($stmt,"s", $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../manager.php");
  exit();
}


//functii admin

function allusers($conn){
 $sql = "SELECT * FROM users;";
 $result = mysqli_query($conn, $sql);
 if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result)){
    $rows[] = $row;
   }
   return $rows;
 }
 else{
  return false;
 }
 mysqli_close($conn);
 header("location: admin.php");
 exit();
}

function deletUser($conn, $id){
  $sql = "DELETE FROM users WHERE usersId =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
      header("location: admin.php?error=stmtfailed");
      exit();
  }
  mysqli_stmt_bind_param($stmt,"s", $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: admin.php");
  exit();
}
function retravansUser($conn, $roll, $id){
  $sql = "Update users SET usersRol=? WHERE usersId = ? ";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
          header("location: admin.php?error=stmtfailed");
          exit();
      }
      
      mysqli_stmt_bind_param($stmt, "ss",$roll, $id ); 
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      header("location: admin.php");
}

//functii mail

function sendMail($mesg,$from,$_to,$name,$subj,$pathattach,$attachament,$namefrom){
  $send = "yes";
  $mesaj = $mesg;
  $fromm = $from;
  $email = $_to;
  $usernameul = $name;
  $subiect = $subj;
  $path = $pathattach;
  $attach = $attachament;
  $namefrom = $namefrom;
  include_once ("phpmailer/mail_cod.php");
}

//functii pdf

function createPdf($conn,$id,$pdf,$lat,$text){
        
  $furnizor='Happy Events S.R.L.';
  $reg_com_f='J12/3456/7890';
  $cif_f='RO12345678';
  $adresa_f='Oltenita, Jud. Calarasi';
  $iban_f='RO12345678910111213141516';
  $banc_f='BCR Oltenita';
  $capital='10000 RON';

  $y_save_1=$pdf->GetY();
  $pdf->SetDrawColor(80,150,255);
  $pdf->Cell($lat/6,4,'Furnizor: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,$furnizor,0,1,'L',0);
  $pdf->Cell($lat/6,4,'Reg. com.: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,$reg_com_f,0,1,'L',0);
  $pdf->Cell($lat/6,4,'CIF: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,$cif_f,0,1,'L',0);
  $pdf->Cell($lat/6,4,'Adresa: ','L',0,'L');
  $pdf->MultiCell($lat/6+10,4,$adresa_f,0,'L');
  $pdf->Cell($lat/6,4,'IBAN: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,$iban_f,0,1,'L',0);
  $pdf->Cell($lat/6,4,'Banca: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,$banc_f,0,1,'L',0);
  $pdf->Cell($lat/6,4,'Capital social: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,$capital,0,1,'L',0);
  
  $pdf->Ln(10);
  $y_save=$pdf->GetY();

  $listprices = listprices($text);
  $cda = searchComanda($conn,$id,true,1);
  $serv = [$cda[0]['Servicii'],$cda[0]['Decor'],$cda[0]['Catering']];

  $name = $cda[0]['usersLast']." ".$cda[0]['usersFirst'];
  $pdf->SetXY(10+2*$lat/3,$y_save_1);
  $pdf->Cell($lat/6,4,'Client: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,$name,0,1,'L',0);
  $pdf->SetXY(10+2*$lat/3,$y_save_1+4);
  $pdf->Cell($lat/6,4,'Reg. com.: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,'',0,1,'L',0);
  $pdf->SetXY(10+2*$lat/3,$y_save_1+8);
  $pdf->Cell($lat/6,4,'CIF: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,'',0,1,'L',0);
  $pdf->SetXY(10+2*$lat/3,$y_save_1+12);
  $pdf->Cell($lat/6,4,'Adresa: ','L',0,'L');
  $pdf->MultiCell($lat/6+10,4,'',0,'L');
  $pdf->SetXY(10+2*$lat/3,$y_save_1+16);
  $pdf->Cell($lat/6,4,'IBAN: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,'',0,1,'L',0);
  $pdf->SetXY(10+2*$lat/3,$y_save_1+20);
  $pdf->Cell($lat/6,4,'Banca: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,'',0,1,'L',0);
  $pdf->SetXY(10+2*$lat/3,$y_save_1+24);
  $pdf->Cell($lat/6,4,'Capital social: ','L',0,'L',0);
  $pdf->Cell($lat/6,4,'',0,1,'L',0);

  $pdf->SetXY(10,$y_save);
  $pdf->SetDrawColor(120);
  $pdf->SetFont('Arial','B',10);
      $pdf->Cell(11,6,'Nr.crt','LT',1,'L',0);
      $pdf->SetXY(21,$y_save);
      $pdf->Cell($lat/4,6,'Denumire serviciu',1,1,'L',0);
      $pdf->SetXY(21+$lat/4,$y_save);
      $pdf->Cell($lat/3,6,'Denumire produs',1,1,'L',0);
      $pdf->SetXY(21+$lat/4+$lat/3,$y_save);
      $pdf->Cell($lat/6,6,'Pret(fara TVA)',1,1,'C',0);
      $pdf->SetXY(21+$lat/4+$lat/3+$lat/6,$y_save);
      $pdf->Cell($lat/6,6,'Valoare TVA',1,1,'C',0);

      $pdf->SetFont('Arial','',10);
      $nrcrt = 0;
      $prettotal = 0;
  foreach($serv as $serviciu => $sr){
      $ser = json_decode($sr,true);
      foreach($ser as $srv => $sr){
          $nrcrt ++;
          $y_save=$pdf->GetY();
          $pdf->Cell(11,6,$nrcrt,'LTR',1,'L',0);
          $pdf->SetXY(21,$y_save);
          $pdf->Cell($lat/4,6,$srv." :",'T',1,'L',0);
      // $pdf->SetXY(20+$lat/4,$y_save);
          $sr = explode(",",$sr);
          $y_save_c=$y_save;
          $cell = 0;
      foreach ($sr as $cat){
          $pret = $listprices[$cat];
          $prettotal += intval($pret);
          $pftva = intval($pret) * 100/119;
          $pftva = number_format($pftva, 2, '.', '');
          $pctva = intval($pret) - floatval($pftva);
          $pctva = number_format($pctva, 2, '.', '');
          $cell++;
          $pdf->SetXY(21+$lat/4,$y_save_c);
          $pdf->Cell($lat/3,6,$cat,'RT',1,'L',0); 
          $pdf->SetXY(21+$lat/4+$lat/3,$y_save_c);
          $pdf->Cell($lat/6,6,$pftva." Euro",1,1,'R',0);
          $pdf->SetXY(21+$lat/4+$lat/3+$lat/6,$y_save_c);
          $pdf->Cell($lat/6,6,$pctva." Euro",1,1,'R',0);
          $y_save_c=$pdf->GetY();
         if(count($sr) > 1 && $cell < count($sr) ){
          $pdf->Cell(11,6,"",'LR',1,'L',0);
         }
          
      }
      
      }
      
  }
  $curs = curs_valutar("euro");
  $day = $curs["zi"];
  $month = $curs["luna"];
  $year = $curs["an"];
  $cursvalutar = (float)$curs["cursval"];
  $totallei = $cursvalutar*$prettotal;
  $totallei = number_format($totallei, 2, ".", " ");
  $pdf -> SetFont('Arial', 'B', 15);
  $pdf->Cell(41+$lat/2,8,'Total plata ','LTB',1,'R',0);
  $pdf->SetXY(51+$lat/2,$y_save_c);
  $pdf->SetTextColor(80,150,255);
  $pdf->Cell($lat/12+$lat/3-30,8,$prettotal.' Euro','RTB',1,'R',0);
  $pdf->SetTextColor(0);
  $pdf -> SetFont('Arial', 'B', 10);
  $pdf->Cell(11+$lat/4+2*$lat/3,4,"Curs valutar(BNR) la data $day $month $year: 1 euro = $cursvalutar lei","LRB",1,"L",0);
  $pdf -> SetFont('Arial', 'B', 15);
  $pdf->Cell(11+$lat/4+2*$lat/3,8,"Total plata:              $totallei lei","LRB",1,"R",0);
}

function nrFactura(){
  $nr = "";
  for($i=0;$i<4;$i++){
      $rand = rand(65,90);
      $nr .= chr($rand);
  }
  $rnd = rand(10000000,99999999);
  $nr .= $rnd;
  return $nr;
}

//functii alt site

function getPageContents($url) {
  $user_agent='Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/81.0';
  $options = array(
      CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
      CURLOPT_POST           =>false,        //set to GET
      CURLOPT_USERAGENT      => $user_agent, //set user agent
      CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
      CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
      CURLOPT_RETURNTRANSFER => true,     // return web page
      CURLOPT_HEADER         => false,    // don't return headers
      CURLOPT_FOLLOWLOCATION => true,     // follow redirects
      CURLOPT_ENCODING       => "",       // handle all encodings
      CURLOPT_AUTOREFERER    => true,     // set referer on redirect
      CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
      CURLOPT_TIMEOUT        => 120,      // timeout on response
      CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
  );
  $ch = curl_init($url);
  curl_setopt_array($ch, $options);
  $content = curl_exec($ch);
  $err = curl_errno($ch);
  $errmsg = curl_error($ch);
  $header = curl_getinfo($ch);
  curl_close($ch);

  $header['errno'] = $err;
  $header['errmsg'] = $errmsg;
  $header['content'] = $content;
  return $header;
}

function curs_valutar($valuta) {
  $valuta = strtolower($valuta);
  $header = getPageContents("https://www.cursbnr.ro/curs-$valuta");
  $html = $header['content'];
  $doc = new DOMDocument();
  @$doc->loadHTML($html);
  $finder = new DomXPath($doc);
  $titlu = $finder->query("/html/head/title")[0];
   
  if ($titlu->nodeValue == "Curs Euro - Curs EUR | Curs BNR") {
      $node = $finder->query("/html/body/div[3]/div[1]/div[1]/main/div[2]/div[1]/div[1]/div[3]")[0];//div[1]/div[1]/div[2]//div[1]/div[1]/div[3]/table/td[1]
      $val = $node->nodeValue;
      $toks = explode(" ", $val);           
      $day = $toks[7];
      $month = $toks[8];            
      $str = $toks[9];
      $year = substr($str,0,4);
      $cursval = substr($str,4,6);
      
      $params["zi"] = $day;
      $params["luna"] = $month;
      $params["an"] = $year;
      $params["cursval"] = (float)$cursval;
     
      return $params;
  } else {
      $node = $finder->query("/html/head/meta[13]")[0];
      $url = $node->getAttribute("content");
      $toks = explode("/", $url);
      return (int) $toks[count($toks) - 1];
  }
}