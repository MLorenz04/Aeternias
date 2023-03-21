<?php
//Třída armády
class Army
{
   /* Proměnné třídy Army */
   public $warriors = array();
   private $attack;
   private $health;
   private $agility;
   private $defense;
   /* Konstruktor */
   public function __construct($warriors)
   {
      $this->setWarriors($warriors);
      $this->setStats();
   }

   /* Výpis na obrazovku, používáno pouze pro vývoj */
   public function showWarriors()
   {
      echo "<pre>";
      print_r($this->warriors);
      echo "</pre>";
      echo "<br>";
   }
   public function getWarriors()
   {
      return $this->warriors;
   }

   public function setWarriors($field)
   {
      return $this->warriors = $field;
   }

   public function setStats()
   {
      $pwr = 0;
      $hp = 0;
      $agl = 0;
      $def = 0;
      foreach ($this->getWarriors() as $warrior) {
         $pwr += $warrior->getAttack() * $warrior->getCount();
         $hp += $warrior->getHp() * $warrior->getCount();
         $agl += $warrior->getAgility() * $warrior->getCount();
         $def += $warrior->getDefense() * $warrior->getCount();
      }
      $this->attack = $pwr;
      $this->health = $hp;
      $this->agility = $agl;
      $this->defense = $def;
   }

   public function getTotalAttack()
   {
      return $this->attack;
   }

   public function setTotalAttack($attack)
   {
      return $this->attack = $attack;
   }

   public function getTotalDefense()
   {
      return $this->defense;
   }

   public function setTotalDefense($defense)
   {
      return $this->defense = $defense;
   }

   public function getTotalHealth()
   {
      return $this->health;
   }

   public function setTotalHealth($health)
   {
      return $this->health = $health;
   }

   public function getTotalAgility()
   {
      return $this->agility;
   }

   public function setTotalAgility($agility)
   {
      return $this->agility = $agility;
   }
}
