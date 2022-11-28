<?php
$sql = "select users.nickname, permissions.type_of_permission from permissions 
inner join users
on permissions.id_owner = users.id 
where id_world = $id_world";
$con = $config["db"];
$result = $con->query($sql);
?>
<ul class="list-group">
   <?php
   while ($row = $result->fetch_assoc()) {
   ?>
   <div class="container d-flex"> 
      <li class="list-group-item active" style="width:100%">
         <span style="float:left"> <?php echo $row["nickname"] ?> </span>
         <span style="float:right"> <?php echo $row["type_of_permission"] ?> </span>
      </li>
      <a href="<?php echo $config['root_url'] . "Components/" ?>"> <i class="remove-permission bi bi-x-circle position-fixed"></i> </a>
   <?php
   }
   ?>
</ul>