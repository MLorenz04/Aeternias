<?php
if (!class_exists("User")) {
   class User
   {
      private $id;
      private $username = "wtf";
      private $world_count;
      private array $permissions = array();

      function __construct($id)
      {
         $this->id = $id;
         $this->world_count = $this->get_world_count();
         $this->username = $this->get_username();
         $this->permissions = $this->get_permissions();
      }

      function get_id()
      {
         return $this->id;
      }
      function set_id($id)
      {
         $this->id = $id;
      }

      function get_username()
      {
         global $config;
         $con = $config["db"];
         $result = $con->query("select nickname from users where id = " . $this->get_id());
         $row = $result->fetch_row();
         $this->set_username($row[0]);
         return $this->username;
      }

      function set_username($username)
      {
         return $this->username = $username;
      }

      function set_permissions($permission)
      {
         return $this->permissions = $permission;
      }
      function get_permissions()
      {
         global $config;
         $perms = array();
         $con = $config["db"];
         $sql = "select id_world, type_of_permission from permissions where id_owner = " . $this->get_id();
         $result = $con->query($sql);

         while ($row = $result->fetch_assoc()) {
            $obj = [$row['id_world'], $row['type_of_permission']];
            array_push($perms, $obj);
         }
         $this->set_permissions($perms);
         return $this->permissions;
      }

      function get_world_count()
      {
         global $config;
         $con = $config["db"];
         $sql = "select count(id) from world where id_owner = " . $this->get_id();
         $row = $con->query($sql)->fetch_row();
         $this->set_world_count($row[0]);
         return $this->world_count;
      }

      function set_world_count($world_count)
      {
         $this->world_count = $world_count;
      }
   }
}
