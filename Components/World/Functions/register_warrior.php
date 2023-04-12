<?php
/* Konfigurační soubor */
require_once "../../../Components/Classes/Config.php";
$config = Config::getInstance();
require_once $config["root_path_require_once"] . "Components/Errors/error_messages.php";
require_once $config["root_path_require_once"] . "Components/Classes/World.php";
require_once $config["root_path_require_once"] . "Components/Classes/Security.php";
$con = $config["db"];
$id_world = $_GET["id"];
$world = (new World($id_world))->get_instance();

try {
   $warriors = $_POST['warriors'];
} catch (Exception $e) {
   header("location:" . $config['root_path_url'] . "index.php");
   exit();
}
foreach ($warriors as $warrior) {
   if (!(preg_match($regex_new_warrior_name, $warrior["name"]))) {
      echo $error_mess_new_warrior_name;
      exit();
   }
   if (strlen($warrior["desc"]) > 500) {
      echo $error_mess_new_warrior_desc;
      exit();
   }
   if ($warrior["attack"] < 0 || $warrior["defense"] < 0 || $warrior["agility"] < 0) {
      echo $error_mess_new_warrior_number;
      exit();
   }
   $warrior_list = $world->getWarriors();
   foreach ($warrior_list as $existing_warrior) {
      if ($existing_warrior["name"] === $warrior["name"]) {
         echo $error_mess_existing_warrior;
         exit();
      }
   }
}
foreach ($warriors as $warrior) {
   if ($warrior["desc"] == "" or strlen($warrior["desc"] == 0)) {
      $sql_insert_warrior = 'insert into warrior(name, attack, defense, agility, hp, id_world) values(?, ?, ?, ?, ?, ?)';
      $statement = $con->prepare($sql_insert_warrior);
      $statement->bind_param("siiiii", $warrior["name"], $warrior["attack"], $warrior["defense"], $warrior["agility"], $warrior["health"], $id_world);
      $statement->execute();
   } else {
      $sql_insert_warrior = 'insert into warrior(name, description, attack, defense, agility, hp, id_world) values(?, ?, ?, ?, ?, ?, ?)';
      $statement = $con->prepare($sql_insert_warrior);
      $statement->bind_param("ssiiiii", $warrior["name"], $warrior["desc"], $warrior["attack"], $warrior["defense"], $warrior["agility"], $warrior["health"], $id_world);
      $statement->execute();
   }
}
echo "ok";
exit();
