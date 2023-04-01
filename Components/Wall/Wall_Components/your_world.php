<?php
/* Proměnné */
$user = unserialize($_SESSION['logged_user']);
$username = $user->getUsername();
$id_owner = $user->getId();
/* Databáze a připojení do kolekce */
$con = $config['db'];
/* SQL příkazy */
$sql_all_worlds = "select name, description, id from world where id_owner = $id_owner";
/* Výpis všech uživatelových světů */
$result = $con->query($sql_all_worlds);
while ($row = $result->fetch_assoc()) {
   $current_id = $row['id'];
?>

   <div class="card world body-add-world">
      <a class="single-world-link" href="<?php echo $config['root_path_url'] . "Components/World/Page/page_single_world.php?id=$current_id" ?>">
         <div class="card-body">
            <h5 class="card-text light-text"><?php echo $row['name']; ?></h5>
            <p class="card-text light-text"><?php echo $row['description']; ?></p>
         </div>
      </a>
   </div>
<?php
}
?>