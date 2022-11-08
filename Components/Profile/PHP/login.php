<?php
// Include databáze a souboru s globálními proměnnými
$config = include("../../../config.php");
//Data z formuláře 
$nickname = $_POST["username"];
$password = $_POST["password"];
//Proměnná kontrolující, jestli už takové jméno existuje.
$same_password = false;
//Připojení do databáze
$con = new mysqli($config['db_name'], $config['db_username'], $config['db_password'], $config['db_dbname']);
//Sql příkazy
$sql_check_usernames = "select nickname from users";
//Vezmu všechny výsledky
$result = $con -> query($sql_check_usernames);
while($row = $result -> fetch_assoc()) {
   if($row["nickname"] == $nickname) {
      $existing_nickname = true; //Pokud se jméno schoduje se záznamem v databázi
   }
}
//Připojení a provedení sql příkazu
if($existing_nickname == true) { 
   $sql_get_password = "select password, id from users where nickname='$nickname'";
   $result = $con -> query($sql_get_password);
   $passArray = $result -> fetch_assoc();
   $hash = $passArray["password"];
   $id_user = $passArray["id"];
   if(password_verify($password, $hash)) {
      session_start();
      $_SESSION["is_logged"] = true;
      $_SESSION["username"] = $nickname;
      $_SESSION["id_user"] = $id_user;
      header("location: ../../Wall/wall.php"); //Pokud správné heslo, jde na zeď
  } else {
      header("location: ../../../Index.php"); //Pokud špatné heslo, zpět na login
  }
}