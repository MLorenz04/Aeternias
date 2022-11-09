<?php
/* Konfigurační soubor */ 
$config = require "../../../config.php"; 
require $config["root"] . "/vendor/autoload.php";
/* Začátek session */
session_start();
/* Proměnné */
$owner_id = $_SESSION["id_user"]; 
$world_name = $_POST["world_name"]; 
$world_desc = $_POST["desc"]; 
$_SESSION["table"] = "world"; 
/* Databáze a kolekce */
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->world; 
/* Skript vkládající nový svět */
$cursor =  $collection->find(["name" => $world_name]);
if (!$cursor->isDead()) { //Jestli není cursor prázdný
   header("location: /Omega/Components/Wall/wall.php");
} else {
$current_id = require $config["root"] . "/Components/Helpers/get_id.php"; //Získat ID
$collection->insertOne([ //Insert dat
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