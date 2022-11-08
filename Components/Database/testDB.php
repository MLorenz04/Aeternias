<?php
require '../../vendor/autoload.php';
$config = require "../../config.php";
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->warriors;
$jsons = [];
/*
$insertOneResult = $collection->insertOne([
   "id" => 0,
   "owner_id" => 0,
   "name" => "",
   "desc" => "",
   "permissions" => [
      [
         "id_user" => 132,
      ],
      [
         "id_user" => 123
      ]
   ],
   "warriors" => [
      [
         "name" => "Lučistník",
         "id_warrior" => 0,
         "stats" => [
            "attack" => 2,
            "health" => 3
         ]
      ]
   ]
]);
*/
$count = $client->Aeternias->counters;
$cursor = $count->find(["table" =>"users"]);
foreach($cursor as $k => $row) {
$json = json_encode($row);
$json = json_decode($json);
echo $json -> count;
}