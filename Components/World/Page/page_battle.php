<?php
/* Konfigurační soubory */
require_once "../../../config.php";
$config = (new Config()) -> get_instance();
/* Security */
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
/* Uživatel */
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
/* Založení session */
session_start();
/* Kontrola přihlášení */
if (check_login() == False) {
   header("location: " . $config['root_path_url'] . "index.php");
}
/* Proměnné */
$nickname = unserialize($_SESSION['logged_user']) -> get_username();
$id_user =unserialize($_SESSION['logged_user']) -> get_id();
$id_world = $_GET['id'];
/* Bezpečnost */
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
if (!(in_array($id_world, (unserialize($_SESSION['logged_user']))->get_permissions()))) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
   exit();
}
/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_Parts/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <div class="d-flex">
         <h1 class="m-auto"> Bitva </h1>
         <a href="<?php echo $config['root_path_url'] . "Components/World/Page/page_create_battle.php?id=$id_world" ?>"><button class="btn btn-primary create-new-warrior my-2"> Vytvořit </button> </a>
      </div>
      <p> Zde můžete vyzvat spoluhráče či protivníka na bitvu! Výsledky se zobrazí na výsledkové tabuli </p>
      <div class="col-lg-12 d-flex justify-content-center">
         <div class="row alert-banner-row col-lg-10">
            <div class="col-sm-2 d-flex align-items-center flex-column">
               <span class="banner-name"> Rathaus </span>
               <span class="banner-army"> 14.500 </span>
            </div>
            <div class="col-sm-8 body-column d-flex align-items-center flex-column">
               <h5>Skóre</h5>
               <p class="banner-score">1:1</p>
            </div>
            <div class="col-sm-2 d-flex align-items-center flex-column">
               <span class="banner-name"> Matyasek </span>
               <span class="banner-army"> 0 </span>
            </div>
         </div>
      </div>
   </div>
</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>