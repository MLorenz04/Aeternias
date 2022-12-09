<?php
/* Konfigurační soubory */
$config = require "../../config.php";
/* Založení session */
session_start();
/* Security */
require $config["root"] . "Components/Security/security_functions.php";
/* Kontrola přihlášení  */
if (check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
   exit();
}
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header.php";
/* Proměnné */
$nickname = $_SESSION["username"];
?>
<main id="main" class="main wall_main">
   <div id="content">
      <?php
      require "./brief_wall.php";
      ?>
   </div>
</main>

<?php
require "../Elements/footer.php";
?>