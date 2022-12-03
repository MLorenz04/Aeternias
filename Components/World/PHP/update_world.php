<?php
/* Konfigurační soubor */
$config = require "../../../config.php";
require "../../Security/security.php";
/* Začátek session */
session_start();
/* Proměnné */
$owner_id = $_SESSION["id_user"];
$world_name = $_POST["name"];
$world_desc = $_POST["desc"];
$world_id = $_GET["id"];
/* Databáze a kolekce */
$con = $config["db"];
/* Security */

if (!(preg_match($regex_new_world_name, $world_name))) {
   $_SESSION["error_mess_settings"] = $error_mess_world_name;
   header("location:" . $config["root_url"] . "Components/World/Page/world_settings.php?id=$world_id");
   exit();
}

if (!(preg_match($regex_new_world_desc, $world_desc))) {
   $_SESSION["error_mess_settings"] = $error_mess_world_desc;
   header("location:" . $config["root_url"] . "Components/World/Page/world_settings.php?id=$world_id");
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

header("location:" . $config["root_url"] . "Components/World/Page/world_settings.php?id=$world_id");
