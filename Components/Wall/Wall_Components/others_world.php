<?php
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$username = $user->getUsername();
$id_owner = $user->getId();
/* Databáze a připojení do kolekce */
$con = $config['db'];
/* SQL příkaz (Vymýšlený 10 minut (._.))*/
$sql_all_worlds = "
select world.name, world.description, world.id
from world 
where world.id in (
select permissions.id_world
from permissions
where
permissions.id_owner = $id_owner
and permissions.type_of_permission = 'Hráč'
);";
/* Výpis všech uživatelových světů */
$result = $con->query($sql_all_worlds);
while ($row = $result->fetch_assoc()) {
   $current_id = $row['id'];
?>
   <div class="m-4 card world body-add-world" style="width: 18rem;">
      <a class="single-world-link" href="<?php echo $config['root_path_url'] . "Components/World/Page/page_single_world.php?id=$current_id" ?>">
         <div class="card-body">
            <h5 class="card-text"><?php echo $row['name']; ?></h5>
            <p class="card-text"><?php echo $row['description']; ?></p>
         </div>
      </a>
   </div>
<?php
}
?>