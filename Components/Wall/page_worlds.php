<?php
/* Konfigurační soubory */
require_once "../Classes/Config.php";
$config = Config::getInstance();
/* Celá hlavička */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/normal_header.php";
?>
<main id="main" class="main wall_main">
  <div id="content">
    <div class="container px-4 pb-4">
      <h1 class="text-center wall-header"> Vaše Světy </h1>
      <h3 class="text-center"> Vytvořte si svůj vlastní svět a generujte epické bitvy! </h3>
      <p> Aktuálně máte vytvořeno <?php echo $world_count ?> z 10 světů.
      <div class="container-cards">
        <div class="card body-add-world" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title text-center">Vytvořit svět</h5>
            <a class="new-world-href" href="<?php echo $config['root_path_url'] . "Components" ?>/Wall/page_new_world.php">
              <i class="bi bi-plus text-dark-always text-center d-flex justify-content-center" style="max-height:100px; font-size:6rem; color:#2d2d2d; cursor:pointer"></i>
            </a>
          </div>
        </div>
        <?php
        /* Výpis všech uživatelových světů */
        require_once "Wall_Components/your_world.php";
        ?>
      </div>
      <hr style="color:white; width:100%;"> </hr>
      <h3 style="text-align:center"> Světy mých přátel </h3>
      <div class="container-cards">
        <?php
        /* Výpis všech uživatelových světů */
        require_once "Wall_Components/others_world.php";
        ?>
      </div>
    </div>
  </div>
  </div>
</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>