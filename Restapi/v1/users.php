<?php

require_once "../../Components/Classes/Config.php";
$config = (new Config())->get_instance();
require_once $config["root_path_require_once"] . "Components/Classes/Api/ApiProfile.php";
$api = new ApiProfile(false);

//Jestli uživatel zadal či nezadal popisek jednotky
$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
   case "POST":
      print($api->create_account());
      break;
   }
exit();
