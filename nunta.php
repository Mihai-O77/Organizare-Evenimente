<?php 
include_once("header.php");
?>

<section>
<div class="divtop">    
<div class="descrEv">
    <h2>Descrierea evenimentului</h2>
    <h3>Nunta</h3>
    <p>Visezi de multa vreme la nunta perfecta? Iti doresti ca ziua in care vei spune 
        "DA" sa fie lipsita de stres? Contacteaza o agentie de organizare nunta si visul 
        tau va deveni realitate!</p>
<p>
Vei primi raspuns la toate intrebarile tale si te vei bucura de o nunta ca-n povesti. Organizarea unei nunti poate fi un proces foarte stresant, deoarece trebuie luate in calcul multe aspecte si exista posibilitatea sa iei anumite decizii pe care sa ajungi sa le regreti mai tarziu.
 Nu vei sti ce sa cauti, unde poti gasi cele mai bune oferte sau la ce sa te astepti.</p>
</div>
<div class="imgtop">
        <img class="imagheaderdreapta"  src="images/nunta.jpeg" alt="nunta">
    </div>
</div>

<form class="form" action="includes/nunta.inc.php" method="post">
<div class="options">

<ol> Servicii profesioniste:
 <li><label class="box"><input type="checkbox" name="fotograf"> Fotograf
    <div class="none">
      <label><input type="radio" name="foto" value="Pachet mini" checked="checked"> Pachet mini</label>
      <label><input type="radio" name="foto" value="Pachet mediu"> Pachet mediu</label> 
      <label><input type="radio" name="foto" value="Pachet all remembers"> Pachet all remembers</label>   
    </div> 
    </label>
 </li>
 
 <li><label class="box"><input type="checkbox" name="cameraman"> Cameraman 
    <div class="none">
      <label><input type="radio" name="video" value="Pachet standard" checked="checked"> Pachet standard</label>
      <label><input type="radio" name="video" value="Pachet profi"> Pachet profi</label>   
    </div>
    </label> 
</li>

<li><label class="box"><input type="checkbox" name="dj"> DJ nunta
        <div class="none">
            <label><input type="radio" name="djs" value="Muzica pentru nunta traditionala" checked="checked"> Muzica pentru nunta traditionala </label>
            <label><input type="radio" name="djs" value="Muzica pentru nunta moderna"> Muzica pentru nunta moderna</label>
            <label><input type="radio" name="djs" value="All gen"> All gen</label>
        </div>
    </label>
</li>
<li><label class="box"><input type="checkbox" name="formatie"> Formatie nunta
        <div class="none">
            <label><input type="checkbox" name="music[]" value="Muzica de petrecere" checked="checked"> Muzica de petrecere </label>
            <label><input type="checkbox" name="music[]" value="Muzica pop dance"> Muzica pop dance</label>
            <label><input type="checkbox" name="music[]" value="Rock"> Rock</label>
            <label><input type="checkbox" name="music[]" value="Muzica etno"> Muzica etno </label>
            <label><input type="checkbox" name="music[]" value="Muzica populara"> Muzica populara</label>
            <label><input type="checkbox" name="music[]" value="Muzica instrumentala"> Muzica instrumentala</label>
        </div>
    </label>
</li>

<li id="artif"><label><input type="checkbox" name="artificii" value="Artificii"> Artificii</label></li>
<li id="animator"><label><input type="checkbox" name="animatori" value="Animatori"> Animatori</label></li>
</ol>

<ol>Decor nunta:
<li><label id="flori"><input type="checkbox" name="decor[]" value="Aranjamente florare"> Aranjamente florare</label></li>
<li><label id="buchetnunta"><input type="checkbox" name="decor[]" value="Buchete nunta"> Buchete nunta</label></li>
<li><label id="buchetcun"><input type="checkbox" name="decor[]" value="Buchete cununie"> Buchete cununie</label></li>
<li><label id="baloane"><input type="checkbox" name="decor[]" value="Aranjamente baloane"> Aranjamente baloane</label></li>
<li><label ><input type="checkbox" name="decor[]" value="Cabina foto nunta"> Cabina foto nunta</label></li>
</ol>

<ol>Catering:
<li><label><input type="checkbox" name="mancare[]" value="Candy bar"> Candy bar</label></li>
<li><label><input type="checkbox" name="mancare[]" value="Ice cream bar"> Ice cream bar</label></li>
<li><label><input type="checkbox" name="mancare[]" value="Cocktail bar"> Cocktail bar</label></li>
<li><label id="tort"><input type="checkbox" name="mancare[]" value="Tort"> Tort nunta</label></li>
<li><label id="meniu"><input type="checkbox" name="mancare[]" value="Meniu"> Meniu</label></li>
</ol>

</div>
<button class="btnConfirm" type="submit" name="submit"> Confirm</button>
</form>
</section>

<?php
include_once("footer.php");
?>