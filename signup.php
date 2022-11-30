<?php
include_once("header.php");
?>

<section>
 <div>
   <form action="includes/signup.inc.php" method="post">
    Username<br><input type="text" name="username"><br><br>
    Email<br><input type="email" name="email"><br><br>
    Password<br><input type="password" name="pwd"><br><br>
    Password Repeat<br><input type="password" name="pwdr"><br><br>
    First Name<br><input type="text" name="fname"><br><br>
    Last Name<br><input type="text" name="lname"><br><br>
    <button name="submit" type="submit">Sign up</button>
   </form> 
 </div>   
</section>

<?php
include_once("footer.php");
?>