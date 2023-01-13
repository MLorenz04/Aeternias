<?php
require_once '../../config.php';
$config = (new Config())->get_instance();
require_once $config['root_path_require_once'] . 'Components/Templates/Body_parts/head.php';
require_once $config["root_path_require_once"] . 'Components/Classes/Errors.php';
$type_of_error = intval($_GET['id']);
$error = new Errors($type_of_error);
$error_name = 'Chyba stránky na chyby!';
$error_desc = 'Nějakým způsobem jsi našel chybu na stránce o chybách... Jak se ti to povedlo (O.O)?';
?>

<body>
   <div class="d-flex align-items-center justify-content-center vh-100">
      <div class="text-center">
         <h1 class="display-1 fw-bold"></h1>
         <p class="fs-3"> <span class="text-danger">Ajaj!</span> <?php echo $error->get_error_header(); ?></p>
         <p class="lead">
            <?php
            echo $error->get_error_message();
            ?>
         </p>
         <p style="font-weight:200">Pokud si myslíte, že se jedná o chybu, kontaktujte nás.</p>
         <a href="<?php echo $config['root_path_url'] . "Components/Templates/Wall/wall.php"; ?>" class="btn btn-primary">Domů</a>
      </div>
   </div>
</body>

<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_Parts/footer.php";
?>