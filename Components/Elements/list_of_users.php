<?php
if (check_permission($id_user, $id_world)) {
   $permission = true;
}
$sql_select_permissions = "select users.nickname, users.id, permissions.type_of_permission from permissions 
inner join users
on permissions.id_owner = users.id 
where id_world = $id_world";
$con = $config["db"];
$result = $con->query($sql_select_permissions);
?>
<ul class="list-group container d-flex flex-column">
   <?php
   while ($row = $result->fetch_assoc()) {
      $id = $row["id"];
   ?>
      <li class="list-group-item active" style="width:100%; margin: 10px 0;">
         <span class="float-start" style="margin-top: 3px"> <?php echo $row["nickname"] ?> </span>
         <?php if ($permission == true) { ?><a style="cursor:pointer" class="remove_permission float-end" id="<?php echo $row["id"] ?>" class="" style="margin-top: 1px"> <i class="remove-permission bi bi-x-circle"></i> </a> <?php } ?>
         <span class="float-end" style="margin-top: 3px"> <?php echo $row["type_of_permission"] ?> </span>
      </li>
   <?php
   }
   ?>
</ul>