<?php
/* Konfigurační soubory */
require_once "../../../Components/Classes/Config.php";
$config = Config::getInstance();
/* Celá hlavička */
require_once "../../Templates/Body_parts/world_header.php";
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> Nastavení </h1>
      <p> Zde si můžete upravit svůj svět, jak chcete! </p>
      <form onclick="event.preventDefault()" id="form" method="POST" class="mb-3">
         <div class="mb-3">
            <label for="name" class="form-label">Název světa</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $world->name ?>">
         </div>
         <div class="mb-3">
            <label for="desc" class="form-label">Popisek</label>
            <input type="text" class="form-control" id="desc" name="desc" value="<?php echo $world->desc ?>">
         </div>
         <button id="update_world" class="btn btn-primary"> Uložit </button>
      </form>
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

      $("#update_world").click(function() {
         $name = $("#name").val();
         $desc = $("#desc").val();
         if (isEmpty($name) || isEmpty($desc)) {
            showErrorMess(
               "Zadejte, prosím, údaje"
            )
            return;
         }
         $.ajax({
            url: "<?php echo $config['root_path_url'] ?>Restapi/v1/worlds/<?php echo $id_world ?>/" + $name + "/" + $desc,
            method: "PUT",
            async: false,
            success: function($result) {
               showSuccessMess(
                  $result,
               )
               $("#name").val($name);
               $("#desc").val($desc);
            }
         }).fail(function(data) {
            showErrorMess(data.responseText)
         });
      });
   }
</script>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>