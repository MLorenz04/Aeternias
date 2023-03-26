<?php
require "Api.php";
class ApiPermissions extends Api
{

   function create_permission()
   {
      $username = strip_tags($_GET['username']);
      $id_world = strip_tags($_GET['id_world']);
      $con = $this->config["db"];
      $id_owner = 0;
      $con->begin_transaction();
      $sql = "select `id` from users where `nickname` = ?";
      $statement = $con->prepare($sql);
      $statement->bind_param("s", $username);
      $statement->execute();
      $result = $statement->get_result();
      while ($row = $result->fetch_array(MYSQLI_NUM)) {
         foreach ($row as $r) {
            $id_owner = $r;
         }
      }

      if ($id_owner == 0) {
         header("HTTP/1.1 400 Bad Request");
         return "Tento uživatel neexistuje!";
      }

      $sql_select_all = "select * from `permissions` where `id_owner` = ? and `id_world` = ?";
      $statement = $con->prepare($sql_select_all);
      $statement->bind_param("ii", $id_owner, $id_world);
      $statement->execute();
      $result = $statement->get_result();
      $row = $result->fetch_array(MYSQLI_NUM);
      while ($row = $result->fetch_assoc()) {
         if ($row['id_owner'] == $id_owner) {
            header("HTTP/1.1 400 Bad Request");
            return "Tento uživatel je již přidaný";
         }
      }

      $sql_insert_permission = "insert into `permissions`(`type_of_permission`,`id_owner`,`id_world`) values('Hráč', ? , ? );";
      $statement = $con->prepare($sql_insert_permission);
      $statement->bind_param("ii", $id_owner, $id_world);
      $statement->execute();
      $con->commit();
      header("HTTP/1.1 200 Ok");
      return "Pravomoce uživateli " . $username . " byly přidány";
   }
   function remove_permission()
   {
      $id_owner = strip_tags($_GET['username']);
      $id_world = strip_tags($_GET['id_world']);
      $world = (new World($id_world))->get_instance();
      if (!($this->user->getId() == $world->id_owner)) {
         header("HTTP/1.1 400 Bad Request");
         return "Na toto nemáte pravomoce!";
         exit();
      }
      if ($id_owner == $world->id_owner) {
         header("HTTP/1.1 400 Bad Request");
         return "Nemůžete odebrat vlastníka světa!";
         exit();
      }
      $sql_select_all = "delete from permissions where id_owner = $id_owner and id_world = $id_world";
      if ($this->config["db"]->query($sql_select_all)) {
         header("HTTP/1.1 200 Ok");
         return "Pravomoce úspěšně odebrány!";
         exit();
      } else {
         header("HTTP/1.1 400 Bad Request");
         return "Tento uživatel nemá pravomoce ve vašem světě";
         exit();
      }
   }
   function get_permission()
   {
      $id_permission = strip_tags($_GET["user_id"]);
      $id_world = strip_tags($_GET["id_world"]);

      $sql = "select exists(select * from permissions where `id_owner` = ? and `id_world` = ?)";
      $statement = $this->config["db"]->prepare($sql);
      $statement->bind_param("ii", $id_permission, $id_world);
      $statement->execute();
      $result = $statement->get_result();
      $row = $result->fetch_array(MYSQLI_NUM);
      header("HTTP/1.1 200 Ok");
      return ($row[0]) ? True : False;
   }
}
