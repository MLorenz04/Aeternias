<?php
/* Konfigurační soubory */
$config = include("../../../config.php");
require $config["root"] . "/vendor/autoload.php";
/* Připojení do databáze a kolekcí */
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->users;
/* Proměnné */
$nickname = $_POST["username"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
/*Připojení do databáze a založení profilu */
$cursor = $collection->find(["username" => $nickname]);
if (!$cursor->isDead()) { //Jestli není cursor prázdný, jinak pošleme zpět
   header("location: /Omega/Components/Profile/Page/createAccount.php");
} else {
   $_SESSION["table"] = "users";
   $current_id = require $config["root"] . "/Components/Helpers/get_id.php"; //Získáme id
   $insertOneResult = $collection->insertOne([
      "username" => $nickname,
      "id" => $current_id,
      "password" => $password,
      "gender" => ""
   ]);
   require $config["root"] . "/Components/Helpers/update_id.php"; //Zvýšíme id
   header("location: /Omega/Components/Wall/Wall.php");
}
