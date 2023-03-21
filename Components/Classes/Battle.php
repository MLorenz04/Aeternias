<?php
require_once "Army.php";
require_once "Config.php";
class Battle
{
   private $list_of_actions = [
      ["id" => 1, "mess" => "Morálka armády poklesla."],
      ["id" => 2, "mess" => "Nastala bouře, armádu zasáhly velké problémy"],
      ["id" => 3, "mess" => "Morálka armády poklesla."]
   ];

   private $first_army, $second_army, $path, $config, $file, $id_world, $id, $log, $result, $chance_on_win, $chance_on_dodge_first, $chance_on_dodge_second;

   public function __construct($first_army,  $second_army, $slug, $id_world, $id)
   {
      $this->setFirstArmy($first_army);
      $this->setSecondArmy($second_army);
      $this->setFiles($slug);
      $this->setIdWorld($id_world);
      $this->setId($id);
      $this->config = (new Config())->get_instance();
   }

   public function start_battle()
   {
      $end = false;
      $json = new stdClass();
      $divider = "-=-=-=-=-=-=-=-=-=-=-=-=-";
      $round = 0;
      $a1 = $this->getFirstArmy();
      $a2 = $this->getSecondArmy();
      if ($a1->getTotalDefense() == $a2->getTotalDefense()) {
         $a1->setTotalDefense(0.1);
         $a2->setTotalDefense(0.1);
      }
      if ($a1->getTotalDefense() < $a2->getTotalDefense()) {
         $defense_second_army = $a1->getTotalDefense() / $a2->getTotalDefense();
         $a1->setTotalDefense(0.1);
         $a2->setTotalDefense(1 - $defense_second_army);
      }
      if ($a1->getTotalDefense() > $a2->getTotalDefense()) {
         $defense_first_army = $a2->getTotalDefense() / $a1->getTotalDefense();
         $a1->setTotalDefense(1 - $defense_first_army);
         $a2->setTotalDefense(0.1);
      }
      $chance_on_win = (($a1->getTotalHealth()) / (($a1->getTotalHealth() + $a2->getTotalHealth()) / 100));
      $this->chance_on_win = number_format((float)$chance_on_win, 1, '.', '');
      ($a1->getTotalagility() > 0) ? $this->setChangeOnDodgeFirst(((($a1->getTotalAgility()) / (($a1->getTotalAgility() + $a2->getTotalAgility()) / 100)))) : $this->setChangeOnDodgeFirst(0);
      ($a2->getTotalagility() > 0) ? $this->setChangeOnDodgeSecond(((($a2->getTotalAgility()) / (($a2->getTotalAgility() + $a1->getTotalAgility()) / 100)))) : $this->setChangeOnDodgeSecond(0);
      $this->start_log();

      while (true) {
         sleep(1);
         $first_val = $second_val = "";
         $attack_first = (($a1->getTotalAttack() * (rand(35, 115) / 100)) * (1 - $a2->getTotalDefense()) * 0.2);
         $attack_second = (($a2->getTotalAttack() * (rand(35, 115) / 100)) * (1 - $a1->getTotalDefense()) * 0.2);
         if ($attack_first <= 0) $attack_first = 1;
         if ($attack_second <= 0) $attack_second = 1;

         fwrite($this->getLog(), "Obrana první armády: " . $a1->getTotalDefense() . PHP_EOL);
         fwrite($this->getLog(), "Zdraví druhé armády: " . $a2->getTotalDefense() . PHP_EOL);
         fwrite($this->getLog(), $divider . "  $round. kolo  " . $divider . PHP_EOL);
         fwrite($this->getLog(), "Zdraví první armády: " . $a1->getTotalHealth() . PHP_EOL);
         fwrite($this->getLog(), "Zdraví druhé armády: " . $a2->getTotalHealth() . PHP_EOL);
         $are_we_dodging = (bool)rand(0, 1);
         if ($are_we_dodging) {
            if ($this->getChangeOnDodgeFirst() > $this->getChangeOnDodgeSecond()) {
               $first_val = range(0, $this->getChangeOnDodgeFirst());
               $second_val = range($this->getChangeOnDodgeSecond(), 100);
            } else {
               $first_val = range(0, $this->getChangeOnDodgeSecond());
               $second_val = range($this->getChangeOnDodgeFirst(), 100);
            }

            if (in_array(random_int(0, 100), $first_val)) {
               fwrite($this->getLog(), "První armáda uhnula!" . PHP_EOL);
               $attack_second = $attack_second * (rand(15, 45) / 100);
            }
            if (in_array(random_int(0, 100), $second_val)) {
               fwrite($this->getLog(), "Druhá armáda uhnula!" . PHP_EOL);
               $attack_first = $attack_first * (rand(15, 45) / 100);
            }
         }
         $this->get_random_action(random_int(0, count($this->getListOfActions())));
         $a1->setTotalHealth($a1->getTotalHealth() - $attack_second);

         if ($a1->getTotalHealth() <= 0) {
            $a1->setTotalHealth(0);
            $end = true;
         }

         if ($end != true) {
            $a2->setTotalHealth($a2->getTotalHealth() - $attack_first);
            if ($a2->getTotalHealth() <= 0) {
               $a2->setTotalHealth(0);
               $end = true;
            }
         }

         $json->first_army_hp = $a1->getTotalHealth();
         $json->second_army_hp = $a2->getTotalHealth();
         $json->messages = [];
         file_put_contents($this->getPath(), json_encode($json));
         $round++;
         if ($end) {
            $result = floor($a1->getTotalHealth()) . ":" . floor($a2->getTotalHealth());
            $this->setResult($result);
            $this->make_record();
            fclose($this->getLog());
            return;
         }
      }
   }

