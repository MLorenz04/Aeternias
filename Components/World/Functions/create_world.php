<?php
/* Konfigurační soubor */
require_once "../../../Components/Classes/Config.php";
/* Třídy */
require_once "../../Classes/User.php";
require_once "../../Classes/World.php";
$config = Config::getInstance();
require_once "../../Errors/error_messages.php";
/* Začátek session */
session_start();
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$world_count = $user->getWorldCount();
$owner_id = $user->getId();
/* Zkusí získat údaje, pokud se mu to nepodaří, hodí na index */
/* Ochrana proti pokusu jít přímo na soubor bez vyplněného formuláře */
try {
   $world_name = $_POST['name'];
   $world_desc = $_POST['desc'];
} catch (Exception $e) {
   exit();
}
/* Security */
if (!(preg_match($regex_new_world_name, $world_name))) {
   echo $error_mess_world_name;
   exit();
}

if ($world_count >= 10) {
   echo $error_mess_max_world_count;
   exit();
}
/* Databáze a kolekce */
$date = date("Y.m.d");
$con = $config['db'];
/* SQL příkazy */
$sql_check_name = "select name from world where name = ?";
$sql_insert_your_world = "insert into world(id_owner,name,description,date,user_count,warrior_count,battle_count) values(?, ?, ?, ?, 1, 0, 0)";
$sql_create_permission = "insert into permissions(id_owner, id_world,type_of_permission) values(?,?,'Administrátor')";
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
   $statement2 = $con->prepare($sql_create_permission);
   $statement2->bind_param("ii", $owner_id, $world_id,);
   $statement2->execute();
   exit();
}
/* Redirect na vytvoření nového světa a vrácení chybové hlášky */
echo $error_mess_existing_name;
exit();
