<?php
/* Konfigurační soubor */
require_once '../../Classes/User.php';
require_once '../../Classes/Config.php';
require_once '../../Classes/Security.php';
/* Začátek sessionu */
session_start();
/* Proměnné */
$config = (new Config())->get_instance();
$s1 = (new Security());
$user = unserialize($_SESSION['logged_user']);
$nickname = $user->getUsername();
$world_count = $user->getWorldCount();
$user_id = $user->getId();
$id_world = $_GET['id'];
$id_warrior = $_GET['id_warrior'];
/* Kontrola, jestli je id vůbec číslo */
if (!($id_warrior = (int)$id_warrior)) {
   exit();
}
/* Kontrola pravomocí */
$s1->security($id_world,$user);

if (!$s1->check_owner($id_world, $user_id)) {
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
