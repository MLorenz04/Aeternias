<?php
/* Konfigurační soubory */
require_once "../../../config.php";
$config = (new Config()) -> get_instance();
/* Založení session */
session_start();
/* Security */ 
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
/* Kontrola přihlášení  */
if (check_login() == False) {
  header("location: " . $config['root_path_url'] . "index.php");
  exit();
}
/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_Parts/php_header.php";
/* Proměnné */
$nickname = unserialize($_SESSION['logged_user']) -> get_username();
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
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>