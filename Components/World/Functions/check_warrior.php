<?php
/* Začátek session */
session_start();
/* Konfigurační soubor */
global $config;
require_once $config["root_path_require_once"] . "Components/Classes/User.php";
/* Proměnné */
$con = $config['db'];
$id_world = $_SESSION['current_open_world'];
$id_user = (unserialize($_SESSION['logged_user']))->get_id();

function check_data($name, $desc, $attack, $defense, $agility)
{
   require_once $config["root_path_require_once"] . "Components/Errors/error_messages.php";
   if (!(preg_match($regex_new_warrior_name, $name))) {
      echo $error_mess_new_warrior_name;
      exit();
   }
   if (!(preg_match($regex_new_warrior_desc, $desc))) {
      echo $error_mess_new_warrior_desc;
      exit();
   }

   if ($attack < 0 || $defense < 0 || $agility < 0) {
      echo $error_mess_new_warrior_number;
      exit();
   }
}
