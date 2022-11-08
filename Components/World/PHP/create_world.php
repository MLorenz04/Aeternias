<?php
session_start();
//Konfigurační soubor
$config = require "../../../config.php"; //Conf
require $config["root"] . "/vendor/autoload.php"; //Mongo
/* Proměnné */
$owner_id = $_SESSION["id_user"]; //ID aktivního uživatele
$world_name = $_POST["world_name"]; //Název světa
$world_desc = $_POST["desc"]; //Popisek světa
$_SESSION["table"] = "world"; //Měníme tabulku, po které budeme chtít vrátit ID.
/* Databáze a kolekce */
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->world; //Světy
$count = $client->Aeternias->counters; //Počítadlo idček
/* Skript vkládající nový svět */
$cursor =  $collection->find(["name" => $world_name]);
if (!$cursor->isDead()) { //Jestli není cursor prázdný
   header("location: /Omega/Components/Wall/wall.php");
} else {
$current_id = require $config["root"] . "/Components/Helpers/get_id.php"; //Získat ID
$collection->insertOne([
   "id" => $current_id, 
   "owner_id" => $owner_id, 
   "name" => $world_name, 
   "desc" => $world_desc, 
   "permissions_id" => [], 
   "warriors_id" => []
]);
header("location: /Omega/Components/Wall/wall.php");
require $config["root"] . "/Components/Helpers/update_id.php"; //Zvednou ID o jedno
}
?>