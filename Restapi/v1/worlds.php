<?php

require_once "../../Components/Classes/Config.php";
$config = Config::getInstance();
require_once $config["root_path_require_once"] . "Components/Classes/Api/ApiWorld.php";
/* Unsecure verze, není potřeba kontroly (False) */
$api = new ApiWorld(false);
/* Secure verze, je potřeba tokeny a přhlášení (False) */
$api_private = new ApiWorld(true);
switch ($_SERVER["REQUEST_METHOD"]) {
   case "GET":
      print($api->get_all_worlds());
      break;
   case "POST":
      print($api_private->create_world());
      break;
   case "PUT":
      print($api_private->update_world());
      break;
   case "DELETE":
      print($api_private->remove_world());
      break;
}
