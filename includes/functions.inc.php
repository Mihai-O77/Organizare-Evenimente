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
  $sql = "UPDATE users SET usersVisit=? WHERE usersId = ? ";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
      header("location: ../profile.php?error=stmtfailed");
      exit();
  }
  
  mysqli_stmt_bind_param($stmt, "ss",$CURRENT_TIMESTAMP, $userid ); 
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  exit();
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
$select = "SELECT * FROM events WHERE Users=?; ";
}
else{
$select = "SELECT ev.*, us.usersFirst, us.usersLast FROM events ev 
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
      $result = [$seria, $dateEv, $comJson, $statusAfisare, $rest];
      return $result;
    
    }else
    { 
      echo "<h2>Nu aveti comenzi </h2>";
    } 
}


function displayComanda($serv, $text){
$lines = file("$text");
$listprices = [];
 foreach($lines as $line){
  $list = json_decode($line, true);
  $listprices = array_merge($listprices, $list);
 }
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
//  $mesg = "<h3>Comanda nr. $serie a fost confirmata !</h3>
//   <p>Factura este atasata !</p>";
//   $to = 'proiect.web.gusti@gmail.com';
//   $name = "Augustus";
//   $subj = "Confirmare comanda";
//   $path = "../../texts/factura.pdf";
//   $attach = true;
//   sendMail($mesg,$to,$name,$subj,$path,$attach);       
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

