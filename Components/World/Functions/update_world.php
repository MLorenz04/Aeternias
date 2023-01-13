<?php
/* Konfigurační soubor */
require_once "../../Security/security.php";
require_once "../../../config.php";
$config = (new Config())->get_instance();
/* Začátek session */
session_start();
/* Zkusí získat údaje, pokud se mu to nepodaří, hodí na index */
/* Ochrana proti pokusu jít přímo na soubor bez vyplněného formuláře */
try {
   $world_name = $_POST['name'];
   $world_desc = $_POST['desc'];
   $world_id = $_POST['id'];
} catch (Exception $e) {
   header("location:" . $config['root_path_url'] . "index.php");
   exit();
}
/* Databáze a kolekce */
$con = $config['db'];
/* Security */

if (!(preg_match($regex_new_world_name, $world_name))) {
   echo $error_mess_world_name;
   exit();
}

if (!(preg_match($regex_new_world_desc, $world_desc))) {
   echo $error_mess_world_desc;
   exit();
}

/* SQL příkazy */

$sql_update_name = "update world set name = ? where id = $world_id";
$statement = $con->prepare($sql_update_name);
$statement->bind_param("s", $world_name,);
$statement->execute();

$sql_update_desc = "update world set description = ? where id = $world_id";
$statement = $con->prepare($sql_update_desc);
$statement->bind_param("s", $world_desc);
$statement->execute();
exit();
