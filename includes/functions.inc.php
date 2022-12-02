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
if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
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
    if(!preg_match("/^[a-zA-Z]*$/", $firstName)){
    $result= true;
    }
    else{
      $result= false;
    }
    return $result;
}

function invalidLname($lastName){
    $result;
    if(!preg_match("/^[a-zA-Z]*$/", $lastName)){
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
    header("location: ../index.php");
    exit();
  }
}