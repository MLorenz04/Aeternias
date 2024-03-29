<?php
/* Konfigurační soubory */
require_once "../Classes/Config.php";
$config = Config::getInstance();
/* Celá hlavička */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/normal_header.php";
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
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>