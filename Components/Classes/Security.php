<?php
require_once "Config.php";
require_once "User.php";
require_once "Errors.php";
class Security
{

   private $config, $con, $errors;

   public function __construct()
   {
      $this->config = (new Config())->get_instance();
      $this->con = $this->config["db"];
      $this->errors = (new Errors(0))->getList();
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

   function check_existing_user($user)
   {
      if ($user == false) {
         return false;
      } else {
         return true;
      }
   }
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
