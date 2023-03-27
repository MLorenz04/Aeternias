<?php
require_once "Army.php";
require_once "Config.php";
/**
 * Třída pro bitvy
 * @author Matyáš Lorenz
 */
class Battle
{

   private $first_army, $second_army, $path, $config, $file, $id_world, $id, $log, $result, $chance_on_win, $chance_on_dodge_first, $chance_on_dodge_second;
   /**
    * Konstruktor pro tvorbu bitvy
    * @param mixed $first_army První armáda
    * @param mixed $second_army Druhá armáda
    * @param mixed $slug Slug pro soubor, který bude vygenerován
    * @param mixed $id_world Id světa
    * @param mixed $id Nastavení id světa
    */
   public function __construct($first_army,  $second_army, $slug, $id_world, $id)
   {
      $this->setFirstArmy($first_army);
      $this->setSecondArmy($second_army);
      $this->setFiles($slug);
      $this->setIdWorld($id_world);
      $this->setId($id);
      $this->config = (new Config())->get_instance();
   }
   /**
    * Metoda začínající celou bitvu
    */
   public function start_battle()
   {
      $end = false;
      $json = new stdClass();
      $divider = "-=-=-=-=-=-=-=-=-=-=-=-=-";
      $round = 0;
      $a1 = $this->getFirstArmy();
      $a2 = $this->getSecondArmy();
      /* Nastavení obrany armád na základě rozdílu */
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
      /* Nastavení šance na výhru */
      $chance_on_win = (($a1->getTotalHealth()) / (($a1->getTotalHealth() + $a2->getTotalHealth()) / 100));
      $this->chance_on_win = number_format((float)$chance_on_win, 1, '.', '');
      /* Nastavení šance na vyhnutí */
      ($a1->getTotalagility() > 0) ? $this->setChangeOnDodgeFirst(((($a1->getTotalAgility()) / (($a1->getTotalAgility() + $a2->getTotalAgility()) / 100)))) : $this->setChangeOnDodgeFirst(0);
      ($a2->getTotalagility() > 0) ? $this->setChangeOnDodgeSecond(((($a2->getTotalAgility()) / (($a2->getTotalAgility() + $a1->getTotalAgility()) / 100)))) : $this->setChangeOnDodgeSecond(0);
      $this->start_log();
      /* Cyklus předstírající nekonečnou bitvu, dokud někdo nepadne  */
      while (true) {
         sleep(1); //Aby bitva netrvala 0,001s
         $first_val = $second_val = "";
         /* Náhodná hodnota poškození na základě útoku a obrany */
         $attack_first = (($a1->getTotalAttack() * (rand(35, 185) / 100)) * (1 - $a2->getTotalDefense()) * 0.2);
         $attack_second = (($a2->getTotalAttack() * (rand(35, 185) / 100)) * (1 - $a1->getTotalDefense()) * 0.2);
         /*  Pokud někdo nemá útok, symbolický 1 útok */
         if ($attack_first <= 0) $attack_first = 1;
         if ($attack_second <= 0) $attack_second = 1;
         /* Počítání uhýbání */
         $are_we_dodging = (bool)rand(0, 1);
         if ($are_we_dodging) {
            /* Jedna z armád se vyhnula útoku */
            if ($this->getChangeOnDodgeFirst() > $this->getChangeOnDodgeSecond()) {
               $first_val = range(0, $this->getChangeOnDodgeFirst());
               $second_val = range($this->getChangeOnDodgeSecond(), 100);
            } else {
               $first_val = range(0, $this->getChangeOnDodgeSecond());
               $second_val = range($this->getChangeOnDodgeFirst(), 100);
            }
            $rand = random_int(0, 100);
            if (in_array($rand, $first_val)) {
               fwrite($this->getLog(), "První armáda uhnula!" . PHP_EOL);
               $attack_second = $attack_second * (rand(15, 25) / 100);
            }
            if (in_array($rand, $second_val)) {
               fwrite($this->getLog(), "Druhá armáda uhnula!" . PHP_EOL);
               $attack_first = $attack_first * (rand(15, 25) / 100);
            }
         }
         /* Zde bude také generování událostí, bohužel není kvůli čas možnost jej pořádně vyřešit */
         //$this->get_random_action(random_int(0, count($this->getListOfActions())));
         /* Nastavení zdraví na základě útoku */
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
         /* Zaslání aktuálních dat do JSON souboru, který webová stránka bude část */
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
   /**
    * Metoda logující informace o kolu v bitvě
    */
   public function start_log()
   {
      fwrite($this->getLog(), "-=-=-=-=-=-=-=-=-=-=-=-=-=-=- Začátek souboje -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-" . PHP_EOL . "Zdraví první armády na začátku: " . $this->getFirstArmy()->getTotalHealth() . PHP_EOL . "Síla první armády na začátku: " . $this->getFirstArmy()->getTotalAttack() . PHP_EOL . "Obrana první armády na začátku: " . $this->getFirstArmy()->getTotalDefense() . PHP_EOL . "Obratnost první armády na začátku: " . $this->getFirstArmy()->getTotalAgility() . PHP_EOL . "Šance na vyhnutí první armády: " . $this->getChangeOnDodgeFirst() . PHP_EOL . "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-" . PHP_EOL . "Zdraví druhé armády na začátku: " . $this->getSecondArmy()->getTotalHealth() . PHP_EOL . "Síla druhé armády na začátku: " . $this->getSecondArmy()->getTotalAttack() . PHP_EOL . "Obrana druhé armády na začátku: " . $this->getSecondArmy()->getTotalDefense() . PHP_EOL . "Obratnost první armády na začátku: " . $this->getSecondArmy()->getTotalAgility() . PHP_EOL . "Šance na vyhnutí druhé armády: " . $this->getChangeOnDodgeSecond() . PHP_EOL . "-=-=-=-=-=-=-=-=-=-=-=-=-=-=- Konec souboje -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-" . PHP_EOL);
   }
   /**
    * Metoda na zápis výsledku bitvy do DB
    */
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
   /**
    * Metoda na získání první armády
    * @return Army První armáda
    */
   public function getFirstArmy()
   {
      return $this->first_army;
   }
   /**
    * Metoda na nastavení první armády
    * @param Army $first_army Objekt armády
    * @return Army První armáda
    */
   public function setFirstArmy($first_army)
   {
      return $this->first_army = $first_army;
   }
   /**
    * Metoda na získání Id bitvy
    * @return int Id bitvy
    */
   public function getId()
   {
      return $this->id;
   }
   /**
    * Metoda na nastavení Id bitvy
    * @param int $id Id bitvy
    * @return int Id bitvy
    */
   public function setId($id)
   {
      return $this->id = $id;
   }
   /**
    * Metoda na získání dat z SQL query
    * @return mixed Data
    */
   public function getResult()
   {
      return $this->result;
   }
   /**
    * Metoda na nastavení a uložení dat z SQL query
    * @param mixed $result Výsledek
    * @return mixed Data z query
    */
   public function setResult($result)
   {
      return $this->result = $result;
   }
   /**
    * Metoda na získání id světa 
    * @return int id světa
    */
   public function getIdWorld()
   {
      return $this->id_world;
   }
   /**
    * Metoda na nastavení id světa
    * @param int $id_world Id světa
    * @return boolean True/False informaci, zdali se podařilo
    */
   public function setIdWorld($id_world)
   {
      return $this->id_world = $id_world;
   }
   /**
    * Metoda na získání druhé armády
    * @return Army druhé armáda
    */
   public function getSecondArmy()
   {
      return $this->second_army;
   }
   /**
    * Metoda na nastavení druhé armády
    * @param Army $first_army Objekt armády
    * @return Army druhá armáda
    */
   public function setSecondArmy($second_army)
   {
      return $this->second_army = $second_army;
   }
   /**
    * Metoda získavající cestu souboru
    */
   public function getPath()
   {
      return $this->path;
   }
   /**
    * Metoda nastavující a otevírající soubory potřebné pro bitvu
    * @param mixed $str
    */
   public function setFiles($str)
   {
      $this->file = fopen("../../../../Files/battle$str.json", "w");
      $this->log = fopen("../../../../Files/battle$str.log", "a");
      return $this->path = "../../../../Files/battle$str.json";
   }
   /**
    * Metoda vracející log soubor
    * @return resource Log
    */
   public function getLog()
   {
      return $this->log;
   }
   /**
    * Metoda vracející JSON soubor
    * @return resource JSON
    */
   public function getFile()
   {
      return $this->file;
   }
   /**
    * Metoda vracející šanci na vyhnutí útoku
    * @return float JSON
    */
   public function getChangeOnDodgeFirst()
   {
      return $this->chance_on_dodge_first;
   }
   /**
    * Metoda nastavující šanci na vyhnutí útoku první armády
    * @param float $chance Šance na vyhnutí
    * @return float True/False informaci, zdali se podařilo nastavit
    */
   public function setChangeOnDodgeFirst($chance)
   {
      return $this->chance_on_dodge_first = $chance;
   }
   /**
    * Metoda vracející šanci na vyhnutí útoku druhé armády
    * @return float JSON
    */
   public function getChangeOnDodgeSecond()
   {
      return $this->chance_on_dodge_second;
   }
   /**
    * Metoda nastavující šanci na vyhnutí útoku druhé armády
    * @param float $chance Šance na vyhnutí
    * @return float True/False informaci, zdali se podařilo nastavit
    */
   public function setChangeOnDodgeSecond($chance)
   {
      return $this->chance_on_dodge_second = $chance;
   }
}
