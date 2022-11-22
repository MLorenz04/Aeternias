<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Proměnné */
$nickname = $_SESSION["username"];
$id_user = $_SESSION["id_user"];
$id_world = $_SESSION['current_open_world'];
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
/* Kontrola přihlášení */
if (check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
}
/* Kontrola pravomocí */
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
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
   <div class="px-4 py-2" id="content">
      <h1> <?php echo $row["name"] ?> </h1>
      <p> Popisek: <?php echo $row['description']; ?>
      <p> Datum založení: <?php echo $row['date']; ?></p>
      <p> Počet uživatelů: <?php echo $row['user_count'] ?></p>
   </div>
</main>