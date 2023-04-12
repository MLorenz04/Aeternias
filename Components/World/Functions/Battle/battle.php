<?php
/* Requires */
require "../../../../Components/Classes/Config.php";
$config = Config::getInstance();
require $config["root_path_require_once"] . "Components/Classes/Army.php";
require $config["root_path_require_once"] . "Components/Classes/Battle.php";
require $config["root_path_require_once"] . "Components/Classes/User.php";
require $config["root_path_require_once"] . "Components/Classes/World.php";
require $config["root_path_require_once"] . "Components/Classes/Warrior.php";

/* Vytváření slugu pro bitvu - battle831mxAíy.php například. Funguje místo ID */
session_start();
$user = unserialize($_SESSION['logged_user']);
$id = $user->getId();
$slug = $_POST["slug"];
/* Proměnné */
$form_data = $_POST['form-data'];
$form_data_array = array();
parse_str($form_data, $form_data_array);
$warriors1 = $form_data_array["first_army_warriors"];
$warriors2 = $form_data_array["second_army_warriors"];
$id_world = $_GET["id"];
$world = new World($id_world);
$first_army = [];
$second_army = [];
/* Vytvoří podle formuláře objekty válečníků */
foreach ($warriors1 as $id => $count) {;
   if (strlen($count) > 0) {
      if ($count < 0) {
         echo "Jednotky nemohou být v záporné hodnotě";
         exit;
      }
      $warrior = new Warrior($id_world, $id, $count);
      array_push($first_army, $warrior);
   }
}

foreach ($warriors2 as $id => $count) {
   if (strlen($count) > 0) {
      if ($count < 0) {
         echo "Jednotky nemohou být v záporné hodnotě";
         exit;
      }
      $warrior = new Warrior($id_world, $id, $count);
      array_push($second_army, $warrior);
   }
}

/* Vytvoření armád */
$a1 = new Army($first_army);
$a2 = new Army($second_army);
$error = false;
/* Vytvoření bitvy */

$total_health_first_army = $a1->getTotalAttack();
$total_health_second_army = $a2->getTotalAttack();

$total_health = ($total_health_first_army + $total_health_second_army);
if ($total_health == 0) {
   echo "Bitva bez armády nebývá bitva...";
   exit;
}
if ((($total_health_first_army > $total_health_second_army) && $total_health_second_army == 0) || (($total_health_second_army > $total_health_first_army) && $total_health_first_army == 0)) {
   echo "Armáda nemá s kým bojovat :/";
   exit;
}

$battle = new Battle($a1, $a2, $slug, $id_world, $id);
$battle->start_battle();
