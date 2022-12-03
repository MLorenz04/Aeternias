<?php
$config = require "../../../config.php";
session_start();
$con = $config["db"];
$id_owner = $_POST["id"];
$id_world = $_POST['current_open_world'];
$sql_select_all = "select * from permissions where id_owner = $id_owner and id_world = $id_world";
if ($id_owner != "error") {
   $result = $con->query($sql_select_all);
   while ($row = $result->fetch_assoc()) {
      if ($row["id_owner"] == $id_owner) {
         echo "Tento uživatel je již přidaný";
         exit();
      }
   }
} else {
   echo "Tento uživatel neexistuje!";
   exit();
}
$sql_insert_permission = "insert into permissions(type_of_permission,id_owner,id_world) values('Hráč',$id_owner,$id_world);";
if ($con->query($sql_insert_permission)) {
   echo "Uživatel byl úspěšně přidán!";
   exit();
} else {
   echo "Vyskytla se chyba. Zadal jste správné jméno?";
   exit();
}
