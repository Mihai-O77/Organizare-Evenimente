<?php
include_once("header.php");
?>

<section class="homebkg">
    <div class="descriereppag">
     <?php
     if(isset($_SESSION["username"])){
     echo "<p> Acum ca te-ai logat poti incepe costumizarea unui eveniment. </p>";
    }
    else{
     echo "   
        <h1>
         Organizare de evenimente in cateva click-uri
        </h1>
    <br>
    <p>
    Inregistrati-va, alege-ti un eveniment si incepeti costumizarea acestuia pentru a se potrivi cu preferintele voastre. Puteti sa ne transmiteti exact cum doriti sa fie aranjata locatia, cine sa vina la evenimentul vostru ca invitat special 
    si ce companii sa se ocupe de amenajare prin bifarea optiunilor dorite pe care vi le punem la dispozitie pentru evenimentul respectiv. Unde este vorba de multe /detalii vi se pune la dispozitie un textbox in care puteti explica ce doriti/ 
    veti discuta despre ele cu un organizator dupa ce terminati de completat ce doriti la eveniment in general pe site, pentru a ne creea o idee.
    </p>";
     }
    ?>
    </div>
</section>







<?php
include_once("footer.php");
?>
    
