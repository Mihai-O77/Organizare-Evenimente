<?php
include_once("header.php");
?>

<section>
 <div>
   <form action="includes/login.inc.php" method="post">
    Username/Email<br><input type="text" name="username"><br><br>
    Password<br><input type="text" name="pwd"><br><br>
    <button name="submit" type="submit">Login</button>
   </form> 
 </div>   
</section>

<?php
include_once("footer.php");
?>