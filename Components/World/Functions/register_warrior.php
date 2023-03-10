<?php
/* Konfigurační soubor */
require_once "../../../config.php";
$config = (new Config())->get_instance();
require_once $config["root_path_require_once"] . "Components/Security/security_functions.php";
require_once $config["root_path_require_once"] . "Components/Errors/error_messages.php";
require_once $config["root_path_require_once"] . "Components/Classes/World.php";
$con = $config["db"];
$id_world = $_GET["id"];
$world = new World($id_world);

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
   if (!(preg_match($regex_new_warrior_desc, $warrior["desc"]))) {
      echo $error_mess_new_warrior_desc;
      exit();
   }

   if ($warrior["attack"] < 0 || $warrior["defense"] < 0 || $warrior["agility"] < 0) {
      echo $error_mess_new_warrior_number;
      exit();
   }
   $warrior_list = $world->get_warriors();
   foreach($warrior_list as $existing_warrior) {
      if(strcasecmp($existing_warrior["name"],$warrior["name"])) {
         echo $error_mess_existing_warrior;
         exit();
      }
   }
}
foreach ($warriors as $warrior) {
$sql_insert_warrior = 'insert into warrior(name, description, attack, defense, agility, id_world) values(?, ?, ?, ?, ?, ?)';
$statement = $con->prepare($sql_insert_warrior);
$statement->bind_param("ssiiii", $warrior["name"], $warrior["desc"], $warrior["attack"], $warrior["defense"], $warrior["agility"], $id_world);
$statement->execute();
echo "registered";
}
exit();
