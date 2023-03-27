<?php
require "Api.php";
/**
 * Odděděná třída API pro zpracování požadavků ohledně světa
 * @author Matyáš Lorenz
 * @extends Api
 */
class ApiProfile extends Api
{
   /**
    * Pomocná metoda kontrolující, zdali je hodnota v rozsahu.
    * @param mixed $string Řetězec znaků
    * @param mixed $min Minimální délka řetězce
    * @param mixed $max Maximální délka řetězce
    * @param mixed $name O jakou proměnnou / informaci se jedná
    * @return err Informační hláška
    */
   function checkLength($string, $min, $max, $name)
   {
      $length = strlen($string);
      if ($length < $min || $length > $max) {
         header("HTTP/1.1 400 Bad Request");
         return "Toto $name je mimo povolený rozsah. ($min-$max znaků)";
         exit();
      }
   }
   /**
    * API metoda pro vytváření uživatelova účtu
    *
    * @return err Informační hláška a stavový kód
    */
   function create_account()
   {

      $nickname = strip_tags($_GET['username']);
      $password = strip_tags($_GET['password']);
      $email = strip_tags($_GET['email']);

      $this->checkLength($nickname, 5, 25, 'jméno');
      $this->checkLength($password, 8, 25, 'heslo');
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
         header("HTTP/1.1 400 Bad Request");
         return ($row["nickname"] == $nickname) ? "Toto jméno již existuje" : "Tento email již existuje";
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
      return "Účet byl vytvořen!";
   }
   /**
    * API metoda pro upravení uživatelova účtu
    *
    * @return err Informační hláška a stavový kód
    */
   function update_profile()
   {
      $id = strip_tags($_GET["id"]);
      $nickname = strip_tags($_GET['username']);
      (isset($_GET["password"])) ?  $password = strip_tags($_GET['password']) : $password = $this->user->getPassword();
      $email = strip_tags($_GET['email']);

      $this->config["db"]->begin_transaction();
      $sql = "select id from users where `api_token` = ? and `api_email` = ?";
      $statement = $this->config["db"]->prepare($sql);
      $token = $this->user->getApiToken();
      $hash = $this->user->getApiHash();
      $statement->bind_param("ss", $token, $hash);
      $statement->execute();
      $result = $statement->get_result();
      $row = $result->fetch_assoc();
      if ($row["id"] != $id) {
         header("HTTP/1.1 403 Forbidden");
         return $this->errors["error_api_permission"];
         exit();
      }

      $this->checkLength($nickname, 5, 25, 'jméno');
      $this->checkLength($password, 8, 25, 'heslo');
      /* Hash hesla */
      if ((isset($_GET["password"]))) {
         $password = password_hash($password, PASSWORD_DEFAULT);
      }
      /* Sql příkazy */
      $sql_find_users = "select nickname, email from users where (nickname=? or email=?) and `id` != ?";
      $sql_create_new_user = "update users set `nickname` = ?, `password` = ?, `email` = ? where `id` = ?";

      /* Předpříprava hledání kvůli SQL Injection */
      $statement = $this->config["db"]->prepare($sql_find_users);
      $statement->bind_param("ssi", $nickname, $email, $id);
      $statement->execute();
      $result = $statement->get_result();

      if (mysqli_num_rows($result) > 0) {
         $row = $result->fetch_assoc();
         header("HTTP/1.1 400 Bad Request");
         return ($row["nickname"] == $nickname) ? "Toto jméno již existuje" : "Tento email již existuje";
      }
      if (password_verify($password, $this->user->getPassword())) {
         $password = $this->user->getPassword();
      }

      $statement = $this->config["db"]->prepare($sql_create_new_user);
      $statement->bind_param("sssi", $nickname, $password, $email, $id);
      $statement->execute();
      $this->config["db"]->commit();

      /* Úspěšný update, skok na hlavní stránku */
      header("HTTP/1.1 200 Ok");
      return "Účet byl upraven!";
   }
}
