<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Require světa */
require $config["root"] . "Components/Classes/World.php";
/* Security */
require $config["root"] . "Components/Security/security_functions.php";
/* Založení session */
session_start();
/* Kontrola přihlášení  */
if (check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
   exit();
}
/* Proměnné */
$nickname = $_SESSION["username"];
$id_user = $_SESSION["id_user"];
$id_world = $_GET["id"];
/* Bezpečnost */
if (!($id_world = (int)$id_world) == 1) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
/* Require s ostatními requires */
require $config['root'] . "Components/Helpers/php_header_single_world.php";
/* Vytvoření světa podle id */
$world = new World();
$world->get_world($id_world);
/* Uložení informace, jaký svět je otevřen */
$_SESSION["current_open_world"] = $id_world;
?>
<!-- Content stránky -->
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> <?php echo $world->name ?> </h1>
      <p> Popisek: <?php echo $world->desc; ?>
      <p> Datum založení: <?php echo $world->date; ?></p>
      <p> Počet uživatelů: <?php echo $world->user_count ?></p>
   </div>
</main>
<?php
require $config["root"] . "Components/Elements/footer.php";
?>