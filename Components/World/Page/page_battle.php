<?php
/* Konfigurační soubory */
require_once "../../../Components/Classes/Config.php";
$config = (new Config())->get_instance();
/* Celá hlavička */
require_once "../../Templates/Body_parts/world_header.php";
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="px-4 py-2" id="content">
      <div class="d-flex">
         <h1 class="m-auto"> Bitva </h1>
         <a href="<?php echo $config['root_path_url'] . "Components/World/Page/page_create_battle.php?id=$id_world" ?>"><button class="btn btn-primary create-new-warrior my-2"> Vytvořit </button> </a>
      </div>
      <p> Zde můžete vyzvat spoluhráče či protivníka na bitvu! Výsledky se zobrazí na výsledkové tabuli </p>
      <div class="col-lg-12 d-flex justify-content-center">
         <table class="table table-dark">
            <thead>
               <tr>
                  <th scope="col">Id bitvy</th>
                  <th scope="col">Šance na výhru </th>
                  <th scope="col">Výsledek</th>
                  <th scope="col">Datum</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $sql = "select * from battle where id_world = $id_world";
               $result = $config["db"]->query($sql);
               while ($row = $result->fetch_assoc()) {
               ?>
                  <tr class="<?php echo ($row["result"][0] == "0") ? "loose" : "won" ?>">
                     <th scope="row"><?php echo $row["id"] ?></th>
                     <td><?php echo $row["chance"] ?> %</td>
                     <td><?php echo $row["result"] ?></td>
                     <td><?php echo $row["date"] ?></td>
                  </tr>
               <?php
               }
               ?>
            </tbody>
         </table>
      </div>
   </div>
</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>