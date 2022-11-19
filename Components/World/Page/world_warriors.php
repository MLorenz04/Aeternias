<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Bezpečnostní opatření */
require $config["root"] . "Components/Security/check_permission.php";
/* Proměnné */
$nickname = $_SESSION["username"];
/* Databáze */
$con = $config["db"];
/* Id z url adresy */
$id_world = $_GET["id"]; //Získá proměnnou z url adresy
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
$sql_select_all_warriors = "select * from warrior where id_world = $id_world";
$result = $con->query($sql_select_all_warriors);
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4" id="content">
      <div class="d-flex">
         <h1 class="py-2 m-auto"> Jednotky </h1>
         <a href="<?php echo $config['root_url'] . "Components/World/PHP/create_warrior.php" ?>"<button class="btn btn-primary create-new-warrior my-2"> Vytvořit </button> </a>
      </div>
      <p> Zde můžete spravovat svoje válečníky a jednotky! </p>
      <?php while ($row = $result->fetch_assoc()) {
         $id_warrior = $row["id"];
      ?>
         <div class="m-4 card world body-add-world" style="width: 18rem;">
            <a href="../../../index.php"><i class="remove-warrior bi bi-x-circle position-fixed"></i> </a>
            <a class="single-world-link" href="<?php echo $config['root_url'] . "Components/World/Page/single_warrior.php?id=$id_warrior" ?>">
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
</main>