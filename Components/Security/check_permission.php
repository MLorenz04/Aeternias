<?php
$id_world = $_GET["id"];
$id_user = $_SESSION["id_user"];
$con = $config["db"];
$sql = "select * from permissions where id_world = $id_world AND id_owner = $id_user";
$result = $con -> query($sql);
if(mysqli_num_rows($result) == 0) {
   header("location: " . $config["root_url"] . "Components/Errors/error.php?id=1");
}
