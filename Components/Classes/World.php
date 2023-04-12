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
       * Konstruktor
       *
       * @param int $id
       * @return void
       */
      function  __construct($id)
      {
         $this->id = $id;
      }
      /**
       * Získá instanci světa
       */
      function get_instance()
      {
         require_once "Config.php";
         $config = Config::getInstance();
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
      /**
       * Metoda vracející id světa
       * @return int Id světa
       */
      function getId()
      {
         return $this->id;
      }
      /**
       * Metoda nastavující id
       * @param int Id
       */
      function setId($id)
      {
         return $this->id = $id;
      }
      /**
       * Metoda vracející název světa
       * @return string Název světa
       */
      function getName()
      {
         return $this->name;
      }
      /**
       * Metoda vracející jméno světa
       * @param string Jméno světa
       */
      function setName($name)
      {
         $this->name = $name;
      }
      /**
       * Metoda vracející popisek světa
       * @return string Popisek světa
       */
      function getDesc()
      {
         return $this->desc;
      }
      /**
       * Metoda nastavující popis
       * @param string Popis
       */
      function setDesc($desc)
      {
         $this->desc = $desc;
      }
      /**
       * Metoda vracející id vlastníka
       * @return int Id vlastníka
       */
      function getIdOwner()
      {
         return $this->id_owner;
      }
      /**
       * Metoda nastavující id vlastníka
       * @param int Id vlastníka
       */
      function setIdOwner($id_owner)
      {
         $this->id_owner = $id_owner;
      }
      /**
       * Metoda vracející počet uživatelů
       * @return int Počet uživatelů
       */
      function getUserCount()
      {
         return $this->user_count;
      }
      /**
       * Metoda nastavující den registrace
       * @param string Den registrace
       */
      function setUserCount($count)
      {
         $this->user_count = $count;
      }
      /**
       * Metoda vracející datum registrace
       * @return int  datum registrace
       */
      function getUserDate()
      {
         return $this->date;
      }
      /**
       * Metoda nastavující den registrace
       * @param string Den registrace
       */
      function setUserDate($date)
      {
         $this->date = $date;
      }
      /**
       * Metoda vracející vlasntíka světa
       * @return mixed vlasntíka světa
       */
      function getAdmin()
      {
         return $this->admin;
      }
      /**
       * Metoda nastavující admina
       * @param mixed Admin
       */
      function setAdmin($admin)
      {
         $this->admin = $admin;
      }
      /**
       * Metoda vracející pole válečníků světa
       * @return array Pole válečníků světa
       */
      function getWarriors()
      {
         return $this->list_of_warriors;
      }
      /**
       * Metoda nastavující pole válečníků světa
       * @param int pole válečníků světa
       */
      function setWarriors($list)
      {
         $this->list_of_warriors = $list;
      }
      /**
       * Metoda vracející pole pravomocí světa
       * @return array Pole pravomocí světa
       */
      function getPermissions()
      {
         return end($this->list_of_permissions);
      }
      /**
       * Metoda nastavující počet pravomocí světa
       * @param array počet pravomocí světa
       */
      function setPermissions($perm)
      {
         $this->list_of_permissions = $perm;
      }
      /**
       * Metoda vracející počet válečníků světa
       * @return array Počet válečníků světa
       */
      function getWarriorCount()
      {
         return $this->warrior_count;
      }
      /**
       * Metoda nastavující počet válečníků světa
       * @param array počet válečníků světa
       */
      function setWarriorCount($count)
      {
         $this->warrior_count = $count;
      }
   }
}
