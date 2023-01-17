<?php
/* Session */
session_start();
/* Konfigurační soubory */
require_once "../../../config.php";
$config = (new Config())->get_instance();
require_once $config['root_path_require_once'] . "Components/Classes/World.php";
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$nickname =  $user->get_username();
$id_user = $user->get_id();
$id_world = $_GET['id'];
security();
$world = new World($id_world);
/* Kontrola přihlášení a bezpečnost */
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/php_header_single_world.php";
?>
<!-- Content stránky -->
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> <?php echo $world->name ?> </h1>
      <p> Popisek: <?php echo $world->desc; ?>
      <p> Datum založení: <?php echo $world->date; ?></p>
      <p> Počet uživatelů: <?php echo $world->user_count ?></p>
   </div>
</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>