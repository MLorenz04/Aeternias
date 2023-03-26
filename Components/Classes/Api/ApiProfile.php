<?php
require "Api.php";
class ApiProfile extends Api
{
   function create_account()
   {

      $nickname = strip_tags($_GET['username']);
      $password = strip_tags($_GET['password']);
      $email = strip_tags($_GET['email']);

      function checkLength($string, $min, $max, $name)
      {
         $length = strlen($string);
         if ($length < $min || $length > $max) {
            header("HTTP/1.1 400 Bad Request");
            echo "Toto $name je mimo povolený rozsah. ($min-$max znaků)";
            exit();
         }
      }
      checkLength($nickname, 5, 25, 'jméno');
      checkLength($password, 8, 25, 'heslo');
      /* Hash hesla */
      $password = password_hash($password, PASSWORD_DEFAULT);

      /* Sql příkazy */
      $sql_find_users = "select nickname, email from users where nickname=? or email=?";
      $sql_create_new_user = "insert into users(nickname,password,email, api_token, api_email) VALUES(?, ?, ?, ?, ?)";

      /* Předpříprava hledání kvůli SQL Injection */
      $this->config["db"]->begin_transaction();
      $statement = $this->config["db"]->prepare($sql_find_users);
      $statement->bind_param("ss", $nickname, $email);
      $statement->execute();
      $result = $statement->get_result();

      if (mysqli_num_rows($result) > 0) {
         $row = $result->fetch_assoc();
         $err = "";
         echo ($row["nickname"] == $nickname) ? "Toto jméno již existuje" : "Tento email již existuje";
         header("HTTP/1.1 400 Bad Request");
         echo $err;
         exit();
      }

      /* Předpříprava vytváření nového uživatele kvůli SQL Injection */
      $hash = bin2hex(random_bytes(22));
      $email_hash = hash("sha256", $email);
      $statement = $this->config["db"]->prepare($sql_create_new_user);
      $statement->bind_param("sssss", $nickname, $password, $email, $hash, $email_hash);
      $statement->execute();
      $this->config["db"]->commit();
      /* Úspěšná registrace, skok na hlavní stránku */
      header("HTTP/1.1 201 Created");
      echo "Účet byl vytvořen!";
   }
}
