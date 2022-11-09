<?php
/* Konfigurační soubory */
$config = include("../../../config.php");
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
         session_start();
         $_SESSION["is_logged"] = true;
         $_SESSION["username"] = $nickname;
         $_SESSION["id_user"] = $row["id"];
         header("location:" . $config["root_url"] . "Components/Wall/wall.php"); //Pokud správné heslo, jde na zeď
          //Pokud správné heslo, jde na zeď
         exit();
      }
   }
} 

header("location:" . $config["root_url"] . "index.php"); //Pokud špatné heslo, zpět na login
