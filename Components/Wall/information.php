<?php
/* Konfigurační soubory */
$config = require "../../config.php";
/* Založení session */
session_start();
/* Proměnné */
$nickname = $_SESSION["username"];
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header.php";
?>
<main id="main" class="main wall_main">
   <div id="content">
      <div class="container px-4 pb-4">
         <h1 class="text-center wall-header"> Informace </h1>
         <p>
            Aeternias je studentský projekt zaměřující se na generování fantasy bitev určený pro hráče roleplayů, dračího doupěte nebo jen fanoušky fantasy.
            Projekt je veřejně dostupný pro každého a je zcela zdarma. Nebojte se nám v případě jakéhokoliv nápadu, připomínky či problému napsat!
         </p>
         <p> Mezi naše hlavní cíle je pomoci vám, hráčům fantasy her a příběhotepcům, s vývojem bitev mezi určitými armádami či skupinami. Naší cílovou kategorií
            jsou hráči Dračího doupěte a role-playeři, pro které byl projekt původně zamýšlen.
         </p>
         <p> I my sami jsem byl v několika středověkých roleplayích a někdy mě mrzelo, jak se dokázaly skupiny lidí pohádat právě nad získaným územím či nad tím,
            komu zbylo kolik vojáků a jak moc vyhrál.
         </p>
         <p> <strong> Ačkoliv pevně stojíme za tím, že fantasy a role-playe jsou právě o lidské domýšlivosti</strong>, věříme, že by tento projekt mohl mnohým ušetřit
         problémy, šarvátky mezi hráči a vznikající rozepře. </p>
      </div>
   </div>
</main>

<?php
require "../Elements/footer.php";
/* Přesměrovávač na určité podstránky s pomocí Ajaxu */
require "../Helpers/redirectors.php";
?>