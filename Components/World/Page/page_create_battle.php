<?php
/* Konfigurační soubory */
require_once "../../../Components/Classes/Config.php";
$config = (new Config())->get_instance();
/* Celá hlavička */
require_once "../../Templates/Body_parts/world_header.php";
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/php_header_single_world.php";

$world = (new World($id_world))->get_instance();
?>
<main id="main" class="main wall_main">
   <form id="army" method="POST">
      <div class="army_container" id="first_army">
         <?php
         foreach ($world->getWarriors() as $single_warrior) {
         ?>
            <label for="<?php $single_warrior["id"] ?>">
               <?php echo $single_warrior["name"] ?>
            </label>
            <input type="number" name="first_army_warriors[<?php echo $single_warrior["id"] ?>]">
         <?php
         }
         ?>
      </div>
      <div class="army_container" id="second_army">
         <?php
         foreach ($world->getWarriors() as $single_warrior) {
         ?>
            <label for="<?php $single_warrior["id"] ?>">
               <?php echo $single_warrior["name"] ?>
            </label>
            <input type="number" name="second_army_warriors[<?php echo $single_warrior["id"] ?>]">
         <?php
         }
         ?>
      </div>
      <br>
      <button type="submit"> Odeslat !</button>
   </form>
</main>
<script>
   function makeid(length) {
      let result = '';
      const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      const charactersLength = characters.length;
      let counter = 0;
      while (counter < length) {
         result += characters.charAt(Math.floor(Math.random() * charactersLength));
         counter += 1;
      }
      return result;
   }

   $(document).ready(function() {
      $('#army').submit(function(event) {
         $datas = $('#army').serialize();
         if ($datas == null || $datas == [] || $datas == "") {
            Swal.fire({
               icon: 'error',
               title: 'Nezadal jste žádného válečníka'
            })
            return;
         }
         event.preventDefault(); // zabrání výchozímu chování formuláře
         $slug = makeid(30)
         $.ajax({
            url: '<?php echo $config["root_path_url"] ?>Components/World/Functions/Battle/prepare_battle.php?id=<?php echo $id_world ?>',
            type: 'POST',
            data: {
               "form-data": $datas,
               "slug": $slug
            },

            success: function($data) {
               if ($data != "") {
                  Swal.fire({
                     icon: "error",
                     title: $data
                  })
               } else {
                  $.ajax({
                     url: '<?php echo $config["root_path_url"] ?>Components/World/Functions/Battle/start_battle.php?id=<?php echo $id_world ?>',
                     type: 'POST',
                     data: {
                        "form-data": $datas,
                        "slug": $slug
                     },
                  });
                  window.location.replace('<?php echo $config["root_path_url"] ?>Components/World/Page/page_single_battle.php?id=' + $slug); // přesměrování na single_battle.php
               }
            }

         });
      });
   });
</script>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>