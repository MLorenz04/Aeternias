<?php
// Include databáze a souboru s globálními proměnnými
$config = include("../../../config.php");
require $config["root"] . "/vendor/autoload.php";
//Připojení do databáze a kolekce
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->users;
//Data z formuláře 
$nickname = $_POST["username"];
$password = $_POST["password"];
//Proměnná kontrolující, jestli už takové jméno existuje.
$same_password = false;
//Hledání dat v databázi
$cursor = $collection -> find(["username" => $nickname]);
if($cursor -> isDead()) {
   header("location: /Omega/Index.php"); //Pokud špatné heslo, zpět na login
}
foreach($cursor as $k => $row) {
   //Nejdříve vezmeme data z databáze a zakódujeme je do JSONU
   $json = json_encode($row);
   //Vezmeme JSON a uděláme z něj objekt, ke kterému budeme moci přistupovat
   $json = json_decode($json);
   if(password_verify($password,$json -> password)) {
      session_start();
      $_SESSION["is_logged"] = true;
      $_SESSION["username"] = $nickname;
      $_SESSION["id_user"] = ($json -> id);
      header("location: /Omega/Components/Wall/wall.php"); //Pokud správné heslo, jde na zeď
   } else {
      header("location: /Omega/Index.php"); //Pokud špatné heslo, zpět na login
   }
}
