<?php
include_once("header.php");
?>

<section>
 <div class="login">
   <form action="includes/signup.inc.php" method="post">
    Username<br><input type="text" name="username"><br><br>
    Email<br><input type="email" name="email"><br><br>
    Password<br><input type="password" name="pwd"><br><br>
    Password Repeat<br><input type="password" name="pwdr"><br><br>
    First Name<br><input type="text" name="fname"><br><br>
    Last Name<br><input type="text" name="lname"><br><br>
    <div class="g-recaptcha" data-sitekey="6Ldh2twjAAAAAMs1L40KgiJtld0jzXWOHYy_fCuV"></div> 
    <button name="submit" type="submit">Sign up</button>
   </form> 
 </div>
 <div class="msgError"> 
 <?php
 if(isset($_GET["error"])){
  switch($_GET["error"]){
    case "invalidusername": echo "Username-ul nu este valid"; break;
    case "invalidemail": echo "Email-ul nu este valid"; break;
    case "invalidpassword": echo "Parola trebuie sa fie intre 5 si 16 caractere"; break;
    case "pwdsdontmatch": echo "Parolele nu se potrivesc"; break;
    case "invalidFname": echo "Prenumele este invalid"; break;
    case "invalidLname": echo "Numele de familie este invalid"; break;
    case "emptyinput": echo "Nu ai completat tot formularul"; break;
    case "useralreadyexists": echo "Utilizatorul exista deja"; break;
    case "recaptcha": echo "Nu ai verificat recaptcha"; break;
  }  
 }
 ?>
 </div>   
</section>

<?php
include_once("footer.php");
?>