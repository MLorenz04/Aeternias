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
      <h1> Správa uživatelů </h1>
      <p> Zde můžete spravovat hráče ve Vašem úžasném světě! Přidejte kohokoliv budete chtít, upravujte jim role, dejte jim přezdívky a nechte je bojovat! </p>
      <div class="container container-add-user justify-content-center">
         <div class="col-lg-5" id="list_of_users">
            <h3 class="text-center"> Seznam uživatelů </h3>
            <?php require_once $config['root_path_require_once'] . "Components/Templates/list_of_users.php" ?>
         </div>
         <div class="container justify-content-center container-permission">
            <div class="col-lg-5">
               <h3 class="text-center"> Přidejte uživatele </h3>
               <form>
                  <input class="form-control" type="text" id="user"> </input>
                  <button class="btn btn-primary m-auto d-flex mt-2" type="submit" id="submit" onclick="event.preventDefault();"> Přidat </button>
               </form>
            </div>
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
   $id = "";
   $("#submit").click(function() {
      $username = $("#user").val();
      if ($("#user").val() == "") {
         Swal.fire({
            icon: 'error',
            title: 'Musíte zadat uživatele',
         })
         return 0;
      }
      $.ajax({
         url: "<?php echo $config['root_path_url'] ?>Restapi/v1/permissions/<?php echo $id_world ?>/" + $username + "",
         type: "POST",
         async: false,
         success: function($result) {
            showSuccessMessAndReload($result);
         }
      }).fail(function(data) {
         showErrorMess(data.responseText);
      });
   })
   $(".remove_permission").click(function() {
      $username = $("#user").val();
      $id_warrior = this.id;
      $.ajax({
         url: "<?php echo $config['root_path_url'] ?>Restapi/v1/permissions/<?php echo $id_world ?>/" + $id_warrior,
         method: "DELETE",
         async: false,
         success: function($result) {
            showSuccessMessAndReload($result);
         }
      }).fail(function(data) {
         showErrorMess(data.responseText);
      });
   });
</script>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>