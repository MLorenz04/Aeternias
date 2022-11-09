<?php
/* Proměnné */
$table_name = $_SESSION["table"];
/* Databáze */
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->counters;
/* Update id o jedno a jeho získání */
$id = require $config["root"] . "/Components/Helpers/get_id.php";
$cursor = $collection->updateOne(
   ['count' => $id],
   ['$set' => ['count' => $id+1]]
);
$id = require $config["root"] . "/Components/Helpers/get_id.php";
?>