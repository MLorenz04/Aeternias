<?php
/* Konfigurační soubor */
include("../../../Components/Classes/Config.php");
$config = Config::getInstance();
/* Hlavička */
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/head.php";
session_start();
/* Kontrola přihlášení */
?>
<main style="margin-left:0; padding-top:0">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-3 section register min-vh-100 d-flex flex-column justify-content-center py-4">
        <div class="card">
          <div class="card-body">
            <div class="row flex text-center main-color card-title">
              <h1> <?php echo $config['project_name'] ?> </h1>
            </div>
            <form  onclick="event.preventDefault()">
              <div class="mb-3">
                <label for="username" class="form-label">Přezdívka</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <?php
              if (isset($_SESSION['error_mess_register'])) { ?>
                <div class="error_message pb-3 alert alert-danger" id="error_mess_register">
                  <?php
                  echo $_SESSION['error_mess_register'];
                  unset($_SESSION['error_mess_register']);
                  ?>
                </div>
              <?php
              }
              ?>
              <button type="submit" id="submit" class="btn btn-primary px-4">Zaregistrovat</button>
            </form>
            <hr>
            <div class="">
              Máte již účet? <a href="../../../index.php">Přihlaste se!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  window.onload = function() {
    $("#submit").click(function() {
      $name = $("#username").val();
      $password = $("#password").val();
      $email = $("#email").val();
      $.ajax({
        url: '<?php echo $config["root_path_url"] ?>Restapi/v1/users/' + $name + "/" + $email + "/" + $password,
        type: 'POST',

        success: function($result) {
          showSuccessMess("Registrace proběhla úspěšně!");
        }
      }).fail(function(data) {
        showErrorMess(data.responseText);
      });
    });
  }
</script>