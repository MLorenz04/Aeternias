<?php
/* Konfigurační soubory */
require_once "../../Classes/Config.php";
$config = (new Config())->get_instance();
/* Celá hlavička */
require_once "../../Templates/Body_parts/world_header.php";
require_once $config['root_path_require_once'] . "/Components/Templates/Body_Parts/php_header_single_world.php";
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