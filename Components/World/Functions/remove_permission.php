<?php
/* Konfigurační soubor */
require_once "../../../config.php";
require_once "../../Classes/User.php";
$config = (new Config()) -> get_instance();
require_once $config['root_path_require_once'] . "Components/Classes/World.php";
/* Začátek session */
session_start();
/* Databáze */
$con = $config['db'];
/* Proměnné */

/* Zkusí získat údaje, pokud se mu to nepodaří, hodí na index */
/* Ochrana proti pokusu jít přímo na soubor bez vyplněného formuláře */
try {
   $id_owner = $_POST['id']; //Id vlastníka permisse
   $id_world = $_POST['id_world']; //Id otevřeného světa
} catch (Exception $e) {
   header("location:" . $config['root_path_url'] . "index.php");
   exit();
}
$logged_user = (unserialize($_SESSION['logged_user']))->get_id();
/* Vytvoření světa podle id */
$world = new World($id_world);
if (!($logged_user == $world->id_owner)) {
   echo "Na toto nemáte pravomoce!";
   exit();
}
if ($id_owner == $world->id_owner) {
   echo "Nemůžete odebrat vlastníka světa!";
   exit();
}
$sql_select_all = "delete from permissions where id_owner = $id_owner and id_world = $id_world";
if ($con->query($sql_select_all)) {
   exit();
} else {
   echo "Tento uživatel nemá pravomoce ve vašem světě";
   exit();
}
