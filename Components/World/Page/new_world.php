<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Proměnné */
$nickname = $_SESSION["username"];
/* Kontrola přihlášení */
require "../../Security/check_login.php";
/* Hlavička */
require "../../Elements/head.php";
require "../../Elements/feedback.php";
require "../../Elements/navbar.php";
require "../../Elements/sidebar.php"
?>
<main id="main" class="main wall_main">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-8 section register min-vh-100 d-flex flex-column py-4">
            <div class="card">
               <div class="card-body">
                  <div class="row flex text-center main-color card-title">
                     <h1 class="py-4"> Vytvořte si nový svět! </h1>
                  </div>
                  <form action=" <?php echo $config['root_url'] . 'Components/World/PHP/create_world.php' ?>" method="POST">
                     <div class="container">
                        <div class="row">
                           <p class="my-0"> Ve Vašem světě jste pánem vy! Přidávejte své přátelé, ukažte jim Váš svět a simulujte epické bitvy! </p>
                           <p class="mb-4">Jakmile svět vytvoříte, budete k němu moci přidat mnohem více informací! </p>
                           <div class="mb-3 col-sm">
                              <label for="world_name" class="form-label">Název světa</label>
                              <input type="text" required class="form-control" id="world_name" name="world_name">
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="desc" class="form-label">Krátká poznámka</label>
                              <input type="text" class="form-control" id="desc" name="desc" required>
                           </div>
                        </div>
                        <?php
                        if (isset($_SESSION["error_mess_new_world"])) { ?>
                           <div class="error_message pb-3 alert alert-danger" id="error_mess_new_world">
                              <?php
                              echo $_SESSION["error_mess_new_world"];
                              unset($_SESSION["error_mess_new_world"]);
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

<?php
require "../Elements/footer.php";
/* Přesměrovávač na určité podstránky s pomocí Ajaxu */
require "../Helpers/redirectors.php";
?>