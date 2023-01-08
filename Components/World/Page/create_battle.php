<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Require světa */
require $config["root"] . "Components/Classes/World.php";
/* Security */
require $config["root"] . "Components/Security/security_functions.php";
/* Založení session */
session_start();
/* Proměnné */
$id_user = $_SESSION["id_user"];
$id_world = $_GET['id'];
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";

if (!($id_world = (int)$id_world) == 1) {
   exit();
}
/* Kontrola přihlášení  */
if (check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
}
/* Kontrola pravomocí */
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
/* Vytvoření světa podle id */
$world = new World();
$world->get_world($id_world);
/* Uložení informace, jaký svět je otevřen */
$_SESSION["current_open_world"] = $id_world;
?>
<!-- Content stránky -->

<main id="main" class="main wall_main">
   <div id="content">
      <div class="container px-4 pb-4">
         <h1 class="text-center wall-header"> Bitva </h1>
         <form action="<?php echo $config["root_url"] ?>Components/Battle/battle.php?id=<?php echo $world->id ?>" method="POST">
            <?php
            $count_of_warriors = 0; //Počítáme, kolik existuje jednotek a postupně je vypíšeme
            foreach ($world->list_of_warriors as $warrior) {
               $count_of_warriors++;
            ?>
               <label for="warrior[warrior<?php echo $warrior["id"] ?>][count]"> <?php echo $warrior["name"] ?> </label>
               <input type="hidden" name="warrior[<?php echo $count_of_warriors ?>][id]" value="<?php echo $warrior["id"] ?>"> </input>
               <input type="number" name="warrior[<?php echo $count_of_warriors ?>][count]"> </input>
            <?php
            }
            $count_of_warriors = 0;
            ?>
            <button type="submit">
         </form>
         <div class="container-cards">
         </div>
      </div>
   </div>
</main>
<?php
require $config["root"] . "Components/Elements/footer.php";
?>