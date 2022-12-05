<?php
/* Konfigurační soubor */
$config = require "../../../config.php";
require $config["root"] . "Components/Classes/World.php";
/* Začátek session */
session_start();
/* Databáze */
$con = $config["db"];
/* Proměnné */

/* Zkusí získat údaje, pokud se mu to nepodaří, hodí na index */
/* Ochrana proti pokusu jít přímo na soubor bez vyplněného formuláře */
try {
   $id_owner = $_POST["id"]; //Id vlastníka permisse
   $id_world = $_POST['id_world']; //Id otevřeného světa
} catch (Exception $e) {
   header("location:" . $config['root_url'] . "index.php");
   exit();
}
$logged_user = $_SESSION["id_user"];
/* Vytvoření světa podle id */
$world = new World();
$world->get_world($id_world);
if (!($logged_user == $world->id_owner)) {
   echo "Na toto nemáte pravomoce!";
   echo $logged_user;
   echo $world->id_owner;
   exit();
}

$sql_select_all = "delete from permissions where id_owner = $id_owner and id_world = $id_world";
if ($con->query($sql_select_all)) {
   echo "Uživatel byl smazán";
   exit();
} else {
   echo "Tento uživatel nemá pravomoce ve vašem světě";
   exit();
}
