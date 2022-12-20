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
    session_start();
    $_SESSION["username"] = $userExist["usersUsername"];
    $_SESSION["userid"] = $userExist["usersId"];
    $_SESSION["fname"] = $userExist["usersFirst"];
    $_SESSION["lname"] = $userExist["usersLast"];
    $_SESSION["email"] = $userExist["usersEmail"];
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

function createNunta($conn, $username, $servicii, $decor, $catering, $data){
  $insert = "INSERT INTO nunta ( nuntaUsers, nuntaServicii, nuntaDecor, nuntaCatering, nuntaData) VALUE (?,?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $insert)){
     header("location: ../signup.php?error=stmtfail");
     exit();
  }
  
  mysqli_stmt_bind_param($stmt, "sssss", $username, $servicii, $decor, $catering, $data);
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