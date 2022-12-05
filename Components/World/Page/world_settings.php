<?php
/* Konfigurační soubory */
$config = require "../../../config.php";
/* Require se založením instance světa */
require $config["root"] . "Components/Classes/World.php";
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
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
if (!($id_world = (int)$id_world) == 1) {
   exit();
}
$world = new World();
$world->get_world($id_world);
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header_single_world.php";
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
   $("#update_world").click(function() {
      $name = $("#name").val();
      $desc = $("#desc").val();
      $.ajax({
         url: "<?php echo $config["root_url"] ?>Components/World/PHP/update_world.php",
         method: "POST",
         async: false,
         data: {
            id: <?php echo $id_world ?>,
            name: $name,
            desc: $desc,
         },
         success: function($result) {
            if ($result != "") {
               Swal.fire({
                  icon: 'error',
                  title: $result,
               }).then((result) => {
                  if (result.isConfirmed) {
                     $("#name").val("<?php echo $world->name ?>");
                     $("#desc").val("<?php echo $world->desc ?>");
                  }
               })
            } else {
               location.reload();
            }
         }
      })
   });
</script>