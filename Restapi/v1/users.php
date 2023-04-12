<?php

require_once "../../Components/Classes/Config.php";
$config = Config::getInstance();
require_once $config["root_path_require_once"] . "Components/Classes/Api/ApiProfile.php";
$api = new ApiProfile(false);
$api_private = new ApiProfile(true);
//Jestli uživatel zadal či nezadal popisek jednotky
$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
   case "POST":
      print($api->create_account());
      break;
   case "PUT":
      print($api_private->update_profile());
      break;
}
exit();
