<?php
/* Konfigurační soubory */
$config = require("../../config.php");
/* Založení session */
session_start();
/* Proměnné */
$id_owner = $_SESSION["id_user"];
/* Databáze a připojení do kolekce */
$con = $config["db"];
/* SQL příkazy */
$sql_all_worlds = "select name, description from world where id_owner = $id_owner";
/* Výpis všech uživatelových světů */
$result = $con->query($sql_all_worlds);
while ($row = $result->fetch_assoc()) {
?>
   <div class="m-4 card body-add-world" style="width: 18rem;">
      <div class="card-body">
         <h5 class="card-text"><?php echo $row["name"]; ?></h5>
         <p class="card-text"><?php echo $row["description"]; ?></p>
      </div>
   </div>
<?php
}
?>