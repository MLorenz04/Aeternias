<?php
$id = $_GET["id"];
$config = require "../../config.php";
//Třída armády
class Army
{
   /* Proměnné třídy Army */
   public $id_user1 = 0;
   public $warriors_1 = array();
   private $world_id;

   /* Konstruktor */
   public function __construct($world_id)
   {
      $this->world_id = $world_id;
   }
   /* Začne celý process, zavolá metodu, která postupně volá další metody a nabaluje proces */
   public function start_process()
   {
      $this->fill_warriors();
   }
   /* Naplní třídu válečníky z formuláře */
   public function fill_warriors()
   {
      $this->warriors_1 = $_POST["warrior"];
      $this->show_warriors();
      //$this->check_army();
   }
   /* Výpis na obrazovku, používáno pouze pro vývoj */
   public function show_warriors()
   {
      echo "<pre>";
      print_r($this->warriors_1);
      echo "</pre>";
      echo "<br>";
      echo "<pre>";
      echo json_encode($this->warriors_1);
      echo "</pre>";
      $this->check_army();
   }
   /* Zkontroluje, jestli všechny údaje sedí a není počet lučištníků 0 */
   public function check_army()
   {
      foreach ($this->warriors_1 as $warrior) {
         if (is_null($warrior)) {
            continue; //Pokud je hodnota nezadaná, pokračuje dál a ignoruje zisk dat
         }

         if ($warrior["count"] < 0 || $warrior["count"] > 1000) {
            echo "Záporná hodnota";
            exit;
         }
         /* Dodělat kontrolu při zadání ničeho, momentálně vrací "Záporná hodnota" */
      }
      echo "Id světa:" . $this->world_id;
      $this->send_army_to_admin();
   }
   public function send_army_to_admin()
   {
      /* 
      $config = require "../../config.php";
      $url = $config["root"];
      $id = $this->world_id;
      if($file = fopen($url . "Components/Files/Administration/world_$id.txt" , 'a') or die) { //Pokud se podaří vytvořit soubor
         fwrite($file,"APRROVE_ARMY" .  "-*-" . $this->warriors_1);
      } else { //V opačném případě již existuje;
         $file = fopen($url ."Components/Files/Administration/world_$id.txt" , 'a');
         fwrite($file,"APRROVE_ARMY" .  "-*-" . $this->warriors_1);
      
      }*/
   }
}

$a1 = new Army($id);
$a1->start_process();
