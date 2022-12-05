<?php
/* Konfigurační soubor */
$config = require "../../../config.php";
/* Databáze */
$con = $config["db"];
/* Zkusí získat údaje, pokud se mu to nepodaří, hodí na index */
/* Ochrana proti pokusu jít přímo na soubor bez vyplněného formuláře */
try {
   $id_owner = $_POST["id"];
   $id_world = $_POST['current_open_world'];
} catch (Exception $e) {
   header("location:" . $config['root_url'] . "index.php");
   exit();
}
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
   exit();
} else {
   echo "Vyskytla se chyba. Zadal jste správné jméno?";
   exit();
}
