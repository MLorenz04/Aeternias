<?php 
/* Proměnné */
$table_name = $_SESSION["table"]; //Proměnná přenášející, z jakého souboru má brát how_many_iders a získat id
/* Databáze */
$client = new MongoDB\Client($config["mongo_db"]);
$how_many_id = $client->Aeternias->counters;
/* Získání dat a vracení id */
$cursor = $how_many_id->find(["table" => $table_name]);
foreach($cursor as $k => $row) {
$json = json_encode($row);
$json = json_decode($json);
return $json -> how_many_id;
}
?>