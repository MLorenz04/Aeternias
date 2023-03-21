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
         $this->world_count = $this->getWorldCount();
         $this->username = $this->getUsername();
         $this->permissions = $this->getPermissions();
      }

      function getId()
      {
         return $this->id;
      }
      function setId($id)
      {
         $this->id = $id;
      }

      function getUsername()
      {
         global $config;
         $con = $config["db"];
         $result = $con->query("select nickname from users where id = " . $this->getId());
         $row = $result->fetch_row();
         $this->setUsername($row[0]);
         return $this->username;
      }

      function setUsername($username)
      {
         return $this->username = $username;
      }

      function setPermissions($permission)
      {
         return $this->permissions = $permission;
      }
      function getPermissions()
      {
         global $config;
         $perms = array();
         $con = $config["db"];
         $sql = "select id_world, type_of_permission from permissions where id_owner = " . $this->getId();
         $result = $con->query($sql);

         while ($row = $result->fetch_assoc()) {
            $obj = [$row['id_world'], $row['type_of_permission']];
            array_push($perms, $obj);
         }
         $this->setPermissions($perms);
         return $this->permissions;
      }

      function getWorldCount()
      {
         global $config;
         $con = $config["db"];
         $sql = "select count(id) from world where id_owner = " . $this->getId();
         $row = $con->query($sql)->fetch_row();
         $this->setWorldCount($row[0]);
         return $this->world_count;
      }

      function setWorldCount($world_count)
      {
         $this->world_count = $world_count;
      }
   }
}
