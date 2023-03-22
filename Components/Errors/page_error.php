<?php
require_once '../../Components/Classes/Config.php';
$config = (new Config())->get_instance();
require_once $config['root_path_require_once'] . 'Components/Templates/Body_parts/head.php';
require_once $config["root_path_require_once"] . 'Components/Classes/Errors.php';
if (!isset($_GET["id"])) {
   $error = new Errors(0);
} else {
   $error = new Errors($_GET["id"]);
}
?>

<body>
   <div class="d-flex align-items-center justify-content-center vh-100">
      <div class="text-center">
         <h1 class="display-1 fw-bold"></h1>
         <p class="fs-3"> <span class="text-danger">Ajaj!</span> <?php echo $error->getErrorHeader(); ?></p>
         <p class="lead">
            <?php
            echo $error->getErrorMessage();
            ?>
         </p>
         <p style="font-weight:200">Pokud si myslíte, že se jedná o chybu, kontaktujte nás.</p>
         <a href="<?php echo $config['root_path_url'] . "Components/Wall/wall.php"; ?>" class="btn btn-primary">Domů</a>
      </div>
   </div>
</body>

<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>