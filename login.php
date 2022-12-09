<?php
include_once("header.php");
?>

<section>
 <div class="login">
   <form action="includes/login.inc.php" method="post">
    Username/Email<br><input type="text" name="username"><br><br>
    Password<br><input type="password" name="pwd"><br><br>
    <button name="submit" type="submit">Login</button>
   </form> 
 </div>
 <div class="msgError">
 <?php
 if(isset($_GET["error"])){
  switch($_GET["error"]){
    case "emptyinput": echo "Nu ai completat toate campurile"; break;
    case "wronglogin": echo "Username sau parola incorecte"; break;
  }
 }
 ?>
 </div>
</section>

<?php
include_once("footer.php");
?>