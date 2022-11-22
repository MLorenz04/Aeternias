<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Proměnné */
$nickname = $_SESSION["username"];
$id_user = $_SESSION["id_user"];
$id_world = $_SESSION['current_open_world'];
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
/* Bezpečnostní opatření */
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
if (!check_login()) {
   header("location: " . $config["root_url"] . "index.php");
   exit();
}
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> Nastavení </h1>
      <p> Zde si můžete upravit svůj svět, jak chcete! </p>
   </div>
</main>