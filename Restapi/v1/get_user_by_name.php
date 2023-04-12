<?php
require_once "../../Components/Classes/Config.php";
$config = Config::getInstance();
global $config;
$username = $_POST['username'];
$con = $config['db'];
/* SQL příkazy */
$sql = "select id from users where nickname = '$username'";
$result = $con->query($sql);
while ($row = $result->fetch_assoc()) {
   echo $row['id'];
   exit();
}
echo "error";
