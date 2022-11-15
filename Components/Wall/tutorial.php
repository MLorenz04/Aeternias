<?php
/* Konfigurační soubory */
$config = require "../../config.php";
/* Založení session */
session_start();
/* Proměnné */
$nickname = $_SESSION["username"];
/* Kontrola přihlášení */
require "../Security/check_login.php";
/* Hlavička */
require "../Elements/head.php";
require "../Elements/feedback.php";
require "../Elements/navbar.php";
require "../Elements/sidebar.php"
?>
<main id="main" class="main wall_main">
   <div id="content">
      <div class="container px-4 pb-4">
         <h1 class="wall-header text-center"> Návody a vysvětlení </h1>

         <h5> Jak vytvořit svět? </h5>
         <p> Zamiřte do sekce "Světy", kterou na počítači vidíte na levé straně (Na mobilu po rozklinutí menu vlevo nahoře).
            Klikněte na "Vytvořit svět" a vyplňe jméno vašeho světa a jeho zkrácený popisek. </p>
         <h5> Jak vytvořit pro můj svět jednotku? </h5>
         <p> Zamiřte do sekce "Světy", kterou na počítači vidíte na levé straně (Na mobilu po rozklinutí menu vlevo nahoře).
            Klikněte v tomto menu na "Správa jednotek" </p>
         <h5> Jak upravit můj účet? </h5>
         <p> Momentálně upravování účtů není nastavené, ale plánujeme přidat! </p>
      </div>
   </div>
</main>

<?php
require "../Elements/footer.php";
/* Přesměrovávač na určité podstránky s pomocí Ajaxu */
require "../Helpers/redirectors.php";
?>