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
      <?php
      require_once "./Wall_Components/brief_wall.php";
      ?>
   </div>
</main>

<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>