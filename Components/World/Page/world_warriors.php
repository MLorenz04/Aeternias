<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Uživatel */
require $config["root"] . "Components/Classes/Login.php";
/* Svět */
require $config["root"] . "Components/Classes/World.php";
/* Založení session */
session_start();
/* Security */
require $config["root"] . "Components/Security/security_functions.php";
/* Kontrola přihlášení */
if (check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
}
/* Proměnné */
$nickname = unserialize($_SESSION["logged_user"]) -> get_username();
$id_user = unserialize($_SESSION["logged_user"]) -> get_id();
$id_world = $_GET["id"];
/* Databáze */
$con = $config["db"];
/* Bezpečnost */
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
if (!(in_array($id_world, unserialize($_SESSION["logged_user"])->get_permissions()))) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
/* Vytvoření světa podle id */
$world = new World($id_world);
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-4" id="content">
      <div class="d-flex">
         <h1 class="m-auto"> Jednotky </h1>
         <a href="<?php echo $config['root_url'] . "Components/World/Page/world_create_warrior.php?id=$id_world" ?>"><button class="btn btn-primary create-new-warrior my-2"> Vytvořit </button> </a>
      </div>
      <p> Zde můžete spravovat svoje válečníky a jednotky! </p>
      <div class="container-cards">
         <?php foreach ($world->list_of_warriors as $warrior) {
            $id = $warrior["id"]
         ?>
            <div class="m-4 card world body-add-world" style="width: 18rem; height:auto">
               <a href="<?php echo $config['root_url'] . "Components/World/PHP/remove_warrior.php?id=$id_world&id_warrior=$id" ?>"><i class="remove-warrior bi bi-x-circle position-fixed"></i> </a>
               <a class="single-world-link" href="<?php echo $config['root_url'] . "Components/World/Page/single_warrior.php?" ?>">
                  <div class="card-body">
                     <span class="d-flex">
                        <h5 class="card-text pl-4 text-center w-100"><?php echo $warrior["name"]; ?></h5>
                     </span>
                     <p id="warrior_desc" class="mb-1"> <?php echo $warrior["description"]; ?> </p>
                     <p id="warrior_attack" class="mb-1"> <?php echo $warrior["attack"]; ?> </p>
                     <p id="warrior_defense" class="mb-1"> <?php echo $warrior["defense"]; ?> </p>
                     <p id="warrior_agility" class="mb-1"> <?php echo $warrior["agility"]; ?> </p>
                  </div>
               </a>
            </div>
         <?php
         }
         ?>
      </div>
   </div>
</main>

<?php
require $config["root"] . "Components/Elements/footer.php";
?>