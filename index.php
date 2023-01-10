<?php
include_once("header.php");
?>

<section class="homebkg">
    <div class="descriereppag">

     <?php
     if(isset($_SESSION["username"])){
     echo "<p> Acum ca te-ai logat poti incepe costumizarea unui eveniment. </p>";
    }
    ?>

    <h2>Organizare evenimente</h2>
      <p>Pe site-ul nostru vei gasi servicii profesionale
         de organizare evenimente pentru ca totul sa fie impecabil,
          de la realizarea decorului pana la alegerea muzicii, a invitatiilor
           si a artificiilor. Tot ce iti poti dori pentru evenimentul tau il
            gasesti la noi, asa ca uita de listele facute si de lucrurile pe
             care trebuie sa le bifezi inainte de marea zi.</p>
      <p>Vom tine cont de preferintele tale in privinta fiecarui segment in parte
         si vom incepe pregatirile de la zero in timp util, astfel incat totul sa 
         se desfasoare in ritmul pe care ti-l doresti. De asemenea, iti punem la 
         dispozitie ideile noastre creative si informatiile temeinice pe care le avem 
         cu privire la noutatile si trendurile din domeniu, astfel incat sa fii sigur
          ca lucrezi cu adevarati specialisti in organizare de evenimente.</p>
          <p>Insa ceea ce conteaza cel mai mult este ca iti suntem alaturi pe tot 
            parcursul pregatirii evenimentului si te ajutam sa eviti chiar si cele mai mici
             greseli. Ne dorim ca totul sa iasa perfect si sa ai parte de clipe memorabile 
             alaturi de cei dragi cu un minimum de efort. Vei primi consultanta specializata 
             in materie de organizare de evenimente si te vei bucura de sfaturi si pareri
              avizate, care cu siguranta iti vor fi utile si te vor ajuta sa depasesti pragul 
              emotiilor. <b>Pentru a incepe costumizarea evenimentelor trebuie sa va inregistrati. </b></p>
    </div>

    <div class="img-even">
      <?php 
      $evenimente = array("images/nunta.jpeg" => "nunta","images/botez.jpeg"=> "botez","images/majorat.jpeg"=> "majorat","images/aniversare.jpeg"=> "aniversare");
      $topnr = 20;
      $texts = array("nunta"=>"Nunta ta va fi un adevarat spectacol de care toti invitatii isi vor aduce aminte cu drag!",
      "botez"=>"Venirea pe lume a unui copil este un motiv de bucurie si trebuie sarbatorita corespunzator. Micutul tau merita un botez ca la carte...",
      "majorat"=>"Ziua in care devii major nu se uita niciodata, asa ca trebuie sa fie perfecta! Toti adolescentii asteapta cu nerabdare sa implineasca frumoasa varsta de 18 ani, iar cand acest lucru se intampla, isi doresc ca petrecerea lor sa fie de neuitat.",
      "aniversare"=>"Cei mici vor avea parte de toata distractia. Nu vor avea cum sa se plictiseasca vreo secunda atata timp cat se afla in preajma animatorilor pentru petreceri copii.",
      "conferinte"=>"Sala de conferinte...",);
      for($i=0; $i< sizeof($evenimente);$i++){
        $imgsrc = array_keys($evenimente)[$i]; 
        if($i % 2 === 0){
          $left = '60%';
        }
        else{
          $left = '10%';
        }
      $top = $topnr.'px';
      $nameev = $evenimente[$imgsrc];
      $text = $texts[$nameev] ;
      echo "<div class='divImg' style='top:$top; left:$left'>
             <img class='img' src=$imgsrc alt=$nameev>
             <div class='text'>$text</div>
            </div>";
        echo "<br>";
        $topnr +=280;
      }
      ?>
     </div>
</section>

<section class="divcontact" id="divcontactul">
       <form class="formcontact" action="includes/contact.inc.php" method="post">
        <?php if(isset($_SESSION["username"])){ 
               $name = $_SESSION["fname"]." ".$_SESSION["lname"];
               $mail = $_SESSION["email"];
          }
          else{
            $name = "";
            $mail = "";
          }?>
         <div class="divflex inp"> 
        <input type="text" name="nume" value="<?php echo $name ?>"  placeholder="Full name" value="sss">
        <input type="email" name="email"value="<?php echo $mail ?>" placeholder="Email" value="sss">
        <input type="text" name="subiect" placeholder="Subiect">
         </div>
        <textarea name="mesaj" id="ctcfooter" placeholder="Puteti sa ne contactati transmitandu-ne mesajul aici" cols="130" rows="15"></textarea>
        <div class="g-recaptcha captcha" data-sitekey="6Ldh2twjAAAAAMs1L40KgiJtld0jzXWOHYy_fCuV"></div>
        <button type="submit" name="sendcontact" id="btncontact">Trimite mesajul</button>
       </form>
</section>


<?php
include_once("footer.php");
?>
    
