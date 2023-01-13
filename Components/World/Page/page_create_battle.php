<?php
/* Konfigurační soubory */
require_once "../../../config.php";
$config = (new Config()) -> get_instance();
/* Require světa */
require_once $config['root_path_require_once'] . "Components/Classes/World.php";
/* Require uživatele */
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
/* Security */
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
/* Založení session */
session_start();
/* Proměnné */
$id_user = unserialize($_SESSION['logged_user'])->get_id();
$id_world = $_GET['id'];
/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_Parts/php_header_single_world.php";

if (!($id_world = (int)$id_world) == 1) {
   exit();
}
/* Kontrola přihlášení  */
if (check_login() == False) {
   header("location: " . $config['root_path_url'] . "index.php");
}
/* Kontrola pravomocí */
if (!(in_array($id_world, unserialize($_SESSION['logged_user'])->get_permissions()))) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
   exit();
}
/* Vytvoření světa podle id */
$world = new World($id_world);
/* Uložení informace, jaký svět je otevřen */
$_SESSION['current_open_world'] = $id_world;
?>
<!-- Content stránky -->

<main id="main" class="main wall_main">
   <div id="content">
      <div class="container px-4 pb-4">
         <h1 class="text-center wall-header"> Bitva </h1>
         <h3 class="text-center"> Poměř síly se svým nepřítelem! </h3>
         <div class="container-cards">
            <div class="card m-4" style="width: 18rem;">
               <div class="card-body body-add-world">
                  <h5 class="card-title text-center"> Vytvořit svět </h5>
                  <a class="new-world-href" href="../World/Page/page_new_world.php">
                     <i class="bi bi-plus text-center d-flex justify-content-center" style="max-height:100px; font-size:6rem; color:#2d2d2d; cursor:pointer"></i>
                  </a>
               </div>
            </div>
            <?php
            /* Výpis všech uživatelových světů */
            require_once "./Wall_Components/your_world.php";
            ?>
         </div>
      </div>
   </div>
</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>