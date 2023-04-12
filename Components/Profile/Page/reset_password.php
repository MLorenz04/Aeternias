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
         <div class="col-lg-3 section register min-vh-100 d-flex flex-column justify-content-center py-4" style="width:25rem">
            <div class="card">
               <div class="card-body">
                  <div class="row flex text-center main-color card-title">
                     <h1> <?php echo $config['project_name'] ?> </h1>
                  </div>
                  <form action="../Functions/send_new_password.php" method="POST">
                     <h3> Zapomenuté heslo? </h3>
                     <p> Pošleme vám na email odkaz na obnovení! </p>
                     <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email">
                     </div>
                     <button type="submit" class="btn btn-primary px-4">Odeslat</button>
                  </form>
                  <hr>
                  <div>
                     <a href="../../../index.php"> Zpátky </a>
                  </div>
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
      $email = $("#email").val();
      $.ajax({
        url: '<?php echo $config["root_path_url"] ?>Components/Profile/Functions/send_new_password.php',
        type: 'POST',
        data: {
         email: $email
        },
        success: function($result) {
          showSuccessMess("Žádost o změnu hesla zaslána na emailovou adresu!");
        }
      }).fail(function(data) {
        showErrorMess(data.responseText);
      });
    });
  }
</script>