<?php
session_start();
/* Konfigurační soubory */
$config = include("../../../config.php");
require_once "../../Security/security.php";

/* Připojení do databáze */
$con = $config['db'];

/* Proměnné */
$nickname = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

/* Security */
if (!(preg_match($regex_registration_name, $nickname))) {
   $_SESSION['error_mess_register'] = $error_mess_register_name;
   header("location:" . $config['root_path_url'] . "Components/Profile/Page/createAccount.php");
   exit();
}
if (!(preg_match($regex_registration_password, $password))) {
   $_SESSION['error_mess_register'] = $error_mess_register_password;
   header("location:" . $config['root_path_url'] . "Components/Profile/Page/createAccount.php");
   exit();
}

/* Hash hesla */
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* Sql příkazy */
$sql_find_users = "select nickname from users where nickname=?";
$sql_create_new_user = "insert into users(nickname,password,email) VALUES(?, ?, ?)";

/* Předpříprava hledání kvůli SQL Injection */
$statement = $con->prepare($sql_find_users);
$statement->bind_param("s", $nickname);
$statement->execute();
$result = $statement->get_result();
if (mysqli_num_rows($result) > 0) {
   $_SESSION['error_mess_register'] = $error_mess_existing_name;
   header("location:" . $config['root_path_url'] . "Components/Profile/Page/createAccount.php");
   exit();
}

/* Předpříprava vytváření nového uživatele kvůli SQL Injection */
$statement = $con->prepare($sql_create_new_user);
$statement->bind_param("sss", $nickname, $password, $email);
$statement->execute();
$result = $statement->get_result(); 

/* Úspěšná registrace, skok na hlavní stránku */
$_SESSION['info_mess_success_register'] = $info_mess_success_register;
header("location:" . $config['root_path_url'] . "index.php");
