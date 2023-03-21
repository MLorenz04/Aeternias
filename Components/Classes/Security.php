<?php
require_once "Config.php";
class Security
{

   private $config, $con;

   public function __construct()
   {
      $this->config = (new Config())->get_instance();
      $this->con = $this->config["db"];
   }
   function check_login()
   {
      /* Jednoduchá kontrola přihlášení. Jestli není přihlášen, vrátí false */
      if (!(isset($_SESSION['is_logged']))) {
         return False;
      }
      return True;
   }

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
   function security($id_world, $user)
   {
      global $config;
      if ($this->check_login() == False) {
         header("location: " . $config['root_path_url'] . "index.php");
         exit();
      }

      if (!($id_world = (int)$id_world) == 1) {
         header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=3");
         exit();
      }

      $has_perm = False;
      foreach ($user->getPermissions() as $single_perm) {
         if ($single_perm[0] == $id_world) {
            $has_perm = True;
         }
      }

      if ($has_perm == False) {
         header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
      }
   }
}