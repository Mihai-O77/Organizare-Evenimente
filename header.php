<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proiect Organizare Evenimente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
</head>

<body>

<div class="nav">
    <h1>Organizare Evenimente</h1>
    <ul class="meniuOrizantala">
        <li> <a href="index.php">Home</a> </li>
        <?php
        if(isset($_SESSION["username"])){
           echo "<li> <a href='profile.php'>Profile</a> </li>";
           echo "<li class='hoverul'>Evenimente
            <div class='evenimente'>
               <a href='nunta.php'>Nunta</a>
               <a href='botez.php'>Botez</a>
               <a href='petrCopii.php'>Petrecere copii</a>
               <a href='conferinta.php'>Conferinta</a>
               <a href='aniversare.php'>Aniversare</a> 
            </div>
            
        </li>";
       echo "<li> <a href='includes/logout.inc.php'>Log out</a> </li>";
        }
        else{
        echo "<li> <a href='login.php'>Login</a> </li>";
        echo "<li> <a href='signup.php'>Sign up</a> </li>";
        }
        ?>
        
        
        
    </ul>
</div>
