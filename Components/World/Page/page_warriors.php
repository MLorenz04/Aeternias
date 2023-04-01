<?php
/* Konfigurační soubory */
require_once "../../../Components/Classes/Config.php";
$config = (new Config())->get_instance();
/* Celá hlavička */
require_once "../../Templates/Body_parts/world_header.php";
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-4" id="content">
      <div class="d-flex">
         <h1 class="m-auto"> Jednotky </h1>
         <a href="<?php echo $config['root_path_url'] . "Components/World/Page/page_create_warrior.php?id=$id_world" ?>"><button class="btn btn-primary create-new-warrior my-2"> Vytvořit </button> </a>
      </div>
      <p> Zde můžete spravovat svoje válečníky a jednotky! </p>
      <div class="container-cards">
         <?php foreach ($world->list_of_warriors as $warrior) {
            $id = $warrior['id']
         ?>
            <div id="card-<?php echo $id ?>" class="m-4 card world body-add-world" style="width: 18rem; height:auto">
               <span role="button"><i id="<?php echo $id ?>" class="remove text-dark-always remove-warrior bi bi-x-circle position-fixed"></i></span>
               <a class="single-world-link" href="<?php echo $config['root_path_url'] . "Components/World/Page/single_warrior.php?" ?>">
                  <div class="card-body">
                     <span class="d-flex">
                        <h5 class="card-text pl-4 text-center w-100"><?php echo $warrior['name']; ?></h5>
                     </span>
                     <p id="warrior_desc" class="mb-1"> <?php echo $warrior['description']; ?> </p>
                     <p id="warrior_attack" class="mb-1"> <?php echo $warrior['attack']; ?> </p>
                     <p id="warrior_defense" class="mb-1"> <?php echo $warrior['defense']; ?> </p>
                     <p id="warrior_agility" class="mb-1"> <?php echo $warrior['agility']; ?> </p>
                  </div>
               </a>
            </div>
         <?php
         }
         ?>
      </div>
   </div>
</main>
<script>
   window.onload = function() {
      $.ajaxSetup({
         beforeSend: function(xhr) {
            xhr.setRequestHeader('Api-token', '<?php echo $user->getApiToken() ?>');
            xhr.setRequestHeader('Api-hash', '<?php echo $user->getApiHash() ?>');
         }
      });
   }
   $(".remove").click(function($e) {
      console.log("this")
      $id = event.target.id;
      $.ajax({
         url: "<?php echo $config['root_path_url'] . "Restapi/v1/warriors/$id_world/" ?>" + $id,
         method: "DELETE",
         async: false,
         success: function($data) {
            console.log($($e.target));
            $("#card-" + $id).remove();
         }
      });
   });
</script>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>