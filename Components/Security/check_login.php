<?php 
/* Jednoduchá kontrola přihlášení */
if(!(isset($_SESSION["is_logged"]))) {
   header("location:" . $config["root_url"] . "index.php");
}
?>