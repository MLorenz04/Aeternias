<?php
/* Konfigurační soubor */ 
$config = require "../../../config.php"; 
require $config["root"] . "/vendor/autoload.php";
/* Začátek session */
session_start();
/* Proměnné */
$owner_id = $_SESSION["id_user"]; 
$world_name = $_POST["world_name"];
$world_desc = $_POST["desc"]; 
/* Databáze a kolekce */
$con = $config ["db"];
/* SQL příkazy */
$sql_check_name = "select name from world where name='$world_name'";
$sql_insert_your_world = "insert into world(id_owner,name,description) values($owner_id,'$world_name','$world_desc')";
/* Zjištění, jestli název světa už neexistuje, případně vytvoření světa */
if(mysqli_num_rows($con->query($sql_check_name))==0) {
   $con-> query($sql_insert_your_world);
}
   header("location:" . $config["root_url"] . "/Components/Wall/wall.php"); //Odkaz na zeď
   