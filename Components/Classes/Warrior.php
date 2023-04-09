<?php
require "Config.php";
/**
 * Třída na tvoření válečníků
 * 
 * @author Matyáš Lorenz
 */
class Warrior
{
   private $id_world = 0;
   private $id = 0;
   private $attack, $defense, $agility, $health = 0;
   private $name = "";
   private $count = 0;

   /**
    * Konstruktor válečníka
    * @param int $id_world Id světa
    * @param int $id Id válečníka
    * @param int $count Počet vojáků
    */
   public function __construct($id_world, $id, $count)
   {
      $this->setId($id);
      $this->setIdWorld($id_world);
      $config = (new Config())->get_instance();
      $sql = "select * from warrior where id_world =" . $this->getIdWorld($id_world) . " and id = " . $this->getId($id);
      $con = $config["db"];
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $this->setAgility($row["agility"]);
      $this->setDefense($row["defense"]);
      $this->setAttack($row["attack"]);
      $this->setName($row["name"]);
      $this->setHp($row["hp"]);
      $this->setCount($count);
   }
   /**
    * Metoda vracející id světa
    * @return int Id světa
    */
   public function getIdWorld()
   {
      return $this->id_world;
   }
   /**
    * Metoda nastavující id světa
    * @param int Id světa
    */
   public function setIdWorld($id_world)
   {
      $this->id_world = $id_world;
   }
   /**
    * Metoda vracející agilitu
    * @return float agilitu
    */
   public function getAgility()
   {
      return $this->agility;
   }
   /**
    * Metoda nastavující agilitu
    * @param float Agility
    */
   public function setAgility($agility)
   {
      $this->agility = $agility;
   }
   /**
    * Metoda vracející obranu
    * @return float Obrana
    */
   public function getDefense()
   {
      return $this->defense;
   }
   /**
    * Metoda nastavující obranu
    * @param float Obrana
    */
   public function setDefense($defense)
   {
      $this->defense = $defense;
   }
   /**
    * Metoda vracející útok
    * @return float útok
    */
   public function getAttack()
   {
      return $this->attack;
   }
   /**
    * Metoda nastavující útok
    * @param float Útok
    */
   public function setAttack($attack)
   {
      $this->attack = $attack;
   }
   /**
    * Metoda vracející id
    * @return int Id
    */
   public function getId()
   {
      return $this->id;
   }
   /**
    * Metoda nastavující id
    * @param int Id
    */
   public function setId($id)
   {
      $this->id = $id;
   }
   /**
    * Metoda vracející počet válečníků
    * @return int Počet válečníků
    */
   public function getCount()
   {
      return $this->count;
   }
   /**
    * Metoda nastavující počet válečníků
    * @param int Počet válečníků
    */
   public function setCount($count)
   {
      $this->count = $count;
   }
   /**
    * Metoda vracející jméno válečníka
    * @return int Jméno válečníka
    */
   public function getName()
   {
      return $this->name;
   }
   /**
    * Metoda nastavující jméno
    * @param float Jméno
    */
   public function setName($name)
   {
      $this->name = $name;
   }
   /**
    * Metoda vracející zdraví
    * @return float Zdraví
    */
   public function getHp()
   {
      return $this->health;
   }
   /**
    * Metoda nastavující zdraví
    * @param float Zdraví
    */
   public function setHp($hp)
   {
      $this->health = $hp;
   }
}
