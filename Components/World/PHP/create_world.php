<?php
$config = require "../../../config.php";
$con = new mysqli($config['db_name'], $config['db_username'], $config['db_password'], $config['db_dbname']);
session_start();
$name = $_POST["world_name"];
$desc = $_POST["desc"];
$owner_id = $_SESSION["id_user"];
$json = [
   "id" => 0, 
   "owner_id" => $owner_id, 
   "name" => $name, 
   "desc" => $desc, 
   "permissions" => [
         [
            "id_user" => 0
         ],
      ], 
   "warriors" => [
               [
                  "name" => "Lučistník", 
                  "id_warrior" => 0, 
                  "stats" => [
                     "attack" => 3, 
                     "health" => 4 
                  ] 
                  ],
                  [
                     "name" => "Kopijník", 
                     "id_warrior" => 1, 
                     "stats" => [
                        "attack" => 4, 
                        "health" => 5
                     ] 
                  ] 
            ] 
];
$json_encoded = json_encode($json,JSON_UNESCAPED_UNICODE);
$sql = "insert into world(name,init,id_owner) values('$name','$json_encoded',$owner_id)";
if($con -> query($sql)) {
   header("location: ../../Wall/wall.php#worlds");
}

?>