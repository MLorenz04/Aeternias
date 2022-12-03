<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Require se založením instance světa */
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
$nickname = $_SESSION["username"];
$id_user = $_SESSION["id_user"];
$id_world = $_GET["id"];
/* Bezpečnost */
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
$world = new World();
$world->get_world($id_world);
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> Nastavení </h1>
      <p> Zde si můžete upravit svůj svět, jak chcete! </p>
      <form action="<?php echo $config['root_url'] ?>Components/World/PHP/update_world.php?id=<?php echo $id_world ?>" id="form" method="POST" class="mb-3">
         <div class="mb-3">
            <label for="name" class="form-label">Název světa</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $world->name ?>">
         </div>
         <div class="mb-3">
            <label for="desc" class="form-label">Popisek</label>
            <input type="text" class="form-control" id="desc" name="desc" value="<?php echo $world->desc ?>">
         </div>
         <button type="submit" class="btn btn-primary"> Uložit </button>
      </form>
      <?php
      if (isset($_SESSION["error_mess_settings"])) { ?>
         <div class="error_message pb-3 alert alert-danger" id="error_mess_login">
            <?php
            echo $_SESSION["error_mess_settings"];
            unset($_SESSION["error_mess_settings"]);
            ?>
         </div>
      <?php
      }
      ?>
   </div>
</main>

<script>
</script>