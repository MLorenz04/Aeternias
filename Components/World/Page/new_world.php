<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Proměnné */
$nickname = $_SESSION["username"];
/* Hlavička */
require $config["root"] . "Components/Helpers/php_header.php";
?>
<main id="main" class="main wall_main">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-8 section register min-vh-100 d-flex flex-column py-4">
            <div class="card">
               <div class="card-body">
                  <div class="row flex text-center main-color card-title">
                     <h1 class="py-4 light-text"> Vytvořte si nový svět! </h1>
                  </div>
                  <form onclick="event.preventDefault()" method="POST">
                     <div class="container">
                        <div class="row">
                           <p class="my-0 light-text"> Ve Vašem světě jste pánem vy! Přidávejte své přátelé, ukažte jim Váš svět a simulujte epické bitvy! </p>
                           <p class="mb-4 light-text">Jakmile svět vytvoříte, budete k němu moci přidat mnohem více informací! </p>
                           <div class="mb-3 col-sm">
                              <label for="world_name" class="form-label light-text">Název světa</label>
                              <input type="text" required class="form-control light-text" id="world_name" name="world_name">
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="desc" class="form-label light-text">Krátká poznámka</label>
                              <input type="text" class="form-control light-text" id="desc" name="desc" required>
                           </div>
                        </div>
                        <button id="create_world" type="submit" class="btn btn-primary px-4 b">Vytvořit!</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</main>
<script>
   $("#create_world").click(function() {
      $name = $("#world_name").val();
      $desc = $("#desc").val();
      if ($name == "" || $desc == "") {
         Swal.fire({
            icon: 'error',
            title: 'Zadejte, prosím, údaje',
         })
         return 0;
      }
      $.ajax({
         url: "<?php echo $config["root_url"] ?>Components/World/PHP/create_world.php",
         method: "POST",
         async: false,
         data: {
            name: $name,
            desc: $desc,
         },
         success: function($result) {
            if ($result != "") {
               Swal.fire({
                  icon: 'error',
                  title: $result,
               })
            } else {
               location.reload();
            }
         }
      });
   });
</script>
<?php
require $config["root"] . "Components/Elements/footer.php";
?>