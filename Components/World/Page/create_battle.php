<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Require světa */
require $config["root"] . "Components/Classes/World.php";
/* Založení session */
session_start();
/* Proměnné */
$id_user = $_SESSION["id_user"];
$id_world = $_GET['id'];
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";

if (!($id_world = (int)$id_world) == 1) {
   exit();
}
/* Kontrola přihlášení  */
if (check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
}
/* Kontrola pravomocí */
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
/* Vytvoření světa podle id */
$world = new World();
$world->get_world($id_world);
/* Uložení informace, jaký svět je otevřen */
$_SESSION["current_open_world"] = $id_world;
?>
<!-- Content stránky -->

<main id="main" class="main wall_main">
   <div id="content">
      <div class="container px-4 pb-4">
         <h1 class="text-center wall-header"> Bitva </h1>
         <h3 class="text-center"> Poměř síly se svým nepřítelem! </h3>
         <div class="container-cards">
            <div class="card m-4" style="width: 18rem;">
               <div class="card-body body-add-world">
                  <h5 class="card-title text-center"> Vytvořit svět </h5>
                  <a class="new-world-href" href="../World/Page/new_world.php">
                     <i class="bi bi-plus text-center d-flex justify-content-center" style="max-height:100px; font-size:6rem; color:#2d2d2d; cursor:pointer"></i>
                  </a>
               </div>
            </div>
            <?php
            /* Výpis všech uživatelových světů */
            require "./your_world.php";
            ?>
         </div>
      </div>
   </div>
</main>
<?php
require $config["root"] . "Components/Elements/footer.php";
?>