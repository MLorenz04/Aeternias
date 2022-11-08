<?php
// Include databáze a souboru s globálními proměnnými
$config = include("../../../config.php");
require $config["root"] . "/vendor/autoload.php";
//Připojení do databáze a kolekce
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->users;
$count = $client->Aeternias->counters;
//Data z formuláře
$nickname = $_POST["username"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
//Proměnná kontrolující, jestli už takové jméno existuje.
$existingNickname = false;
//Připojení do databáze
$cursor = $collection->find(["username" => $nickname]);
if (!$cursor->isDead()) { //Jestli není cursor prázdný
   header("location: /Omega/Components/Profile/Page/createAccount.php");
} else {
   $_SESSION["table"] = "users";
   $current_id = require $config["root"] . "/Components/Helpers/get_id.php";
   $insertOneResult = $collection->insertOne([
      "username" => $nickname,
      "id" => $current_id,
      "password" => $password,
      "gender" => ""
   ]);
   require $config["root"] . "/Components/Helpers/update_id.php";
   header("location: /Omega/Components/Wall/Wall.php");
}
