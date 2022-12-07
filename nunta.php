<?php 
include_once("header.php");
?>

<section>
<div class="divtop">    
<div class="descr">
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

<div class="options">

<ol> Servicii profesioniste:
 <li><label class="box"><input type="checkbox" name="fotograf"> Fotograf
    <div class="none">
      <label><input type="radio" name="foto" value="300" checked="checked"> Pachet mini</label>
      <label><input type="radio" name="foto" value="600"> Pachet mediu</label> 
      <label><input type="radio" name="foto" value="900"> Pachet all remembers</label>   
    </div> 
    </label>
 </li>
 
 <li><label class="box"><input type="checkbox" name="cameraman"> Cameraman 
    <div class="none">
      <label><input type="radio" name="video" value="500" checked="checked"> Pachet standard</label>
      <label><input type="radio" name="video" value="1100"> Pachet profi</label>   
    </div>
    </label> 
</li>

<li><label class="box"><input type="checkbox" name="dj"> DJ nunta
        <div class="none">
            <label><input type="radio" name="djs" value="1200" checked="checked"> Muzica pentru nunta traditionala </label>
            <label><input type="radio" name="djs" value="1200"> Muzica pentru nunta moderna</label>
            <label><input type="radio" name="djs" value="2300"> All gen</label>
        </div>
    </label>
</li>
<li><label class="box"><input type="checkbox" name="formatie"> Formatie nunta
        <div class="none">
            <label><input type="checkbox" name="music1" value="200" checked="checked"> Muzica de petrecere </label>
            <label><input type="checkbox" name="music2" value="200"> Muzica pop dance</label>
            <label><input type="checkbox" name="music3" value="200"> Rock</label>
            <label><input type="checkbox" name="music4" value="200"> Muzica etno </label>
            <label><input type="checkbox" name="music5" value="200"> Muzica populara</label>
            <label><input type="checkbox" name="music6" value="200"> Muzica instrumentala</label>
        </div>
    </label>
</li>

<li id="artif"><label><input type="checkbox" name="artificii" value="200"> Artificii</label></li>
<li id="animator"><label><input type="checkbox" name="animator" value="600"> Animatori</label></li>
</ol>

<ol>Decor nunta:
<li><label id="flori"><input type="checkbox" name="flori"> Aranjamente florare</label></li>
<li><label id="buchetnunta"><input type="checkbox" name="buchetenunta"> Buchete nunta</label></li>
<li><label id="buchetcun"><input type="checkbox" name="buchetecununie"> Buchete cununie</label></li>
<li><label id="baloane"><input type="checkbox" name="baloane"> Aranjamente baloane</label></li>
<li><label ><input type="checkbox" name="cabinafoto"> Cabina foto nunta</label></li>
</ol>

<ol>Catering:
<li><label><input type="checkbox" name="candy" value="300"> Candy bar</label></li>
<li><label><input type="checkbox" name="icecream" value="300"> Ice cream bar</label></li>
<li><label><input type="checkbox" name="cocktail" value="400"> Cocktail bar</label></li>
<li><label id="tort"><input type="checkbox" name="tort"> Tort nunta</label></li>
<li><label id="meniu"><input type="checkbox" name="meniu"> Meniu</label></li>
</ol>

</div>
</section>

<?php
include_once("footer.php");
?>