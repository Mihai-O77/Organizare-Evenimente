<?php
include_once("header.php");
if(!$_SESSION["username"] || $_SESSION["rol"]!=="user"){
  header("location: index.php");
  exit();
}

require_once("includes/connection.db.php");
require_once("includes/functions.inc.php");
?>

<div class="divflex profile">

<div class="menuprofile">
<form action="profile.php" method="post" id="profil">
<button class="meniuBtn" type="submit" name="cont">Contul meu <span>></span></button>
<button class="meniuBtn" type="submit" name="comenzi">Comenzile mele <span>></span></button>
</form>
</div>

<div class="details">
<?php
  $username = $_SESSION['username'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $email = $_SESSION['email'];
if(isset($_POST["cont"]) || isset($_POST["updatecont"])){ 
  ?>
    <div class='datecont'>
           <ul>
            <li>Username: <?php echo "$username";?></li>
            <li>First Name:<?php echo "$fname";?></li>
            <li>Last Name:<?php echo "$lname";?></li>
            <li>Email:<?php echo "$email";?></li>
           </ul>
           <button form='profil' type='submit' name='modifica' class='btnCont'>Administreaza datele tale</button>
         </div>
<?php }




if(isset($_POST["modifica"]) || isset($_GET["error"])){?>
      <section id='modifica'>
      <div class='login updatecont'>
        <form  action='includes/profile.inc.php' method='post'>

        <div class='rowform'>
        <label for='user'>Username</label>
        <input id='user' type='text' name='username' placeholder='Username' value=<?php echo "$username";?>>
        </div><br><br>
        
        <div class='rowform'>
        <label for='fname'>First Name</label>
        <input id='fname' type='text' name='firstname' placeholder='First Name' value=<?php echo "$fname";?>>
        </div><br><br>

        <div class='rowform'>
        <label for='lname'>Last Name</label>
        <input id='lname' type='text' name='lastname' placeholder='Last Name' value=<?php echo "$lname";?>>
        </div><br><br>

        <div class='rowform'>
        <label for='email'>Email</label>
        <input id='email' type='text' name='email' placeholder='Email' value=<?php echo "$email";?>>
        </div><br><br>

        <button type='submit' name='updatecont'>Salveaza</button>

        </form>
      </div>
      </section>
      <?php if(isset($_GET["error"])){
        switch($_GET["error"]){
            case "emptyinput": echo "Nu ati completat un camp"; break;
            case "invalidusername": echo "Username este invalid"; break;
            case "invalidFname": echo "First Name este invalid"; break;
            case "invalidLname": echo "Last Name este invalid"; break;
            case "invalidemail": echo "Email este invalid"; break;
            case "usertaken": echo "Userul deja folosit"; break; 
        }    
        } 
    } 

if(isset($_POST["comenzi"])){
  $comenzi = searchComanda($conn, $_SESSION["userid"], true, 0);?>
  <div class='datecont comenzi'> <h2>Comenzile mele</h2>
  <?php foreach($comenzi as $com){
  $raspuns = listaComenzi($com);
  // $result = [$seria, $dateEv, $comJson, $status, $rest, $cdadata];
  ?>
        
                  <div class='produs'>
                  <div class='prod'>
                  <div>Comanda <span><?php echo "$raspuns[0]";?><span> din <?php echo "$raspuns[5]";?>.</span></span> </div>
                  <button form='profil' type='submit' name='detalii' value='<?php echo "$raspuns[2]";?>'> Detalii comanda</button></div>
                  <div class='prod'>
                  <div>Status: <span><?php echo "$raspuns[3]"?></span></div>
                  <div><?php echo "$raspuns[4]";?></div>
                  </div> 
                  </div>
  <?php } ?>
  </div>
        
<?php } 
if(isset($_POST['detalii'])){
  $comz = $_POST['detalii'];
  $valobiect = json_decode($comz, true);
  $id = $valobiect["Id"];
  $eveniment = $valobiect["eveniment"];
  $dataeveniment = $valobiect["eventData"];
  $datacomanda = $valobiect["comandaData"];
  $seria = serie($eveniment);
  $seria .= $id;
?>

<div class="datecont comenzi"> <h3>Comanda numarul <?php echo"$seria";?> din <?php echo"$datacomanda"; ?></h3> <br>
                               <h3>Evenimentul va avea loc la data <?php echo"$dataeveniment"; ?></h3>
                                <br><br>
 <?php 
 $tot = displayComanda($valobiect["Servicii"], "meniuri/preturi.txt") +
        displayComanda($valobiect["Decor"], "meniuri/preturi.txt") +
        displayComanda($valobiect["Catering"], "meniuri/preturi.txt");
 ?>
 <div><span>Total: <?php echo"$tot" ?> Euro</span></div>
</div>

</div>
</div>
<?php
}
?>


<?php
include_once("header.php");
?>