<?php
$table_name = $_SESSION["table"];
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->counters;
$id = require $config["root"] . "/Components/Helpers/get_id.php";
$cursor = $collection->updateOne(
   ['count' => $id],
   ['$set' => ['count' => $id+1]]
);
$id = require $config["root"] . "/Components/Helpers/get_id.php";
?>