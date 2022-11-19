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
$date = date("Y-m-d");
/* Security */
if (!(preg_match($regex_new_world_name, $world_name))) {
   $_SESSION["error_mess_new_world"] = $error_mess_world_name;
   header("location:" . $config["root_url"] . "Components/World/Page/new_world.php");
   exit();
}
if (!(preg_match($regex_new_world_desc, $world_desc))) {
   $_SESSION["error_mess_new_world"] = $error_mess_world_desc;
   header("location:" . $config["root_url"] . "Components/World/Page/new_world.php");
   exit();
}

/* Databáze a kolekce */
$con = $config["db"];
/* SQL příkazy */
$sql_check_name = "select name from world where name = ?";
$sql_insert_your_world = "insert into world(id_owner,name,description,date,user_count,warrior_count,battle_count) values(?, ?, ?, ?, 1, 0, 0)";
$sql_create_permission = "insert into permissions(id_owner, id_world) values(?,?)";
/* Předpřipravení příkazi kvůli SQL injection */
$statement = $con->prepare($sql_check_name);
$statement->bind_param("s", $world_name);
$statement->execute();
$result = $statement->get_result();

/* Zjištění, jestli název světa už neexistuje, případně vytvoření světa */
if (mysqli_num_rows($result) == 0) {

   /* Předpřipravení příkazi kvůli SQL injection */
   $statement = $con->prepare($sql_insert_your_world);
   $statement->bind_param("isss", $owner_id, $world_name, $world_desc, $date);
   $statement->execute();
   //Tady bude potřeba ještě kontrola
   $world_id = $con->insert_id;
   $statement = $con->prepare($sql_create_permission);
   $statement->bind_param("ii", $owner_id, $world_id);
   $statement->execute();
   header("location:" . $config["root_url"] . "Components/Wall/wall.php"); //Odkaz na zeď
   exit();

}
/* Redirect na vytvoření nového světa a vrácení chybové hlášky */ 
   $_SESSION["error_mess_new_world"] = $error_mess_existing_name;
   header("location:" . $config["root_url"] . "Components/World/Page/new_world.php");

