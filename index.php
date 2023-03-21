<?php
/* Konfigurační soubory */
include("Components/Classes/Config.php");
$config = (new Config())->get_instance();
/* Hlavička */
require_once "Components/Templates/Body_Parts/head.php";
require_once "Components/Classes/Security.php";
require_once "Components/Classes/User.php";
?>

<body>
  <main>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-3 section register min-vh-100 d-flex flex-column justify-content-center py-4">
          <div class="card">
            <div class="card-body">
              <div class="row flex text-center main-color card-title">
                <h1> <?php echo $config['project_name'] ?> </h1>
              </div>
              <form action="Components/Profile/Functions/login.php" method="POST">
                <div class="mb-3">
                  <label for="username" class="form-label">Přezdívka</label>
                  <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Heslo</label>
                  <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">Zapamatovat</label>
                </div>

                <?php
                if (isset($_SESSION['error_mess_login'])) { ?>
                  <div class="error_message pb-3 alert alert-danger" id="error_mess_login">
                    <?php
                    echo $_SESSION['error_mess_login'];
                    unset($_SESSION['error_mess_login']);
                    ?>
                  </div>
                <?php
                }
                if (isset($_SESSION['info_mess_success_register'])) { ?>
                  <div class="error_message pb-3 alert alert-success" id="info_mess_success_register">
                    <?php
                    echo $_SESSION['info_mess_success_register'];
                    unset($_SESSION['info_mess_success_register']);
                    ?>
                  </div>
                <?php
                }
                ?>

                <button type="submit" class="btn btn-primary px-4 b">Přihlásit</button>
              </form>
              <div class="">
                Nemáte účet? <a href="<?php echo $config['root_path_url'] ?>Components/Profile/Page/createAccount.php"> Zaregistrujte se! </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>