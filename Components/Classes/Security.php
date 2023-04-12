<?php
require_once "Config.php";
require_once "User.php";
require_once "Errors.php";
   /**
    * Třída na handle chyb a bezpečnostních hrozeb
    * 
    * @author Matyáš Lorenz
    */
class Security
{

   private $config, $con, $errors;
   /**
    * Konstruktor s 
    */
   public function __construct()
   {
      $this->config = Config::getInstance();
      $this->con = $this->config["db"];
      $this->errors = (new Errors(0))->getList();
   }
   /**
    * Metoda kontrolující, zdali je uživatel přihlášený
    */
   function check_login()
   {
      /* Jednoduchá kontrola přihlášení. Jestli není přihlášen, vrátí false */
      if (!(isset($_SESSION['is_logged']))) {
         return False;
      }
      return True;
   }
   /**
    * Metoda kontrolující, zdali má uživatel admin pravomoce do světa
    * @param int $id_world ID světa
    * @param int $id_owner ID vlastníka
    * @return mixed Header na error stránku či propuštění dál
    */
   function check_owner($id_world, $id_owner)
   {
      $sql = "select type_of_permission from permissions where id_world = $id_world and id_owner = $id_owner";
      $result = $this->con->query($sql);
      $row = $result->fetch_assoc();
      if ($row["type_of_permission"] == "Administrátor") {
         return True;
      }
      header("location: " . $this->config['root_path_url'] . "Components/Errors/page_error.php?id=1");
      exit();
   }
   /**
    * Metoda kontrolující pravomoce uživatele ve světě
    * @param int $id_world ID světa
    * @param User $user Uživatel
    */
   function check_permissions($id_world, $user)
   {
      global $config;
      $has_perm = False;
      foreach ($user->getPermissions() as $single_perm) {
         if ($single_perm[0] == $id_world) {
            $has_perm = True;
         }
      }
      return $has_perm;
   }
   /**
    * Kotrola existujícího uživatele
    * @param mixed $user Uživatel
    */
   function check_existing_user($user)
   {
      return ($user == false) ? false : true;
   }
   /** 
    * Metoda seskupující ostatní metody do jednoho balíčku
    * @param int $id_world ID světa
    * @param int $id_owner ID vlastníka
    */
   function security($id_world, $user)
   {
      global $config;
      if ($this->check_login() == False) {
         header("location: " . $config['root_path_url'] . "index.php");
         exit();
      }

      if (!($id_world = (int)$id_world) == 1) {
         //header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=3");
         exit();
      }
      if (!($this->check_permissions($id_world, $user))) {
         header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
      }
   }
}
