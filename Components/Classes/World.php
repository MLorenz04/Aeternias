<?php
/* Zde není potřeba checkovat SQL Injection, protože to už kontroluje vždy skript se security v souboru, kde je World vytvářen */
/**
 * Třída pro konkrétní svět s informacemi
 * @author Matyáš Lorenz
 */
class World
{
   public $list_of_warriors = array();
   public $list_of_permissions = array();
   public $id, $name, $desc, $id_owner, $warrior_count, $user_count, $date, $admin;
   /**
    * @param mixed $input_id Id světa, od kterého chceme info
    * @return
    */

   function  __construct($id) {
      $this->id = $id;
      $this->get_world($id);
   }
   function get_world($input_id)
   {
      $config = require "../../../config.php";
      $con = $config["db"];
      $sql_world_info = "select * from world where id = $input_id";
      $result_world = $con->query($sql_world_info);
      while ($row = $result_world->fetch_assoc()) {
         $this->id = $row["id"]; //Id světa
         $this->name = $row["name"]; //Jméno světa
         $this->desc = $row["description"]; //Popisek
         $this->id_owner = $row["id_owner"]; //Id vlastníka
         $this->warrior_count = $row["warrior_count"]; //Počet válečníků
         $this->user_count = $row["user_count"]; //Počet uživatelů
         $this->date = $row["date"]; //Datum vzniku
         $this->admin = $row["id_owner"]; //Id administrátora
      }
      $sql_warriors_info = "select * from warrior where id_world = $input_id";
      $result_warriors = $con->query($sql_warriors_info);
      while ($row = $result_warriors->fetch_assoc()) {
         array_push($this->list_of_warriors, $row); //Naplní pole válečníkami, kteří existují
      }
   }
}
