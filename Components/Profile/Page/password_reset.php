<?php
require "../../../Components/Classes/Config.php";
$config = Config::getInstance();
$config["db"]->begin_transaction();
$hash = $_GET["pass"];
$sql = "select email from password_resets where hash=?";
$sql_delete = "select * from users where email=?";
/* Získání email */
$statement = $config["db"]->prepare($sql);
$statement->bind_param("s", $hash);
$statement->execute();
$result = $statement->get_result();
$email = $result->fetch_assoc();
$statement = $config["db"]->prepare($sql_delete);
$statement->bind_param("s", $email["email"]);
$statement->execute();
$user = $statement->get_result();
$user = $user->fetch_assoc();
?>
<?php
require_once $config["root_path_require_once"] . "Components/Templates/Body_parts/head.php";
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
                  <form method="POST">
                     <div class="mb-3">
                        <label for="password" class="form-label light-text">Heslo</label>
                        <input type="password" class="form-control" id="password" name="password">
                     </div>
                     <div class="mb-3">
                        <label for="password_conf" class="form-label light-text">Nové heslo</label>
                        <input type="password" class="form-control" id="password_conf" name="password_conf">
                     </div>
                     <button id="change_password" onclick="event.preventDefault()" type="submit" class="btn btn-primary px-4">Změnit heslo</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</main>
<script>
   $(document).ready(function() {
      $.ajaxSetup({
         beforeSend: function(xhr) {
            xhr.setRequestHeader('Api-token', '<?php echo $user["api_token"] ?>');
            xhr.setRequestHeader('Api-hash', '<?php echo $user["api_email"] ?>');
         }
      });
   });
   $("#change_password").click(function() {
      $pass = $("#password").val();
      $pass_conf = $("#password_conf").val();
      if ($pass == null || $pass_conf == null ) {
            Swal.fire({
               icon: 'error',
               title: 'Nezadal jste údaje'
            })
            return;
         }
      if($pass)
      $.ajax({
        url: '<?php echo $config["root_path_url"] ?>Restapi/v1/users/<?php echo $user["id"] ?>/<?php echo $user["nickname"] ?>/<?php echo $user["email"] ?>/' + $pass,
        type: 'PUT',

        success: function($result) {
          showSuccessMessAndRedirect("Obnova proběhla úspěšně!", "<?php echo $config["root_path_url"] ?>index.php");
        }
      }).fail(function(data) {
        showErrorMess(data.responseText);
      });
   });
</script>
<?php
/* Odebrání záznamu */
$statement = $config["db"]->prepare($sql_delete);
$statement->bind_param("s", $hash);
$statement->execute();
?>