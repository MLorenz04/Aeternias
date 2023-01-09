<?php
/* Konfigurační soubory */
$config = include("../../../config.php");
require "../../Security/security.php";
require "../../Classes/Login.php";
session_start();
/* Připojení do databáze */
$con = $config["db"];
/* Proměnné */
$nickname = $_POST["username"];
$password = $_POST["password"];
/* Sql příkazy */
$sql_get_users = "select id,nickname, password from users where nickname='$nickname'";
/* Přihlášení do stránky */
$result = $con->query($sql_get_users);
if (mysqli_num_rows($result) > 0) {
   while ($row = $result->fetch_assoc()) {
      if (password_verify($password, $row["password"])) {
         $u1 = serialize(new User($row["id"], $nickname));
         $_SESSION["logged_user"] = $u1;
         $_SESSION["is_logged"] = true;
         header("location:" . $config["root_url"] . "Components/Wall/wall.php"); //Pokud správné heslo, jde na zeď
         //Pokud správné heslo, jde na zeď
         exit();
      }
   }
}
$_SESSION["error_mess_login"] = "Vaše jméno nebo heslo bylo zadáno špatně. Zkuste to, prosím, znovu.";
//header("location:" . $config["root_url"] . "index.php"); //Pokud špatné heslo, zpět na login
exit();