   public function start_log()
   {
      fwrite($this->getLog(), "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-  Začátek souboje  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-" . PHP_EOL);
      fwrite($this->getLog(), "Zdraví první armády na začátku: " . $this->getFirstArmy()->getTotalHealth() . PHP_EOL);
      fwrite($this->getLog(), "Síla první armády na začátku: " . $this->getFirstArmy()->getTotalAttack() . PHP_EOL);
      fwrite($this->getLog(), "Obrana první armády na začátku: " . $this->getFirstArmy()->getTotalDefense() . PHP_EOL);
      fwrite($this->getLog(), "Obratnost první armády na začátku: " . $this->getFirstArmy()->getTotalAgility() . PHP_EOL);
      fwrite($this->getLog(), "Šance na vyhnutí první armády: " . $this->getChangeOnDodgeFirst()  . PHP_EOL);
      fwrite($this->getLog(), "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-" . PHP_EOL);
      fwrite($this->getLog(), "Zdraví druhé armády na začátku: " . $this->getSecondArmy()->getTotalHealth() . PHP_EOL);
      fwrite($this->getLog(), "Síla druhé armády na začátku: " . $this->getSecondArmy()->getTotalAttack() . PHP_EOL);
      fwrite($this->getLog(), "Obrana druhé armády na začátku: " . $this->getSecondArmy()->getTotalDefense() . PHP_EOL);
      fwrite($this->getLog(), "Obratnost první armády na začátku: " . $this->getSecondArmy()->getTotalAgility() . PHP_EOL);
      fwrite($this->getLog(), "Šance na vyhnutí druhé armády: " . $this->getChangeOnDodgeSecond() . PHP_EOL);
      fwrite($this->getLog(),  "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-  Konec souboje  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-" . PHP_EOL);
   }

   public function get_random_action($pick)
   {
      $action = $this->getListOfActions();
   }

   public function make_record()
   {
      $id_world = $this->getIdWorld();
      $id = $this->getId();
      $result = $this->getResult();
      $chance_on_win = $this->chance_on_win;
      $date = date("Y.m.d");
      $sql_insert_warrior = 'insert into battle(id_world, id_challenger, result, date, chance) values(?, ?, ?, ?, ?)';
      $statement = $this->config["db"]->prepare($sql_insert_warrior);
      $statement->bind_param("iissd", $id_world, $id, $result, $date, $chance_on_win);
      $statement->execute();
   }

   public function getFirstArmy()
   {
      return $this->first_army;
   }

   public function setFirstArmy($first_army)
   {
      return $this->first_army = $first_army;
   }

   public function getId()
   {
      return $this->id;
   }

   public function setId($id)
   {
      return $this->id = $id;
   }

   public function getResult()
   {
      return $this->result;
   }

   public function setResult($result)
   {
      return $this->result = $result;
   }

   public function getIdWorld()
   {
      return $this->id_world;
   }

   public function setIdWorld($id_world)
   {
      return $this->id_world = $id_world;
   }

   public function getSecondArmy()
   {
      return $this->second_army;
   }

   public function setSecondArmy($second_army)
   {
      return $this->second_army = $second_army;
   }
   public function getPath()
   {
      return $this->path;
   }

   public function setFiles($str)
   {
      $this->file = fopen("../../../../Files/battle$str.json", "w");
      $this->log = fopen("../../../../Files/battle$str.log", "a");
      return $this->path = "../../../../Files/battle$str.json";
   }

   public function getLog()
   {
      return $this->log;
   }

   public function getFile()
   {
      return $this->file;
   }

   public function getListOfActions()
   {
      return $this->list_of_actions;
   }

   public function log_single_round()
   {
   }
   public function getChangeOnDodgeFirst()
   {
      return $this->chance_on_dodge_first;
   }

   public function setChangeOnDodgeFirst($chance)
   {
      return $this->chance_on_dodge_first = $chance;
   }
   public function getChangeOnDodgeSecond()
   {
      return $this->chance_on_dodge_second;
   }

   public function setChangeOnDodgeSecond($chance)
   {
      return $this->chance_on_dodge_second = $chance;
   }
}
