<?php
require "Config.php";
/**
 * Třída na tvoření uživatelů
 * 
 * @author Matyáš Lorenz
 */
if (!class_exists("User")) {
   /**
    * Třída pro uživatele a tvorbu jeho objektu
    */
   class User
   {
      private $id;
      private $username, $email = "";
      private $world_count, $worlds, $api_token, $api_email, $password;
      private $config, $con;
      private array $permissions = array();

      /**
       * Konstruktor
       * @param mixed $id Id světa
       */
      function __construct($id)
      {
         $this->setId($id);
         $this->config = Config::getInstance();
         $this->con = $this->config["db"];
         $result = $this->con->query("select nickname, email, api_token, api_email, password from users where id = " . $this->getId());
         $row = $result->fetch_row();
         $this->setUsername($row[0]);
         $this->setEmail($row[1]);
         $this->setApiToken($row[2]);
         $this->setApiHash($row[3]);
         $this->setPassword($row[4]);
         $this->setWorldCountFromDb();
         $this->setPermissionsFromDb();
      }

      /**
       * Metoda vracející id
       * @return int Id
       */
      function getId()
      {
         return $this->id;
      }
      /**
       * Metoda nastavující 
       * @param int Id
       */
      function setId($id)
      {
         $this->id = $id;
      }
      /**
       * Metoda vracející uživatelské jméno
       * @return int Uživatelské jméno
       */
      function getUsername()
      {
         return $this->username;
      }
      /**
       * Metoda nastavující jméno
       * @param string jméno
       */
      function setUsername($username)
      {
         return $this->username = $username;
      }
      /**
       * Metoda vracející pravomoce 
       * @return array Pravomoce 
       */
      function getPermissions()
      {
         return $this->permissions;
      }
      /**
       * Metoda nastavující pravomoce
       * @param array pravomoce
       */
      function setPermissions($permission)
      {
         return $this->permissions = $permission;
      }
      /**
       * Metoda vracející email 
       * @return string email 
       */
      function getEmail()
      {
         return $this->email;
      }
      /**
       * Metoda nastavující email
       * @param string email
       */
      function setEmail($email)
      {
         $this->email = $email;
      }
      /**
       * Metoda vracející heslo 
       * @return string heslo 
       */
      function getPassword()
      {
         return $this->password;
      }
      /**
       * Metoda nastavující heslo
       * @param string heslo
       */
      function setPassword($password)
      {
         $this->password = $password;
      }
      /** 
       * Metoda vracející světy
       * 
       * @return array Světy
       */
      function getWorlds()
      {

         $this->worlds = array();
         $id = $this->getId();
         $sql = "select * from world where id_owner = ?";
         $statement = $this->con->prepare($sql);
         $statement->bind_param("i", $id);
         $result = $statement->execute();
         $result = $statement->get_result();
         while($row = $result->fetch_array(MYSQLI_NUM)) {
         array_push($this->worlds, $row);
         }
         return $this->worlds;
      }
      /**
       * Metoda nastavující proměnné z databáze
       */
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

      /**
       * Metoda vracející počet světů
       * @return int Počet světů
       */
      function getWorldCount()
      {
         return $this->world_count;
      }

      /**
       * Nastavuje počet světů
       * @param int $world_count Počet světů
       */
      function setWorldCount($world_count)
      {
         $this->world_count = $world_count;
      }
      /**
       * Nastavuje počet světů z databáze
       * @return int Počet světů
       */
      function setWorldCountFromDb()
      {
         $con = $this->config["db"];
         $sql = "select count(id) from world where id_owner = " . $this->getId();
         $row = $con->query($sql)->fetch_row();
         $this->setWorldCount($row[0]);
         return $this->world_count;
      }
      /**
       * Nastavuje Api token uživatele
       * @param int $token Api token
       */
      function setApiToken($token)
      {
         $this->api_token = $token;
      }
      /**
       * Vrací Api token uživatele
       * @return string Api token
       */
      function getApiToken()
      {
         return $this->api_token;
      }
      /**
       * Nastavuje Api hash uživatele
       * @param int $token Api token
       */
      function setApiHash($token)
      {
         $this->api_email = $token;
      }
      /**
       * Vrací Api hash uživatele
       * @return string Api hash
       */
      function getApiHash()
      {
         return $this->api_email;
      }
   }
}
