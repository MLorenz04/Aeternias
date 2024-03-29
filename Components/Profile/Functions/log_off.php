<?php
require_once "../../../Components/Classes/Config.php";
$config = Config::getInstance();
/* Začátek session */
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
/* Odhlášení */
unset($_SESSION['is_logged']);
session_destroy();
if (!(isset($_SESSION['is_logged']))) {
   header("location:" . $config['root_path_url'] . "index.php");
}
