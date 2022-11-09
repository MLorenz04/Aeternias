<?php
/* Konfigurační soubory */
$config = include("../../../config.php");
require $config["root"] . "/vendor/autoload.php";
/* Připojení do databáze a kolekce */
$client = new MongoDB\Client($config["mongo_db"]);
$collection = $client->Aeternias->users;
/* Proměnné */
$nickname = $_POST["username"];
$password = $_POST["password"];
/* Přihlášení do stránky */
$cursor = $collection -> find(["username" => $nickname]);
if($cursor -> isDead()) {
   header("location: /Omega/index.php"); //Pokud špatné heslo, zpět na login
}
foreach($cursor as $k => $single_json_file) {
   $json_temp = json_encode($single_json_file); //Nejdříve vezmeme data z databáze a zakódujeme je do JSONU
   $json = json_decode($json_temp); //Vezmeme JSON a uděláme z něj objekt, ke kterému budeme moci přistupovat
   if(password_verify($password,$json -> password)) {
      session_start();
      $_SESSION["is_logged"] = true;
      $_SESSION["username"] = $nickname;
      $_SESSION["id_user"] = ($json -> id);
      header("location: /Omega/Components/Wall/wall.php"); //Pokud správné heslo, jde na zeď
   } else {
      header("location: /Omega/index.php"); //Pokud špatné heslo, zpět na login
   }
}
