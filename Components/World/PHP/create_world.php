<?php
/* Konfigurační soubor */
$config = require "../../../config.php";
require "../../Security/security.php";
/* Začátek session */
session_start();
/* Proměnné */
$owner_id = $_SESSION["id_user"];
$world_name = $_POST["world_name"];
$world_desc = $_POST["desc"];

/* Security */
if (!(preg_match($regex_new_world_name, $world_name))) {
   $_SESSION["error_mess_new_world"] = $error_mess_world_name;
   header("location:" . $config["root_url"] . "Components/Wall/wall.php");
   $_SESSION["request_redirect"] = "create_new_world";
   exit();
}
if (!(preg_match($regex_new_world_desc, $world_desc))) {
   $_SESSION["error_mess_new_world"] = $error_mess_world_desc;
   header("location:" . $config["root_url"] . "Components/Wall/wall.php");
   $_SESSION["request_redirect"] = "create_new_world";
   exit();
}

/* Databáze a kolekce */
$con = $config["db"];
/* SQL příkazy */
$sql_check_name = "select name from world where name = ?";
$sql_insert_your_world = "insert into world(id_owner,name,description) values(?, ?, ?)";

/* Předpřipravení příkazi kvůli SQL injection */
$statement = $con->prepare($sql_check_name);
$statement->bind_param("s", $world_name);
$statement->execute();
$result = $statement->get_result();

/* Zjištění, jestli název světa už neexistuje, případně vytvoření světa */
if (mysqli_num_rows($result) == 0) {
   /* Předpřipravení příkazi kvůli SQL injection */
   $statement = $con->prepare($sql_insert_your_world);
   $statement->bind_param("iss", $owner_id, $world_name, $world_desc);
   $statement->execute();
}
header("location:" . $config["root_url"] . "/Components/Wall/wall.php"); //Odkaz na zeď
