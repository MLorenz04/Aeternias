<?php
/* Konfigurační soubor */
require "../Classes/Config.php";
require "../Classes/Errors.php";
$config = (new Config())->get_instance();
$errors = (new Errors(-1))->getList();
/* Hlavička */
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/head.php";
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
/* Kontrola přihlášení */
?>
<main>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-3 section register min-vh-100 d-flex flex-column justify-content-center py-4">
        <div class="card">
          <div class="card-body">
            <div class="row flex text-center main-color card-title">
              <h1> <?php echo $config['project_name'] ?> </h1>
            </div>
            <form method="POST">
              <div class="mb-3">
                <label for="username" class="form-label light-text">Přezdívka</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label light-text">Heslo</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label light-text">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <button id="register" onclick="event.preventDefault()" type="submit" class="btn btn-primary px-4">Zaregistrovat</button>
            </form>
            <div class="light-text">
              Máte již účet? <a href="<?php echo $config["root_path_url"] ?>">Přihlaste se!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</main>
<script>
  $("#register").on("click", function() {
    $name = $("#username").val();
    $email = $("#email").val();
    $password = $("#password").val();
    if (($name.length == 0 || $email.length == 0 || $password.length == 0)) {
      Swal.fire({
        title: "Vyplňte, prosím, všechny údaje",
        icon: "error"
      })
      return;
    }
    $regex_registration_name = new RegExp(<?php echo $errors["regex_registration_name"] ?>);
    $regex_registration_password = new RegExp(<?php echo $errors["regex_registration_name"] ?>);

    if (!($regex_registration_name.test($name))) {
      Swal.fire({
        icon: 'error',
        title: '<?php echo $errors["error_mess_register_name"] ?>',
      })
      return;
    }
    if (!($regex_registration_password.test($password))) {
      Swal.fire({
        icon: 'error',
        title: '<?php echo $errors["error_mess_register_password"] ?>',
      })
      return;
    }

    $.ajax({
      url: "<?php echo $config['root_path_url'] ?>Restapi/v1/users/" + $name + "/" + $email + "/" + $password,
      type: "POST",
      success: function(data) {
        console.log(data);
        Swal.fire({
          title: "Váš účet byl vytvořen!",
          icon: "success"
        });
      }
    }).fail(function(data) {
      console.log(data.responseText);
      Swal.fire({
        "title": data.responseText,
        "icon": "error"
      });
    })
  });
</script>
<?php
require $config["root_path_require_once"] . "Components/Templates/Body_parts/footer.php";
?>