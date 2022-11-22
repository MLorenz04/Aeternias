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
/* Bezpečnost */
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
if(!check_login()) {
   header("location: " . $config["root_url"] . "index.php");
   exit();
}
?>
<main id="main" class="main wall_main">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-8 section register min-vh-100 d-flex flex-column py-4">
            <div class="card">
               <div class="card-body">
                  <div class="row flex text-center main-color card-title">
                     <h1 class="py-4"> Vytvořte si novou jednotku!</h1>
                  </div>
                  <form action="<?php echo $config['root_url'] . "Components/World/PHP/create_warrior.php"?>" method="POST">
                     <div class="container">
                        <div class="row">
                           <p class="my-0"> Jednotku budete moci využít hned po jejím vytvoření </p>
                           <p class="mb-4"> Pro informace, jak vytvářet jednotky, zamiřte do sekce <a href="<?php echo $config["root_url"] . "Components/Wall/warriors.php" ?>"> jednotek </a> </p>
                           <div class="mb-3 col-sm">
                              <label for="name" class="form-label">Název jednotky</label>
                              <input type="text" required class="form-control" id="name" name="name">
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="desc" class="form-label">Krátká poznámka</label>
                              <input type="text" class="form-control" id="desc" name="desc" required>
                           </div>
                        </div>
                        <div class="row">
                           <div class="mb-3 col-sm">
                              <label for="attack" class="form-label">Útok</label>
                              <input type="number" class="form-control" id="attack" name="attack" required>
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="defense" class="form-label">Obrana</label>
                              <input type="number" class="form-control" id="defense" name="defense" required>
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="agility" class="form-label">Agilita</label>
                              <input type="number" class="form-control" id="agility" name="agility" required>
                           </div>
                        </div>
                        <?php
                        if (isset($_SESSION["error_mess_new_warrior"])) { ?>
                           <div class="error_message pb-3 alert alert-danger" id="error_mess_new_warrior">
                              <?php
                              echo $_SESSION["error_mess_new_warrior"];
                              unset($_SESSION["error_mess_new_warrior"]);
                              ?>
                           </div>
                        <?php
                        }
                        ?>
                        <button type="submit" class="btn btn-primary px-4 b">Vytvořit!</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</main>