<?php
$config = require '../../config.php';
require $config['root'] . 'Components/Elements/head.php';
$list = [
   array('error_id' => 1, 'error_name' => 'Chybějí vám pravomoce', 'error_desc' => 'K tomé části stránky nemáte přístup!'),
   array('error_id' => 2,  'error_name' => 'Neexistující svět', 'error_desc' => 'Tento svět neexistuje!'),
];
$type_of_error = $_GET['id'];
$error_name = 'Chyba stránky na chyby!';
$error_desc = 'Nějakým způsobem jsi našel chybu na stránce o chybách... Jak se ti to povedlo?';
foreach ($list as $error) {
   if ($error['error_id'] == $type_of_error) {
      $error_desc = $error['error_desc'];
      $error_name = $error['error_name'];
      break;
   }
}
?>

<body>
   <div class="d-flex align-items-center justify-content-center vh-100">
      <div class="text-center">
         <h1 class="display-1 fw-bold"></h1>
         <p class="fs-3"> <span class="text-danger">Ajaj!</span> <?php echo $error_name ?></p>
         <p class="lead">
            <?php
            echo $error_desc;
            ?>
         </p>
         <a href="<?php echo $config['root_url'] . "Components/Wall/wall.php"; ?>" class="btn btn-primary">Domů</a>
      </div>
   </div>
</body>

<?php
require "../Elements/footer.php";
?>