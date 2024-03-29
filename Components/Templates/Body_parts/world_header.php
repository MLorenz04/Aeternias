<?php
/* Založení session */
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
/* Potřebné soubory */
require_once "../../../Components/Classes/Config.php";
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
require_once $config['root_path_require_once'] . "Components/Classes/World.php";
require_once $config['root_path_require_once'] . "Components/Classes/Security.php";
/* Instance konfigurace a bezpečnosti */
$config = Config::getInstance();
$security = (new Security());
/* Kontrola přihlášení */
if ($security->check_login() == False) {
   header("location: " . $config['root_path_url'] . "index.php");
   exit();
}
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$nickname = $user->getUsername();
$id_user = $user->getId();
$con = $config['db'];
$id_world = $_GET["id"];
/* Kontrola, jestli má uživatel přístup do světa */
$security->security($id_world, $user);
$world = (new World($id_world))->get_instance();
/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/php_header_single_world.php";
