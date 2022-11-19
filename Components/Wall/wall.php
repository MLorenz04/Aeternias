<?php
/* Konfigurační soubory */
$config = require "../../config.php";
/* Založení session */
session_start();
/* Layout stránky */
$nickname = $_SESSION["username"];
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header.php";
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
/* Přesměrovávač na určité podstránky s pomocí Ajaxu */
require "../Helpers/redirectors.php";
?>