<?php
/* Konfigurační soubor */
$config = require "../../../config.php";
/* Začátek session */
session_start();
require "../../Security/security.php";
/* Databáze */
$con = $config["db"];
/* Proměnné */
$id_world = $_SESSION['current_open_world'];
$id_user = $_SESSION["id_user"];

/* Kontrola pravomocí */
require $config["root"] . "Components/Security/security_functions.php";
if (!check_permission($id_user, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}

if (!check_owner($id_world, $id_user)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}

$name = $_POST["name"];
$desc = $_POST["desc"];
$attack = $_POST["attack"];
$defense = $_POST["defense"];
$agility = $_POST["agility"];

/* Kontrola údajů  */

if (!(preg_match($regex_new_warrior_name, $name))) {
   $_SESSION["error_mess_new_warrior"] = $error_mess_new_warrior_name;
   header("location:" . $config["root_url"] . "Components/World/Page/world_create_warrior.php?id=$id_world");
   exit();
}
if (!(preg_match($regex_new_warrior_desc, $desc))) {
   $_SESSION["error_mess_new_warrior"] = $error_mess_new_warrior_desc;
   header("location:" . $config["root_url"] . "Components/World/Page/world_create_warrior.php");
   exit();
}

if ($attack < 0 || $defense < 0 || $agility < 0) {
   $_SESSION["error_mess_new_warrior"] = $error_mess_new_warrior_number;
   header("location:" . $config["root_url"] . "Components/World/Page/world_create_warrior.php");
   exit();
}
/* Sql příkazy */
$sql_insert_warrior = 'insert into warrior(name, description, attack, defense, agility, id_world) values(?, ?, ?, ?, ?, ?)';
$statement = $con->prepare($sql_insert_warrior);
$statement->bind_param("ssiiii", $name, $desc, $attack, $defense, $agility, $id_world);
$statement->execute();
header("location:" . $config["root_url"] . "Components/World/Page/world_create_warrior.php");
