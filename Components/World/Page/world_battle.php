<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Bezpečnostní opatření */
require $config["root"] . "Components/Security/check_permission.php";
/* Proměnné */
$nickname = $_SESSION["username"];
/* Id z url adresy */
$id_world = $_GET["id"]; //Získá proměnnou z url adresy
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4" id="content">
      <h1 class="py-2"> Bitvy </h1>
      <p> Zde můžete vyzvat spoluhráče či protivníka na bitvu! Výsledky se zobrazí na výsledkové tabuli </p>
   </div>
</main>