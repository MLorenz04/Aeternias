<?php
/* Konfigurační soubory */
require_once "../Classes/Config.php";
$config = Config::getInstance();
/* Celá hlavička */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/normal_header.php";
?>
<main id="main" class="main wall_main">
   <div id="content">
      <?php
      require_once "Wall_Components/brief_wall.php";
      ?>
   </div>
</main>

<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>