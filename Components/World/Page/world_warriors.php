<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Databáze */
$con = $config["db"];
/* Proměnné */
$nickname = $_SESSION["username"];
$id_user = $_SESSION["id_user"];
$id_world = $_SESSION['current_open_world'];
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
/* Bezpečnostní opatření */
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
if (!check_login()) {
   header("location: " . $config["root_url"] . "index.php");
   exit();
}
$sql_select_all_warriors = "select * from warrior where id_world = $id_world";
$result = $con->query($sql_select_all_warriors);
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-4" id="content">
      <div class="d-flex">
         <h1 class="m-auto"> Jednotky </h1>
         <a href="<?php echo $config['root_url'] . "Components/World/Page/world_create_warrior.php"?>"><button class="btn btn-primary create-new-warrior my-2"> Vytvořit </button> </a>
      </div>
      <p> Zde můžete spravovat svoje válečníky a jednotky! </p>
      <div class="container-cards">
         <?php while ($row = $result->fetch_assoc()) {
            $id_warrior = $row["id"];
         ?>
            <div class="m-4 card world body-add-world" style="width: 18rem;">
               <a href="<?php echo $config['root_url'] . "Components/World/PHP/remove_warrior.php?id=$id_warrior" ?>"><i class="remove-warrior bi bi-x-circle position-fixed"></i> </a>
               <a class="single-world-link" href="<?php echo $config['root_url'] . "Components/World/Page/single_warrior.php?" ?>">
                  <div class="card-body">
                     <span class="d-flex">
                        <h5 class="card-text pl-4 text-center w-100"><?php echo $row["name"]; ?></h5>
                     </span>
                  </div>
               </a>
            </div>
         <?php
         }
         ?>
      </div>
   </div>
</main>