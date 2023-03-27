<?php
/* Konfigurační soubory */
require_once "../../Classes/Config.php";
require_once "../../Classes/User.php";
require_once "../../Classes/Security.php";
session_start();
$user = unserialize($_SESSION["logged_user"]);
$config = (new Config())->get_instance();
$users_profile = new User($_GET["id"]);
if ($users_profile->getId() != $user->getId()) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=4");
   exit();
}

/* Celá hlavička */
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/normal_header.php";
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/php_header.php";
if ($users_profile->getEmail() == null) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=4");
   exit();
}
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <h1> Nastavení </h1>
      <p> Zde si můžete upravit svůj profil </p>
      <form onclick="event.preventDefault()" id="form" method="POST" class="mb-3">
         <div class="mb-3">
            <label for="name" class="form-label">Jméno</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $users_profile->getUsername() ?>">
         </div>
         <div class="mb-3">
            <label for="desc" class="form-label">Email</label>
            <input type="text" class="form-control" id="desc" name="desc" value="<?php echo $users_profile->getEmail() ?>">
         </div>
         <div class="mb-3">
            <label for="password" class="form-label">Nové heslo</label>
            <input type="password" class="form-control" id="password" name="password" value="">
         </div>
         <div class="mb-3">
            <label for="password_conf" class="form-label">Potvrzení</label>
            <input type="password" class="form-control" id="password_conf" name="password_conf" value="">
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
         $password = $("#password").val();
         $password_conf = $("#password_conf").val();
         if (isEmpty($name) || isEmpty($desc) || (!isEmpty($password) && isEmpty($password_conf)) || (isEmpty($password) && !isEmpty($password_conf))) {
            showErrorMess(
               "Zadejte, prosím, údaje"
            )
            return;
         }
         if ($password != $password_conf) {
            showErrorMess(
               "Vaše hesla se neshodují!"
            )
            return;
         }
         if (!isEmpty($password) && !isEmpty($password_conf)) {
            $url = "<?php echo $config['root_path_url'] ?>Restapi/v1/users/<?php echo $users_profile->getId() ?>/" + $name + "/" + $desc + "/" + $password;
         } else {
            $url = "<?php echo $config['root_path_url'] ?>Restapi/v1/users/<?php echo $users_profile->getId() ?>/" + $name + "/" + $desc
         }
         $.ajax({
            url: $url,
            method: "PUT",
            async: false,
            success: function($result) {
               showSuccessMess(
                  $result,
               )
               $("#name").val($name);
               $("#desc").val($desc);
               if (isEmpty($password)) {}
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