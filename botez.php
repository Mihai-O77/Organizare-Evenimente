<?php 
include_once("header.php");
if(!$_SESSION["username"] || $_SESSION["rol"]!=="user"){
    header("location: index.php");
    exit();
}

require_once("includes/functions.inc.php");
?>

<section>
<div class="divtop">    
<div class="descrEv">
    <h2>Descrierea evenimentului</h2>
    <h3>Botez</h3>
    <p>Venirea pe lume a unui copil este un motiv de bucurie si trebuie sarbatorita corespunzator.
         Micutul tau merita un botez ca la carte, iar cea mai buna optiune este sa apelezi la
          o agentie profesionista de organizare botez. Pret? Acesta va fi stabilit in functie 
          de mai multi factori, dar daca vei alege agentia noastra, vei beneficia de o oferta
           avantajoasa. </p>
<p>
In plus, in acest mod vei scapa de stresul organizarii si te vei putea bucura la maximum de
 petrecerea organizata in cinstea micutului tau!</p>
 <p>
 O firma de organizare botez iti poate pune la dispozitie toate serviciile necesare pentru 
 un eveniment de nota 10! Crestinarea copilului tau se va desfasura in cele mai bune conditii,
  iar petrecerea va fi de neuitat!</p>
</div>
<div class="imgtop">
        <img class="imagheaderdreapta"  src="images/botez.jpeg" alt="botez">
    </div>
</div>

<form class="form" action="includes/events.inc.php" method="post">
<div class="options">

<label><input type="date" name="date">Data botezului</label>
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

<li><label class="box"><input type="checkbox" name="dj"> DJ
        <div class="none">
            <label><input type="radio" name="djs" value="Muzica pentru nunta traditionala" checked="checked"> Muzica traditionala </label>
            <label><input type="radio" name="djs" value="Muzica pentru nunta moderna"> Muzica moderna</label>
            <label><input type="radio" name="djs" value="All gen"> All gen</label>
        </div>
    </label>
</li>
<li><label class="box"><input type="checkbox" name="formatie"> Formatie
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
</ol>

<ol>Decor:
<li><label><input type="checkbox" name="decor[]" value="Aranjamente florare"> Aranjamente florare</label></li>
<li><label><input type="checkbox" name="decor[]" value="Aranjamente baloane"> Aranjamente baloane</label></li>
<li><label><input type="checkbox" name="decor[]" value="Decoratiuni botez"> Decoratiuni botez</label></li>
<li><label ><input type="checkbox" name="decor[]" value="Cabina foto nunta"> Cabina foto</label></li>
</ol>

<ol>Catering:
<li><label><input type="checkbox" name="mancare[]" value="Candy bar"> Candy bar</label></li>
<li><label><input type="checkbox" name="mancare[]" value="Ice cream bar"> Ice cream bar</label></li>
<li><label><input type="checkbox" name="mancare[]" value="Cocktail bar"> Cocktail bar</label></li>
<li><label id="tort"><input type="checkbox" name="mancare[]" value="Tort"> Tort</label></li>
<li><label class="box"><input type="checkbox" name="menu"> Meniu
        <div class="none">
            <label class="showmenu"><input type="radio" name="meniu" value="Meniu 1" checked> Meniu 1
            <div id="menu1" class="divmenu none"><div class="divflex"><div class="menutitle"><span>* Menu 1 * </span> Pofta buna ! </div><div class="textmenu"><ul><?php menulist("meniuri/menu1.txt");
            ?>
            </ul> </div></div></div></label>    
            <label class="showmenu"><input type="radio" name="meniu" value="Meniu 2"> Meniu 2
            <div id="menu2" class="divmenu none"><div class="divflex"><div class="menutitle"><span>* Menu 2 * </span> Pofta buna ! </div><div class="textmenu"><ul><?php menulist("meniuri/menu2.txt");
            ?>
            </ul></div></div> </div></label>
            <label class="showmenu"><input type="radio" name="meniu" value="Meniu 3"> Meniu 3
            <div id="menu3" class="divmenu none"><div class="divflex"><div class="menutitle"><span>* Menu 3 * </span> Pofta buna ! </div><div class="textmenu"><ul><?php menulist("meniuri/menu3.txt");
            ?>
            </ul></div></div></div></label>
            <label class="showmenu"><input type="radio" name="meniu" value="Meniu 4"> Meniu 4
            <div id="menu4" class="divmenu none"><div class="divflex"><div class="menutitle"><span>* Menu 4 * </span> Pofta buna ! </div><div class="textmenu"><ul><?php menulist("meniuri/menu4.txt");
            ?>
            </ul> </div></div></div></label>
        </div>
</label></li>
</ol>

</div>
<input type="checkbox" name="event" checked hidden value="botez">
<button class="btnConfirm" type="submit" name="confirm"> Confirm</button>
<div class="nuntaError">
<?php
if(isset($_GET["error"])){
switch($_GET["error"]){
    case "emptyoptions": echo "Nu ati ales nicio optiune";break;
    case "emptydate": echo "Nu a fost selectata o data";break;
    case "invaliddate": echo "Data botezului trebuie sa fie peste cel putin 1 saptamana de la data actuala";break; 
}    
}
?>
</div>
</form>
</section>

<?php
include_once("footer.php");
?>