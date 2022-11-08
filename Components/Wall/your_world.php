<?php
/* Konfigurační soubory */
$config = require("../../config.php"); //Conf
require $config["root"] . "/vendor/autoload.php"; //Mongo
session_start();
$id_owner = $_SESSION["id_user"];
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->world;
$cursor = $collection->find(["owner_id" => $id_owner]);
if (!($cursor->isDead())) {
   foreach ($cursor as $k => $row) {
      $json = json_encode($row);
      $obj = json_decode($json);
?>
      <div class="m-4 card body-add-world" style="width: 18rem;">
         <div class="card-body">
            <h5 class="card-text"><?php echo $obj->name; ?></h5>
            <p class="card-text"><?php echo $obj->desc; ?></p>
         </div>
      </div>

<?php
   }
}
?>