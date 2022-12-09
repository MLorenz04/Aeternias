<?php
/* Konfigurační soubory */
$config = require "../../config.php";
/* Založení session */
session_start();
/* Security */ 
require $config["root"] . "Components/Security/security_functions.php";
/* Kontrola přihlášení  */
if (check_login() == False) {
  header("location: " . $config["root_url"] . "index.php");
  exit();
}
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header.php";
/* Proměnné */
$nickname = $_SESSION["username"];
?>
<main id="main" class="main wall_main">
  <div id="content">
    <div class="container px-4 pb-4">
      <h1 class="text-center wall-header"> Světy </h1>
      <h3 class="text-center"> Vytvořte si svůj vlastní svět a generujte epické bitvy! </h3>
      <div class="container-cards">
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body body-add-world">
            <h5 class="card-title text-center">Vytvořit svět</h5>
            <a class="new-world-href" href="../World/Page/new_world.php">
              <i class="bi bi-plus text-dark-always text-center d-flex justify-content-center" style="max-height:100px; font-size:6rem; color:#2d2d2d; cursor:pointer"></i>
            </a>
          </div>
        </div>
        <?php
        /* Výpis všech uživatelových světů */
        require "./your_world.php";
        ?>
      </div>
    </div>
  </div>
</main>
<?php
require "../Elements/footer.php";
/* Přesměrovávač na určité podstránky s pomocí Ajaxu */
require "../Helpers/redirectors.php";
?>