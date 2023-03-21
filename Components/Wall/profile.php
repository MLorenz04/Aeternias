<?php
/* Konfigurační soubory */
require_once "../Classes/Config.php";
$config = (new Config())->get_instance();
/* Celá hlavička */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/normal_header.php";
?>
<h1 class="text-center wall-header "> Profil </h1>