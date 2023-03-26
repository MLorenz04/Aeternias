<?php
require "Api.php";
class ApiWorld extends Api
{
   function create_world()
   {
      if (!($this->security->check_existing_user($this->user))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_api_permission"];
         exit();
      }

      $owner_id = $this->user->getId();
      $world_name = $_GET['name'];
      $world_desc = $_GET['desc'];
      $world_count = $this->user->getWorldCount();
      if (!(preg_match($this->errors["regex_new_world_name"], $world_name))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_world_name"];
         exit();
      }

      if ($world_count >= 10) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_max_world_count"];
         exit();
      }
      /* Databáze a kolekce */
      $date = date("Y.m.d");
      $con = $this->config['db'];
      /* SQL příkazy */
      $sql_check_name = "select `name` from world where `name` = ?";
      $sql_insert_your_world = "insert into world(id_owner,name,description,date,user_count,warrior_count,battle_count) values(?, ?, ?, ?, 1, 0, 0)";
      $sql_create_permission = "insert into permissions(id_owner, id_world,type_of_permission) values(?,?,'Administrátor')";
      /* Předpřipravení příkazi kvůli SQL injection */
      $con->begin_transaction();
      $statement = $con->prepare($sql_check_name);
      $statement->bind_param("s", $world_name);
      $statement->execute();
      $result = $statement->get_result();
      /* Zjištění, jestli název světa už neexistuje, případně vytvoření světa */
      if (mysqli_num_rows($result) != 0) return $this->errors["error_mess_existing_name"];
      /* Předpřipravení příkazi kvůli SQL injection */
      $statement = $con->prepare($sql_insert_your_world);
      $statement->bind_param("isss", $owner_id, $world_name, $world_desc, $date);
      $statement->execute();
      //Tady bude potřeba ještě kontrola
      $world_id = $con->insert_id;
      $statement2 = $con->prepare($sql_create_permission);
      $statement2->bind_param("ii", $owner_id, $world_id,);
      $statement2->execute();
      $this->user->setWorldCount($this->user->getWorldCount() + 1);
      /* Pokud je uživatel přihlášení a na stránce, updatne se jeho session. */
      if (isset($_SESSION["logged_user"])) {
         $_SESSION["logged_user"] = serialize($this->user);
      }
      $con->commit();
      header("HTTP/1.1 200 Ok");
      return "Úspěšně vloženo!";
      exit();
   }
   function get_all_worlds()
   {
      $sql = "select * from world";
      $worlds = new stdClass();
      $worlds->array = array();
      $result = $this->config["db"]->query($sql);
      while ($row = $result->fetch_assoc()) {
         array_push($worlds->array, $row);
      }
      $worlds_json = json_encode($worlds->array);
      header("HTTP/1.1 200 Ok");
      return $worlds_json;
   }

   function update_world()
   {
      $world_name = $_GET['name'];
      $world_desc = $_GET['desc'];
      $world_id = $_GET['id_world'];
      /* Kontrola pravomocí */

      if (!($this->security->check_existing_user($this->user))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_api_permission"];
         exit();
      }

      if (!($this->security->check_permissions($world_id, $this->user))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_api_permission"];
         exit();
      }

      /* Databáze a kolekce */
      $con = $this->config['db'];

      /* Security */

      if (!(preg_match($this->errors["regex_new_world_name"], $world_name))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_world_name"];
         exit();
      }

      if (!(preg_match($this->errors["regex_new_world_desc"], $world_desc))) {
         header("HTTP/1.1 400 Bad Request");
         return $this->errors["error_mess_world_desc"];
         exit();
      }

      /* SQL příkazy */
      $sql_check_existing_name = "select 1 from `world` where (`name` = ? or `description` = ? ) and `id` != ?";
      $sql_update_name = "update world set `name` = ?, `description` = ? where `id` = ?";
      $con->begin_transaction();

      $statement = $con->prepare($sql_check_existing_name);
      $statement->bind_param("ssi", $world_name, $world_desc, $world_id);
      $statement->execute();
      $result = $statement->get_result();
      $row = $result->fetch_array(MYSQLI_NUM);
      if($row != null) {
         header("HTTP/1.1 400 Bad Request");
         return "Tento název světa již existuje";
      }
      $statement = $con->prepare($sql_update_name);
      $statement->bind_param("ssi", $world_name, $world_desc, $world_id);
      $statement->execute();
      $con->commit();
      header("HTTP/1.1 200 Ok");
      return "Úspěšně updatováno!";
      exit();
   }
}
