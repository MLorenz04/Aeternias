<?php
require "../../../../Components/Classes/Config.php";
$config = (new Config())->get_instance();
$obj = new stdClass();
$array = array();
$id_world = $_GET["id"];
$con = $config["db"];
$sql = "select * from warrior where id_world = $id_world";
$result = $con->query($sql);
if ($result != "" || $result != null) {
   while ($row = $result->fetch_assoc()) {
      array_push($array, $row);
   }
}
$obj->warriors = $array;
$obj = json_encode($obj);
echo $obj;