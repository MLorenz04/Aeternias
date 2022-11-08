<?php
$config = require("../../config.php");
session_start();
$id_owner = $_SESSION["id_user"];
$sql = "select init from world where id_owner = $id_owner";
$con = new mysqli($config['db_name'], $config['db_username'], $config['db_password'], $config['db_dbname']);
$result = $con->query($sql);
while ($row = $result->fetch_assoc()) {
   $obj = json_decode($row["init"]);
?>
      <div class="m-4 card body-add-world" style="width: 18rem;">
         <div class="card-body">
            <h5 class="card-text"><?php echo $obj -> name; ?></h5>
            <p class="card-text"><?php echo $obj -> desc; ?></p>
         </div>
      </div>
<?php
}
?>