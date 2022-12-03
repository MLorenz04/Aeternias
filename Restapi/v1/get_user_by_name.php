<?php
$config = require "../../config.php";
global $config;
$username = $_POST["username"];
$con = $config["db"];
/* SQL příkazy */
$sql = "select id from users where nickname = '$username'";
$result = $con->query($sql);
while ($row = $result->fetch_assoc()) {
   echo $row["id"];
   exit();
}
echo "error";
