<?php
require "Config.php";
class Warrior
{
   private $id_world = 0;
   private $id = 0;
   private $attack, $defense, $agility, $health = 0;
   private $name = "";
   private $count = 0;



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

   public function getIdWorld()
   {
      return $this->id_world;
   }

   public function setIdWorld($id_world)
   {
      return $this->id_world = $id_world;
   }

   public function getAgility()
   {
      return $this->agility;
   }

   public function setAgility($agility)
   {
      return $this->agility = $agility;
   }

   public function getDefense()
   {
      return $this->defense;
   }

   public function setDefense($defense)
   {
      return $this->defense = $defense;
   }

   public function getAttack()
   {
      return $this->attack;
   }

   public function setAttack($attack)
   {
      return $this->attack = $attack;
   }

   public function getId()
   {
      return $this->id;
   }

   public function setId($id)
   {
      return $this->id = $id;
   }

   public function getCount()
   {
      return $this->count;
   }
   public function setCount($count)
   {
      return $this->count = $count;
   }
   public function getName()
   {
      return $this->name;
   }
   public function setName($name)
   {
      return $this->name = $name;
   }
   public function getHp()
   {
      return $this->health;
   }

   public function setHp($hp)
   {
      return $this->health = $hp;
   }
}
