<?php
/* Konfigurační soubory */
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
require_once $config['root_path_require_once'] . "Components/Classes/Security.php";
$config = Config::getInstance();
$security = (new Security());
/* Založení session */
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
/* Kontrola přihlášení  */
if ($security->check_login() == False) {
  header("location: " . $config['root_path_url'] . "index.php");
  exit();
}
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$nickname = $user->getUsername();
$world_count = $user->getWorldCount();

/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/php_header.php";
