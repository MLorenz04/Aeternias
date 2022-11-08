<?php 
$table_name = $_SESSION["table"];
$client = new MongoDB\Client($config["mongo_db"]);
$count = $client->Aeternias->counters;
$cursor = $count->find(["table" => $table_name]);
foreach($cursor as $k => $row) {
$json = json_encode($row);
$json = json_decode($json);
return $json -> count;
}
?>