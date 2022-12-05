<?php
/* Konfigurační soubor */
$config = require '../../../config.php';
/* Začátek sessionu */
session_start();
/* Proměnné */
$user_id = $_SESSION['id_user'];
$id_world = $_SESSION['current_open_world'];
$id_warrior = $_GET['id_warrior'];
/* Kontrola, jestli je id vůbec číslo */
if (!($id_warrior = (int)$id_warrior)) {
   exit();
}
/* Kontrola pravomocí */
require $config["root"] . "Components/Security/security_functions.php";
if (!check_permission($user_id, $id_world)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}

if (!check_owner($id_world, $user_id)) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
   exit();
}
/* Založení databáze */
$con = $config['db'];
/* Sql příkazy */
$sql = "delete from warrior where id = $id_warrior";
echo $id_warrior;
echo $sql;
$con->query($sql);
header("location:" . $config["root_url"] . "Components/World/Page/world_warriors.php?id=$id_world");
exit();
