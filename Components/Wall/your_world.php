<?php
/* Konfigurační soubory */
$config = require("../../config.php");
require $config["root"] . "/vendor/autoload.php";
/* Založení session */
session_start();
/* Proměnné */
$id_owner = $_SESSION["id_user"];
/* Databáze a připojení do kolekce */
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->world;
/* Výpis všech uživatelových světů */
$cursor = $collection->find(["owner_id" => $id_owner]);
if (!($cursor->isDead())) {
   foreach ($cursor as $k => $single_json_file) {
      $json_temp = json_encode($single_json_file);
      $json = json_decode($json_temp);
?>
      <div class="m-4 card body-add-world" style="width: 18rem;">
         <div class="card-body">
            <h5 class="card-text"><?php echo $json->name; ?></h5>
            <p class="card-text"><?php echo $json->desc; ?></p>
         </div>
      </div>

<?php
   }
}
?>