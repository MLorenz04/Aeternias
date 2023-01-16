<?php
session_start();
$id = $_GET["id"];
require_once "../../config.php";
$config = (new Config())->get_instance();
require_once $config["root_path_require_once"] . "Components/Classes/User.php";
$id_user = (unserialize($_SESSION['logged_user']))->get_id();
$a1 = new Army($id, $config, $id_user);
$a1->fill_data();
//Třída armády
class Army
{
   /* Proměnné třídy Army */
   public $id_user1 = 0, $id_user2 = 0;
   public $warriors_1 = array();
   public $warriors_2 = array();
   private $world_id;
   private $con;
   private $battle = array();
   private $id_first_attacker, $id_second_attacker;
   /* Konstruktor */
   public function __construct($world_id, $config, $id_user)
   {
      $this->world_id = $world_id;
      $this->con = $config["db"];
      $this->id_first_attacker = $id_user;
   }
   /* Naplní třídu válečníky z formuláře */
   public function fill_data()
   {
      $username = $_POST["enemy"];
      $sql_select = "select id from users where nickname = '$username'";
      $result = $this->con->query($sql_select);
      while ($row = $result->fetch_assoc()) {
         $this->id_second_attacker = $row['id'];  //Nastavení id
      }
      $this->battle = array(
         "id_battle" => 1,
         "id_world" => $this->world_id,
         "id_first_attacker" => $this->id_first_attacker,
         "id_second_attacker" => $this->id_second_attacker,
         "army_1" => $_POST["warrior"],
         "army_2" => null
      );
      $this->show_warriors();
      //$this->check_army();
   }
   /* Výpis na obrazovku, používáno pouze pro vývoj */
   public function show_warriors()
   {
      echo "<pre>";
      print_r($this->battle);
      echo "</pre>";
      echo "<br>";
      $this->check_army();
   }
   /* Zkontroluje, jestli všechny údaje sedí a není počet lučištníků 0 */
   public function check_army()
   {
      foreach ($this->battle["army_1"] as $warrior) {
         if (is_null($warrior)) {
            continue; //Pokud je hodnota nezadaná, pokračuje dál a ignoruje zisk dat
         }

         if (intval($warrior["count"]) < 0 || intval($warrior["count"]) > 10000) {
            echo "Záporná hodnota";
            exit;
         }
         /* Dodělat kontrolu při zadání ničeho, momentálně vrací "Záporná hodnota" */
      }
      $this->send_army_to_admin();
   }
   public function send_army_to_admin()
   {
      /* 
      $config = require "../../config.php";
      $url = $this->config["root_path_url"];
      $id = $this->world_id;
      if($file = fopen($url . "Components/Files/Administration/world_$id.txt" , 'a') or die) { //Pokud se podaří vytvořit soubor
         fwrite($file,"APRROVE_ARMY" .  "-*-" . $this->warriors_1);
      } else { //V opačném případě již existuje;
         $file = fopen($url ."Components/Files/Administration/world_$id.txt" , 'a');
         fwrite($file,"APRROVE_ARMY" .  "-*-" . $this->warriors_1);
      }
         */
   }
}
