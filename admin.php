<?php 
include_once"header.php";
if(!isset($_SESSION['usersUsername']) || $_SESSION['rol'] !=="admin"){
    header("location: index.php");
}
require_once("includes/functions.inc.php");
require_once("includes/connection.db.php");


$comenzi = searchComanda($conn, $_SESSION["userid"], true, 0);

?>

<section>
    <form id="usdet" action="admin.php" method="post">
    <div class='divflex'>
        <div><button class='btn red'  type='submit' name='del'>Delete</button></div>
        <div><button class='btn'  type='submit' name='user'>Lista User</button></div>
        <div><button class='btn'  type='submit' name='manager'>Lista Manager</button></div>
        <div><button class='btn'  type='submit' name='avansare'>Avansare</button></div>
        <div><button class='btn' type='submit' name='retrogradare'>Retrogradare</button></div>
    </div>
    </form>
<table>Clienti
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
   <td>".$user['usersFirst']." ".$user['userLastName']."</td>
   <td>".$user['usersEmail']."</td>";
   if($client === "user"){
    echo"<td>$comenzi</td>";
   }
   
   echo "<td>".$user['usersVisit']."</td>
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
        $comenzi = searchComanda($conn, $id, false, 1);
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

 <!-- <?php 
if(isset($_POST['mail'])){
    $message = "Ai primit un email !";
    $_to = 'proiect.web.gusti@gmail.com';
    $name = "Augustus";
    $subject = "Test mail";
    include_once"private/phpmailer/mail_cod.php";
}
?>  -->
</section>




<?php 
include_once"footer.php";
?>