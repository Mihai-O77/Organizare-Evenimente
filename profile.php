<?php
include_once("header.php");
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
if(isset($_POST["cont"]) || isset($_POST["updatecont"])){
    echo"<div class='datecont'>
           <ul>
            <li>Username: ".$_SESSION['username']."</li>
            <li>First Name: ".$_SESSION['fname']."</li>
            <li>Last Name: ".$_SESSION['lname']."</li>
            <li>Email: ".$_SESSION['email']."</li>
           </ul>
           <button form='profil' type='submit' name='modifica'>Administreaza datele tale</button>
         </div>";
}
?>


<?php
if(isset($_POST["modifica"]) || isset($_GET["error"])){
echo "<section id='modifica'>
      <div class='login updatecont'>
        <form action='includes/profile.inc.php' method='post'>

        <div class='rowform'>
        <label for='user'>Username</label>
        <input id='user' type='text' name='username' placeholder='Username' value=".$_SESSION['username'].">
        </div><br><br>
        
        <div class='rowform'>
        <label for='fname'>First Name</label>
        <input id='fname' type='text' name='firstname' placeholder='First Name' value=".$_SESSION['fname'].">
        </div><br><br>

        <div class='rowform'>
        <label for='lname'>Last Name</label>
        <input id='lname' type='text' name='lastname' placeholder='Last Name' value=".$_SESSION['lname'].">
        </div><br><br>

        <div class='rowform'>
        <label for='email'>Email</label>
        <input id='email' type='text' name='email' placeholder='Email' value=".$_SESSION['email'].">
        </div><br><br>

        <button type='submit' name='updatecont'>Salveaza</button>

        </form>
      </div>
      </section>";
      if(isset($_GET["error"])){
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
  $comenzi = searchComanda($conn, $_SESSION["userid"]);
  //print_r($comenzi);
  echo "<div class='datecont comenzi'> <h2>Comenzile mele</h2>";
        if($comenzi){
          foreach($comenzi as $com){
            $comJson = json_encode($com);
            $dateEv = $com["nuntaData"];
            $date = strtotime($dateEv);
            $date = date("Y/m/d", $date);
            $now = date("Y/m/d");
            $status = $com["nuntaStatus"];

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

            echo "<div class='produs'>

                  <div class='prod'>

                  <div>
                  Comanda <span>N.2775".$com["nuntaId"]." din <span>$dateEv.</span></span>
                  </div>

                  <button form='profile' type='submit' name='detalii' value='$comJson'> Detalii comanda</button>
                  </div>

                  <div class='prod'>
                  <div>
                  Status: <span>$status</span>
                  </div>
                  <div>
                  $rest
                  </div>
                  </div> 
                  </div>";
          }
        }
  echo "</div>";
        
}

?>
</div>
</div>
















<?php
include_once("header.php");
?>