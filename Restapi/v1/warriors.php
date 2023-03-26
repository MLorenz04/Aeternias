<?php

require_once "../../Components/Classes/Config.php";
$config = (new Config())->get_instance();
require_once $config["root_path_require_once"] . "Components/Classes/Api/ApiWarrior.php";
/* Unsecure verze, není potřeba kontroly (False) */
$api = new ApiWarrior(false);
/* Secure verze, je potřeba tokeny a přhlášení (False) */
$api_private = new ApiWarrior(true);
switch($_SERVER["REQUEST_METHOD"]) {
   case "GET":
      print($api->get_all_warriors());
      break;
   case "POST":
      print($api_private->create_warrior());
      break;
   case "DELETE":
      print($api_private->remove_warrior());
      break;
}
