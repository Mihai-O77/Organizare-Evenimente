<?php
include_once("header.php");
?>

<section>
 <div class="login">
   <form action="includes/login.inc.php" method="post">
    Username/Email<br><input type="text" name="username"><br><br>
    Password<br><input type="password" name="pwd"><br><br>
    <div class="g-recaptcha" data-sitekey="6Ldh2twjAAAAAMs1L40KgiJtld0jzXWOHYy_fCuV"></div>
    <button name="submit" type="submit">Login</button>
   </form> 
 </div>
 <div class="msgError">
 <?php
 if(isset($_GET["error"])){
  switch($_GET["error"]){
    case "emptyinput": echo "Nu ai completat toate campurile"; break;
    case "wronglogin": echo "Username sau parola incorecte"; break;
    case "recaptcha": echo "Nu ai verificat recaptcha"; break;
  }
 }
 ?>
 </div>
</section>

<?php
include_once("footer.php");
?>