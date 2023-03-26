<?php
/* Zde není potřeba checkovat SQL Injection, protože to už kontroluje vždy skript se security v souboru, kde je World vytvářen */

/**
 * Třída pro konkrétní svět s informacemi
 * @author Matyáš Lorenz
 */
if (!class_exists("World")) {
   class World
   {
      public $list_of_warriors = array();
      public $list_of_permissions = array();
      public $id, $name, $desc, $id_owner, $warrior_count, $user_count, $date, $admin;

      /**
       * @param mixed $input_id Id světa, od kterého chceme info
       * @return
       */

      function  __construct($id)
      {
         $this->id = $id;
      }

      function get_instance()
      {
         require_once "Config.php";
         $config = (new Config())->get_instance();
         $id = $this->getId();
         $con = $config["db"];
         $sql_world_info = "select * from world where id = $id";
         $result_world = $con->query($sql_world_info);
         while ($row = $result_world->fetch_assoc()) {
            $this->setId($row["id"]); //Id světa
            $this->setName($row["name"]); //Jméno světa
            $this->setDesc($row["description"]); //Popisek
            $this->setIdOwner($row["id_owner"]); //Id vlastníka
            $this->setWarriorCount($row["warrior_count"]); //Počet válečníků
            $this->setUserCount($row["user_count"]); //Počet uživatelů
            $this->setUserDate($row["date"]); //Datum vzniku
            $this->setIdOwner($row["id_owner"]); //Id administrátora
         }
         $sql_warriors_info = "select * from warrior where id_world = $id";
         $result_warriors = $con->query($sql_warriors_info);
         $warrior_list = array();
         while ($row = $result_warriors->fetch_assoc()) {
            array_push($warrior_list, $row); //Naplní pole válečníkami, kteří existují
         }
         $this->setWarriors($warrior_list);
         return $this;
      }

      function getId()
      {
         return $this->id;
      }

      function setId($id)
      {
         return $this->id = $id;
      }

      function getName()
      {
         return $this->name;
      }

      function setName($name)
      {
         return $this->name = $name;
      }

      function getDesc()
      {
         return $this->desc;
      }

      function setDesc($desc)
      {
         return $this->desc = $desc;
      }
      function getIdOwner()
      {
         return $this->id_owner;
      }

      function setIdOwner($id_owner)
      {
         return $this->id_owner = $id_owner;
      }

      function getUserCount()
      {
         return $this->user_count;
      }

      function setUserCount($count)
      {
         return $this->user_count = $count;
      }
      function getUserDate()
      {
         return $this->date;
      }

      function setUserDate($date)
      {
         return $this->date = $date;
      }

      function getAdmin()
      {
         return $this->admin;
      }

      function setAdmin($admin)
      {
         return $this->admin = $admin;
      }

      function getWarriors()
      {
         return $this->list_of_warriors;
      }

      function setWarriors($list)
      {
         return $this->list_of_warriors = $list;
      }

      function getPermissions()
      {
         return end($this->list_of_permissions);
      }

      function setPermissions($perm)
      {
         return $this->list_of_permissions = $perm;
      }

      function getWarriorCount()
      {
         return $this->warrior_count;
      }

      function setWarriorCount($count)
      {
         return $this->warrior_count = $count;
      }
   }
}
