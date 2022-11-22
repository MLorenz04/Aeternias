<?php
/* Kontrola přihlášení */
require $config["root"] . "Components/Security/security_functions.php";
if(check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
}
/* Hlavička */
require $config['root'] . "/Components/Elements/head.php";
/* Navigační meun */
require $config['root'] . "/Components/Elements/feedback.php";
require $config['root'] . "/Components/Elements/navbar.php";
/* Sidebar */
require $config['root'] . "/Components/Elements/sidebar_world.php"
?>