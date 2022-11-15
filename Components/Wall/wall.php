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