<?php
/* Konfigurační soubory */
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
require_once $config['root_path_require_once'] . "Components/Classes/Security.php";
$config = (new Config())->get_instance();
$security = (new Security());
/* Založení session */
session_start();
/* Kontrola přihlášení  */
if ($security->check_login() == False) {
  header("location: " . $config['root_path_url'] . "index.php");
  exit();
}
/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_Parts/php_header.php";
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$nickname = $user->getUsername();
$world_count = $user->getWorldCount();
