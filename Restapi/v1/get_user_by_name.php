<?php
require_once "../../Components/Classes/Config.php";
$config = (new Config()) -> get_instance();
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
