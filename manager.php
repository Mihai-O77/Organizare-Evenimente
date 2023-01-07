<?php 
include_once("header.php");
if(!$_SESSION["username"] || ($_SESSION["rol"]!=="manager" && $_SESSION["rol"]!=="admin")){
    header("location: index.php");
    exit();
}

require_once("includes/functions.inc.php");
require_once("includes/connection.db.php");

$comz = verifComenzi($conn, "Cerere");
$news = 0;
if($comz){
  foreach($comz as $com){
   $news++; 
  }  
}
?>

<form action="manager.php" method="post" id="formmanager"></form>
<div class="menuManager">
   
   <ul>
        <li><button form="formmanager" type="submit" name="preturi">Preturi</button></li>
        <li><button form="formmanager" type="submit" name="newcomenzi">Comenzi: 
         <span id='info'><?php echo" $news";?></span></button></li>
      </ul>
      
   </div>
   <div class="preturi">
   <?php
   if(isset($_POST['preturi'])){?>
      
      <div>
      <form  action='includes/manager.inc.php' method='post'>
      <?php preturilist('meniuri/preturi.txt'); ?>
      <button class='btnsave' type='submit' name='pret'>Salveaza</button>
      </form>
      </div>  
   <?php } 
   if(isset($_POST['newcomenzi'])){
            if($comz){
      foreach($comz as $com){
         $idcda = $com['Id'];
         $useridsearch = $com['Users'];
         $user =  $com['usersUsername'];
         $comdate = $com['eventData'];
         $eveniment = $com['eveniment'];
          ?>
         <div class='managercomenzi'>
         <div>Username:<?php echo "$user"; ?></div>
         <div>Comanda din:<?php echo "$comdate"; ?>
         </div>
         
         <?php
          cererecomanda($com['Servicii']);
          cererecomanda($com['Decor']);
          cererecomanda($com['Catering']); 
          ?>
          
      
         <form  action='includes/manager.inc.php' method='post'> 
         <input type='hidden' name='id' value='<?php echo "$idcda"; ?>'>
         <input type='hidden' name='event' value='<?php echo "$eveniment"; ?>'>
         <div>
            <button class='btnsave' type='submit' name='confirmare'>Confirmare</button>
            <button class='btnsave' type='submit' name='anulare'>Anulare</button>
         </div>
         </form>
         </div>
          <br><br>

          <?php
           }}
         else{
            echo"<h2>Nu sunt comenzi noi !</h2>";
         }
         }
         ?>
   
    
   
</div>







<?php
include_once("footer.php");
?>