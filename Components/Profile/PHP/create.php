<?php
// Include databáze a souboru s globálními proměnnými
$vars = include("../../../config.php");
//Data z formuláře
$nickname = $_POST["username"];
$password = $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
//Proměnná kontrolující, jestli už takové jméno existuje.
$existingNickname = false;
//Připojení do databáze
$con = new mysqli($config['db_name'], $config['db_username'], $config['db_password'], $config['db_dbname']);
//Sql příkazy
$sql_create_profile = "insert into users(nickname,password) values('$nickname','$password')";
$sql_check_usernames = "select nickname from users";
$result = $con -> query($sql_check_usernames);
while($row = $result -> fetch_assoc()) {
   if($row["nickname"] == $nickname) {
      $existingNickname = true;
   }
}
//Připojení a provedení sql příkazu
if($existingNickname == false) { 
   $con -> query($sql_create_profile);
   header("location: /Omega/Wall.php");
} else { 
   header("location: /Omega/Index.php");
}
