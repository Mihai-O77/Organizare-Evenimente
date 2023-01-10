<?php 
include_once("header.php");
if(!isset($_SESSION["username"]) || $_SESSION["rol"]!=="admin"){
    header("location: index.php");
}
require_once("includes/functions.inc.php");
require_once("includes/connection.db.php");


$comenzi = searchComanda($conn, $_SESSION["userid"], true, 0);

?>

<section>
    <form id="usdet" action="admin.php" method="post">
    <div class='divflex'>
        <div><button class='btnAdmin'  type='submit' name='del'>Delete</button></div>
        <div><button class='btnAdmin'  type='submit' name='user'>Lista User</button></div>
        <div><button class='btnAdmin'  type='submit' name='manager'>Lista Manager</button></div>
        <div><button class='btnAdmin'  type='submit' name='avansare'>Avansare</button></div>
        <div><button class='btnAdmin' type='submit' name='retrogradare'>Retrogradare</button></div>
    </div>
    </form>
<table class="tabelAdmin"><div id="clienti">Clienti:</div>
<tr>
<th>Select</th>
    <th>Rol</th>
    <th>Username</th>
    <th>Nume</th>
    <th>Email</th>  
    <?php 
    if(!isset($_POST['manager'])){
        echo "<th>Nr.comenzi</th>";
    }
    ?>
    <th>Ultima accesare</th>
    <th>Numar accesari</th>

</tr>
<?php

if($all = allusers($conn)){
    $client = "user";
    if(isset($_POST['manager'])){
        $client = 'manager';
    }
foreach($all as $user){

    if($user['usersRol'] === $client){

    $us = $user['usersId'];
    $comenzi = searchComanda($conn, $us, false, 0);
   echo "<tr>
   <td><input form='usdet' type='checkbox' name='select[]' value='$us'></td>
   <td>".$user['usersRol']."</td>
   <td>".$user['usersUsername']."</td>
   <td>".$user['usersFirst']." ".$user['usersLast']."</td>
   <td>".$user['usersEmail']."</td>";
   if($client === "user"){
    echo"<td>$comenzi</td>";
   }
   
   echo "<td>".$user['usersVisit']."</td>
         <td>".$user['usersAccesari']."</td>
   </tr>";
   }
} 
if(isset($_POST['del'])){
    if(isset($_POST['select'])){
      $ids = $_POST['select'];
    foreach($ids as $id){
        deletUser($conn, $id);
    }}}
if(isset($_POST['avansare'])){
    $roll = "manager";
    if(isset($_POST['select'])){
      $ids = $_POST['select'];  
    foreach($ids as $id){
        $comenzi = searchComanda($conn, $id, false, 0);
        if($comenzi === false){
        retravansUser($conn, $roll, $id);
    }}}}

    if(isset($_POST['retrogradare'])){
        $roll = "user";
         if(isset($_POST['select'])){
          $ids = $_POST['select'];   
        foreach($ids as $id){  
            retravansUser($conn, $roll, $id);
        }}}
       
        
        
}

?>

</table>
</section>




<?php 
include_once("footer.php");
?>