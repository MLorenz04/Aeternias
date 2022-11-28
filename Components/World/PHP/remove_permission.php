<?php
/* Konfigurační soubor */
$config = require "../../../config.php";
/* Začátek session */
session_start();
/* Databáze */
$con = $config["db"];
/* Proměnné */
$id_owner = $_POST["id"]; //Id vlastníka permisse
$id_world = $_SESSION['current_open_world']; //Id otevřeného světa
$logged_user = $_SESSION["user_id"];
/* Vytvoření světa podle id */
$world = new World();
$world->get_world($id_world);
if (!($logged_user = $world->id_owner)) {
   echo "Na toto nemáte pravomoce!";
}

$sql_select_all = "delete from permissions where id_owner = $id_owner and id_world = $id_world";
if ($con->query($sql_select_all)) {
   echo "Tento uživatel je již přidaný";
   exit();
} else {
   echo "Tento uživatel nemá pravomoce ve vašem světě";
}
