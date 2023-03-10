<?php
/* Založení session */
session_start();
/* Konfigurační soubory */
require_once "../../../config.php";
$config = (new Config())->get_instance();
require_once $config['root_path_require_once'] . "Components/Classes/User.php";
require_once $config['root_path_require_once'] . "Components/Classes/World.php";
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$nickname = $user->get_username();
$id_user = $user->get_id();
$id_world = $_GET["id"];
security($id_world, $user);
$world = new World($id_world);
/* Kontrola přihlášení a bezpečnost */
/* Require s ostatními require_onces */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_Parts/php_header_single_world.php";
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
         url: "<?php echo $config['root_path_url'] ?>Components/World/Functions/update_world.php",
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
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>