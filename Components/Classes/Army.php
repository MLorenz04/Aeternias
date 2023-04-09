<?php

/**
 * Třída pro tvorbu armády
 * @author Matyáš Lorenz
 */
class Army
{
   /* Proměnné třídy Army */
   public $warriors = array();
   private $attack;
   private $health;
   private $agility;
   private $defense;
   private $count;
   /** 
    * Konstruktor
    * @param array $warriors Pole válečníků
    */
   public function __construct($warriors)
   {
      $this->setWarriors($warriors);
      $this->setStats();
   }

   /**
    *  Výpis na obrazovku, používáno pouze pro vývoj 
    */
   public function showWarriors()
   {
      echo "<pre>";
      print_r($this->warriors);
      echo "</pre>";
      echo "<br>";
   }
   /**
    * Metoda na získání válečníků z armády
    * @return array Válečníci
    */
   public function getWarriors()
   {
      return $this->warriors;
   }
   /**
    * Metoda na nastavení válečníků
    * @param array Válečníci
    */
   public function setWarriors($field)
   {
      $this->warriors = $field;
      $this->setStats();
   }
   /**
    * Metoda na nastavení všech statistik armády
    * @return boolean True/False, zdali se podařilo nastavit
    */
   public function setStats()
   {
      $pwr = 0;
      $hp = 0;
      $agl = 0;
      $def = 0;
      $count = 0;
      foreach ($this->getWarriors() as $warrior) {
         $pwr += $warrior->getAttack() * $warrior->getCount();
         $hp += $warrior->getHp() * $warrior->getCount();
         $agl += $warrior->getAgility() * $warrior->getCount();
         $def += $warrior->getDefense() * $warrior->getCount();
         $count += $warrior->getCount();
      }
      $this->attack = $pwr;
      $this->health = $hp;
      $this->agility = $agl;
      $this->defense = $def;
      $this->count = $count;
   }
   public function getWarriorById($id)
   {
      $asoc = array();
      foreach ($this->getWarriors() as $warrior) {
         $asoc = ($asoc + array($warrior->getId() => $warrior));
      }
      return $asoc[$id];
   }
   /**
    * Metoda na získání útoku armády
    * @return float Útok
    */
   public function getTotalAttack()
   {
      return $this->attack;
   }
   /**
    * Metoda na nastavení útoku armády
    * @param mixed $attack Útok
    * @return float True/False, zdali se podařilo nastavit
    */
   public function setTotalAttack($attack)
   {
      return $this->attack = $attack;
   }
   /**
    * Metoda na získání obrany armády
    * @return float Obrana
    */
   public function getTotalDefense()
   {
      return $this->defense;
   }
   /**
    * Metoda na nastavení obrany armády
    * @param mixed $defense Obrana
    * @return float True/False, zdali se podařilo nastavit
    */
   public function setTotalDefense($defense)
   {
      return $this->defense = $defense;
   }
   /**
    * Metoda na získání zdraví armády
    * @return float Zdraví
    */
   public function getTotalHealth()
   {
      return $this->health;
   }
   /**
    * Metoda na nastavení zdraví armády
    * @param mixed $health zdraví
    * @return boolean True/False, zdali se podařilo nastavit
    */
   public function setTotalHealth($health)
   {
      return $this->health = $health;
   }
   /**
    * Metoda na získání obratnosti armády
    * @return float Obratnost
    */
   public function getTotalAgility()
   {
      return $this->agility;
   }
   /**
    * Metoda na nastavení obratnosti armády
    * @param mixed $agility Agilita
    * @return boolean True/False, zdali se podařilo nastavit
    */
   public function setTotalAgility($agility)
   {
      return $this->agility = $agility;
   }
   /**
    * Metoda na získání počtu vojáků v armádě
    * @return int Počet v armádě
    */
   public function getTotalCount()
   {
      return $this->count;
   }
   /**
    * Metoda na nastavení počtu vojáků v armádě
    * @param mixed $count Počet
    * @return boolean True/False, zdali se podařilo nastavit
    */
   public function setTotalCount($count)
   {
      return $this->count = $count;
   }
}
