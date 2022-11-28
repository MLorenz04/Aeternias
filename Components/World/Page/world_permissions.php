<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Založení session */
session_start();
/* Security */ 
require $config["root"] . "Components/Security/security_functions.php";
/* Kontrola přihlášení */
if (check_login() == False) {
   header("location: " . $config["root_url"] . "index.php");
}
/* Proměnné */
$nickname = $_SESSION["username"];
$id_user = $_SESSION["id_user"];
$id_world = $_GET["id"];

/* Bezpečnost */
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> Správa uživatelů </h1>
      <p> Zde můžete spravovat hráče ve Vašem úžasném světě! Přidejte kohokoliv budete chtít, upravujte jim role, dejte jim přezdívky a nechte je bojovat! </p>
      <div class="container d-flex justify-content-center">
         <div class="col-lg-5">
            <h3 class="text-center"> Seznam uživatelů </h3>
            <?php require $config["root"] . "Components/Elements/list_of_users.php" ?>
         </div>
         <div class="container d-flex justify-content-center">
            <div class="col-lg-5">
               <h3 class="text-center"> Přidejte uživatele </h3>
               <form>
                  <input class="form-control" type="text" id="user"> </input>
                  <button class="btn btn-primary" type="submit" id="submit" onclick="event.preventDefault();"> Přidat </button>
               </form>
            </div>
         </div>
      </div>
</main>
<script>
   $id = ""
   $("#submit").click(function() {
      if ($("#user").val() == "") {
         alert("Musíte zadat uživatele");
         return 0
      }
      $username = $("#user").val();
      $.ajax({
         url: "<?php echo $config["root_url"] ?>/Restapi/v1/get_user_by_name.php",
         type: "POST",
         async: false,
         data: {
            username: $username
         },
         success: function(result) {
            $id = result;
            console.log($id);
            if ($id == "error") {
               return 0;
            }
         },
      })
      $.ajax({
         url: "<?php echo $config["root_url"] ?>Components/World/PHP/write_permission.php",
         method: "POST",
         asnyc: false,
         data: {
            id: $id
         },
         success: function($result) {
            alert($result);
         }
      })
   })
</script>