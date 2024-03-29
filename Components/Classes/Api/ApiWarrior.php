<?php
require "Api.php";
/**
 * Odděděná třída API pro zpracování požadavků ohledně válečníka
 * 
 * @author Matyáš Lorenz
 * @extends Api
 */
class ApiWarrior extends Api
{
   /**
    * API metoda vytvářející válečníka
    *
    * @return err Informace o konečném stavu požadavku
    */
   public function create_warrior()
   {
      $id_world = $_GET["id_world"];
      if (!($this->security->check_permissions($id_world, $this->user))) {
         header("HTTP/1.1 403 Forbidden");
         return $this->errors["error_api_permission"];
         exit();
      }

      $name = strip_tags($_GET["name"]);
      try {
         $desc = strip_tags($_GET["desc"]);
      } catch (Exception $e) {
      }
      $attack = ($_GET["attack"]);
      $defense = ($_GET["defense"]);
      $agility = ($_GET["agility"]);
      $health = ($_GET["health"]);
      $con = $this->config["db"];
      $world = (new World($id_world))->get_instance();

      if (!(preg_match($this->errors["regex_new_warrior_name"], $name))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_new_warrior_name"];
         exit();
      }
      if (strlen($desc) > 500) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_new_warrior_desc"];
         exit();
      }
      if ($attack < 0 || $defense < 0 || $agility < 0) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_new_warrior_number"];
         exit();
      }
      $warrior_list = $world->getWarriors();
      foreach ($warrior_list as $existing_warrior) {
         if ($existing_warrior["name"] === $name) {
            header("HTTP/1.1 400 Bad Request");
            return $this->errors["error_mess_existing_warrior"];
            exit();
         }
      }
      if ($desc == "" or strlen($desc == 0)) {
         $sql_insert_warrior = 'insert into warrior(name, attack, defense, agility, hp, id_world) values(?, ?, ?, ?, ?, ?)';
         $statement = $con->prepare($sql_insert_warrior);
         $statement->bind_param("siiiii", $name, $attack, $defense, $agility, $health, $id_world);
         $statement->execute();
      } else {
         $sql_insert_warrior = 'insert into warrior(name, description, attack, defense, agility, hp, id_world) values(?, ?, ?, ?, ?, ?, ?)';
         $statement = $con->prepare($sql_insert_warrior);
         $statement->bind_param("ssiiiii", $name, $desc, $attack, $defense, $agility, $health, $id_world);
         $statement->execute();
      }
      header("HTTP/1.1 201 Created");
      return  "Úspěšně vloženo!";
   }
   /**
    * API metoda odstraňující válečníka
    *
    * @return err Informace o konečném stavu požadavku
    */
   public function remove_warrior()
   {

      $id_world = $_GET['id_world'];
      $id_warrior = $_GET['id_warrior'];

      if (!($this->security->check_permissions($id_world, $this->user))) {
         header("HTTP/1.1 403 Forbiddent");
         return $this->errors["error_api_permission"];
         exit();
      }

      /* Založení databáze */
      $con = $this->config['db'];
      /* Sql příkazy */
      $con->begin_transaction();
      $sql = "delete from `warrior` where `id` = ?";
      $statement = $con->prepare($sql);
      $statement->bind_param("i", $id_warrior);
      $statement->execute();
      $con->commit();
      exit();
      header("HTTP/1.1 200 Ok");
      return "Úspěšně smazáno";
   }
   /**
    * API metoda kontrolující, zdali je válečník v pořádku
    *
    * @return warriors_json JSON objekt válečníků
    */
   function check_warrior()
   {

      $name = strip_tags($_GET["name"]);
      $desc = strip_tags($_GET["desc"]);
      $attack = $_GET["attack"];
      $defense = $_GET["defense"];
      $agility = $_GET["agiilty"];
      $health = $_GET["health"];
      if (!(preg_match($this->errors["regex_new_warrior_name"], $name))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_new_warrior_name"];
         exit();
      }
      if (!(preg_match($this->errors["regex_new_warrior_desc"], $desc))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_new_warrior_desc"];
         exit();
      }

      if ($attack < 0 || $defense < 0 || $agility < 0 || $health <= 0) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_new_warrior_number"];
         exit();
      }
      header("HTTP/1.1 200 Ok");
      return "Vše v pořádku";
   }
   /**
    * API metoda na získání všech existující válečníků
    *
    * @return warriors_json JSON objekt válečníků
    */
   function get_all_warriors()
   {
      $id = $_GET["id"];
      $con = $this->config['db'];
      $sql = "select * from warrior where id_world=?";
      $statement = $con->prepare($sql);
      $statement->bind_param("i", $id);
      $warriors = new stdClass();
      $warriors->array = array();
      $statement->execute();
      $result = $statement->get_result();
      while ($row = $result->fetch_assoc()) {
         array_push($warriors->array, $row);
      }
      if(empty($warriors->array)) {
         header("HTTP/1.1 404 Not found");
         return;
      }
      $warriors_json = json_encode($warriors->array);
      header("HTTP/1.1 200 Ok");
      header('Content-Type: application/json');
      return $warriors_json;
   }
}
