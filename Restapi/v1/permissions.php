<?php

require_once "../../Components/Classes/Config.php";
$config = (new Config())->get_instance();
require_once $config["root_path_require_once"] . "Components/Classes/Api/ApiPermissions.php";
$api_private = new ApiPermissions(true);
$api = new ApiPermissions(false);
//Jestli uživatel zadal či nezadal popisek jednotky
$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
   case "POST":
      print($api_private->create_permission());
      break;
   case "GET":
      print($api->get_permission());
      break;
   case "DELETE":
      print($api_private->remove_permission());
      break;
}
exit();
