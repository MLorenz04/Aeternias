<?php
/* Kontrola pravomocí */

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
   global $con;
   $sql = "select type_of_permission from permissions where id_world = $id_world and id_owner = $id_owner";
   $result = $con->query($sql);

   if (mysqli_num_rows($result) > 0) {
      return True;
      exit();
   }
   return False;
}
function security() {
   global $config, $id_world, $user;
   if (check_login() == False) {
      header("location: " . $config['root_path_url'] . "index.php");
      exit();
   }
   if (!($id_world = (int)$id_world) == 1) {
      header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=3");
      exit();
   }
   if (!(in_array($id_world, $user->get_permissions()))) {
      header("location: " . $config['root_path_url'] . "Components/Errors/page_error.php?id=1");
      exit();
   }
}
