<?php
/* Konfigurační soubory */
require_once "../../Classes/Config.php";
require_once "../../Classes/User.php";
$config = (new Config())->get_instance();
$users_profile = new User($_GET["id"]);
if ($users_profile->getEmail() == null) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=4");
   exit();
}

/* Celá hlavička */
require_once "../../Templates/Body_parts/normal_header.php";
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/php_header.php";
?>
<main id="main" class="main wall_main">
   <div class="container px-4">
      <div class="d-flex justify-content-end ">
         <a href="<?php echo $config['root_path_url'] . "Components/Profile/Page/settings.php?id=" . $users_profile->getId() ?>"><button class="btn btn-primary my-2"> Nastavení </button> </a>
      </div>
      <section>
         <h1> <?php echo $users_profile->getUsername() ?> </h1>
         <p> <strong>Email:</strong> <?php echo $users_profile->getEmail() ?> </p>
         <p> <strong>Počet světů: </strong><?php echo $users_profile->getWorldCount() ?> </p>
         <?php
         if ($users_profile->getId() == $user->getId()) { ?>
            <p> <strong>Api klíč: </strong> <?php echo $users_profile->getApiToken() ?> </p>
            <p> <strong> Api hash: </strong> <?php echo $users_profile->getApiHash() ?> </p>
         <?php
         }
         ?>
      </section>
      <section>
         <h2> Vytvořené světy </h2>
         <?php
         foreach ($users_profile->getWorlds() as $world) { ?>
            <div class="container-cards">
               <a class="new-world-href" href="<?php echo $config['root_path_url']  ?>Components/World/Page/page_single_world.php?id=<?php echo $world[0] ?>">

                  <div class="card m-4" style="width: 18rem;">
                     <div class="card-body body-add-world">
                        <h5 class="card-title text-center"><?php print_r($world[1]); ?></h5>

                     </div>
                  </div>
               </a>
            <?php
         }
            ?>
      </section>
   </div>
</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>