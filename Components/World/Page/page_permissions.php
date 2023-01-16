<?php
/* Konfigurační soubory */
require_once "../../../config.php";
$config = (new Config())->get_instance();
/* Uživatel */
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
/* Založení session */
session_start();
/* Security */
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$nickname = $user->get_username();
$id_user = $user->get_id();
$id_world = $_GET["id"];
/* Kontrola přihlášení a bezpečnost */
security();
/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_Parts/php_header_single_world.php";

/*  */
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> Správa uživatelů </h1>
      <p> Zde můžete spravovat hráče ve Vašem úžasném světě! Přidejte kohokoliv budete chtít, upravujte jim role, dejte jim přezdívky a nechte je bojovat! </p>
      <div class="container d-flex justify-content-center">
         <div class="col-lg-5" id="list_of_users">
            <h3 class="text-center"> Seznam uživatelů </h3>
            <?php require_once $config['root_path_require_once'] . "Components/Templates/list_of_users.php" ?>
         </div>
         <div class="container d-flex justify-content-center">
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
   $id = "";
   $("#submit").click(function() {
      if ($("#user").val() == "") {
         Swal.fire({
            icon: 'error',
            title: 'Musíte zadat uživatele',
         })
         return 0;
      }
      $username = $("#user").val();
      $.ajax({
         url: "<?php echo $config['root_path_url'] ?>Restapi/v1/get_user_by_name.php",
         type: "POST",
         async: false,
         data: {
            username: $username
         },
         success: function(result) {
            $id = result;
            if ($id == "error") {
               return 0;
            }
         },
      })
      $.ajax({
         url: "<?php echo $config['root_path_url'] ?>Components/World/Functions/write_permission.php",
         method: "POST",
         async: false,
         data: {
            id: $id,
            current_open_world: <?php echo $id_world ?>
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
      })
   })
   $(".remove_permission").click(function() {
      $id_warrior = this.id;

      $.ajax({
         url: "<?php echo $config['root_path_url'] ?>Components/World/Functions/remove_permission.php",
         method: "POST",
         async: false,
         data: {
            id: $id_warrior,
            id_world: <?php echo $id_world ?>
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
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>