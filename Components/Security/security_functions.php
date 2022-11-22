<?php
/* Databáze */
$con = $config["db"];
/* Kontrola pravomocí */
function check_login()
{
   /* Jednoduchá kontrola přihlášení. Jestli není přihlášen, vrátí false */
   if (!(isset($_SESSION["is_logged"]))) {
      return False;
   }
   return True;
}
function check_permission($id_user, $id_world)
{
   global $con, $config;
   $sql = "select * from permissions where id_world = $id_world AND id_owner = $id_user";
   $result = $con->query($sql);
   if (mysqli_num_rows($result) == 0) {
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
