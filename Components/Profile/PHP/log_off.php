<?php
$config = require "../../../config.php";
/* Začátek session */
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
/* Odhlášení */
unset($_SESSION["is_logged"]);
session_destroy();
if(!(isset($_SESSION["is_logged"]))) { 
header("location:" . $config["root_url"] . "index.php");
}
