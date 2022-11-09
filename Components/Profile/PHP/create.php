<?php
/* Konfigurační soubory */
$config = include("../../../config.php");
/* Připojení do databáze */
$con = $config["db"];
/* Proměnné */
$nickname = $_POST["username"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$email = $_POST["email"];
/* Sql příkazy */
$sql_find_users = "select nickname from users where nickname='$nickname'";
$sql_create_new_user = "insert into users(nickname,password,email) values('$nickname','$password','$email')";
$result = $con->query($sql_find_users);
if(mysqli_num_rows($result) > 0) {
   header("location:" . $config["root_url"] . "Components/Profile/Page/createAccount.php");
   exit();
} 
$con->query($sql_create_new_user);
/*Připojení do databáze a založení profilu */
   header("location:" . $config["root_url"] . "Components/Wall/wall.php");
