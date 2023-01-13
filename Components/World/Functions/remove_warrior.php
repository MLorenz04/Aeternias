<?php
/* Konfigurační soubor */
require_once '../../../config.php';
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
require_once $config['root_path_require_once'] . "Components/Security/security_functions.php";
if (!(in_array($id_world, unserialize($_SESSION['logged_user'])->get_permissions()))) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
   exit();
}

if (!check_owner($id_world, $user_id)) {
   header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
   exit();
}
/* Založení databáze */
$con = $config['db'];
/* Sql příkazy */
$sql = "delete from warrior where id = $id_warrior";
echo $id_warrior;
echo $sql;
$con->query($sql);
header("location:" . $config['root_path_url'] . "Components/World/Page/page_warriors.php?id=$id_world");
exit();
