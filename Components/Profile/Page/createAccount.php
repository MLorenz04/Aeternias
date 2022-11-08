<?php
require "../../../Components/Elements/head.php";
$config = include("../../../config.php");
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
            <form action="<?php echo $profiles ?>/login.php" method="POST">
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
              <button type="submit" class="btn btn-primary px-4 b">Zaregistrovat</button>
            </form>
            <div class="">
              Máte již účet? <a href="../../../Index.php">Přihlaste se!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>