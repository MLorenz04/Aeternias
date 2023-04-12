<?php
/* Konfigurační soubory */
include("../../../Components/Classes/Config.php");
$config = Config::getInstance();
require_once "../../Classes/User.php";
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
/* Připojení do databáze */
$con = $config['db'];
/* Proměnné */
$nickname = $_POST['username'];
$password = $_POST['password'];
/* Sql příkazy */
$sql_get_users = "select * from users where nickname='$nickname'";
/* Přihlášení do stránky */
$result = $con->query($sql_get_users);
if (mysqli_num_rows($result) > 0) {
   while ($row = $result->fetch_assoc()) {
      if (password_verify($password, $row['password'])) {
         $u1 = new User($row['id']);
         $u1->getPermissions();
         $u1 = serialize($u1);
         $_SESSION['logged_user'] = $u1;
         $_SESSION['is_logged'] = true;
         header("location:" . $config['root_path_url'] . "Components/Wall/wall.php"); //Pokud správné heslo, jde na zeď
         //Pokud správné heslo, jde na zeď
         exit();
      }
   }
}
$_SESSION['error_mess_login'] = "Vaše jméno nebo heslo bylo zadáno špatně. Zkuste to, prosím, znovu.";
header("location:" . $config['root_path_url'] . "index.php"); //Pokud špatné heslo, zpět na login
exit();
