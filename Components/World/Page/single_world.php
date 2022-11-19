<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Bezpečnostní opatření */ 
require $config["root"] . "Components/Security/check_permission.php";
/* Proměnné */
$nickname = $_SESSION["username"];
$id_world = $_GET["id"]; //Získá proměnnou z url adresy
if (!($id_world = (int)$id_world) == 1) {
   exit();
}

/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
/* Kód stránky vracející info o světě */
$_SESSION["current_open_world"] = $id_world;
$con = $config["db"];
$sql_select_world = "select * from world where id = ?";
$statement = $con->prepare($sql_select_world);
$statement->bind_param("i", $id_world);
$statement->execute();
$result = $statement->get_result();
$row = $result->fetch_assoc();
?>
   <!-- Content stránky -->
   <main id="main" class="main wall_main">
      <div class="px-4" id="content">
         <h1> <?php echo $row["name"] ?> </h1>
            <p> Popisek: <?php echo $row['description']; ?>
            <p> Datum založení: <?php echo $row['date']; ?></p>
            <p> Počet uživatelů: <?php echo $row['user_count'] ?></p>
      </div>
   </main>