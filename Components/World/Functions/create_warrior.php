<?php
/* Konfigurační soubor */
require_once "../../../config.php";
require_once "../../Classes/User.php";
$config = (new Config()) -> get_instance();
/* Začátek session */
session_start();
require_once "../../Security/security.php";
/* Databáze */
$con = $config['db'];
/* Proměnné */
$id_world = $_SESSION['current_open_world'];
$id_user = (unserialize($_SESSION['logged_user']))->get_id();

/* Kontrola pravomocí */
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
if (!(in_array($id_world, (unserialize($_SESSION['logged_user'])->get_permissions())))) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
   exit();
}
/* Zkusí získat údaje, pokud se mu to nepodaří, hodí na index */
/* Ochrana proti pokusu jít přímo na soubor bez vyplněného formuláře */
try {
   $name = $_POST['name'];
   $desc = $_POST['desc'];
   $attack = $_POST['attack'];
   $defense = $_POST['defense'];
   $agility = $_POST['agility'];
} catch (Exception $e) {
   header("location:" . $config['root_path_url'] . "index.php");
   exit();
}

/* Kontrola údajů  */

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
/* Sql příkazy */
$sql_insert_warrior = 'insert into warrior(name, description, attack, defense, agility, id_world) values(?, ?, ?, ?, ?, ?)';
$statement = $con->prepare($sql_insert_warrior);
$statement->bind_param("ssiiii", $name, $desc, $attack, $defense, $agility, $id_world);
$statement->execute();
exit();
