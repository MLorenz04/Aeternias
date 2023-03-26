<?php
require "Config.php";
if (!class_exists("User")) {
   class User
   {
      private $id;
      private $username = "wtf";
      private $world_count;
      private $api_token, $api_email;
      private $config;
      private array $permissions = array();

      function __construct($id)
      {
         $this->id = $id;
         $this->config = (new Config())->get_instance();
         $con = $this->config["db"];
         $result = $con->query("select nickname, api_token, api_email from users where id = " . $this->getId());
         $row = $result->fetch_row();
         $this->setUsername($row[0]);
         $this->setApiToken($row[1]);
         $this->setApiHash($row[2]);
         $this->setWorldCountFromDb();
         $this->setPermissionsFromDb();
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
         return $this->username;
      }

      function setUsername($username)
      {
         return $this->username = $username;
      }

      function getPermissions()
      {
         return $this->permissions;
      }

      function setPermissions($permission)
      {
         return $this->permissions = $permission;
      }


      function setPermissionsFromDb()
      {
         $perms = array();
         $con = $this->config["db"];
         $sql = "select id_world, type_of_permission from permissions where id_owner = " . $this->getId();
         $result = $con->query($sql);

         while ($row = $result->fetch_assoc()) {
            $obj = [$row['id_world'], $row['type_of_permission']];
            array_push($perms, $obj);
         }
         $this->permissions = $perms;
         return $perms;
      }


      function getWorldCount()
      {
         return $this->world_count;
      }

      function setWorldCount($world_count)
      {
         $this->world_count = $world_count;
      }

      function setWorldCountFromDb()
      {
         $con = $this->config["db"];
         $sql = "select count(id) from world where id_owner = " . $this->getId();
         $row = $con->query($sql)->fetch_row();
         $this->setWorldCount($row[0]);
         return $this->world_count;
      }

      function setApiToken($token)
      {
         return $this->api_token = $token;
      }

      function getApiToken()
      {
         return $this->api_token;
      }
      function setApiHash($token)
      {
         return $this->api_email = $token;
      }

      function getApiHash()
      {
         return $this->api_email;
      }
   }
}
