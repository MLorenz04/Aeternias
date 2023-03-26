<?php
/* Konfigurační soubory */
require_once "../../../Components/Classes/Config.php";
require_once "../../Classes/Errors.php";
$error = (new Errors(-1))->getList();
$config = (new Config())->get_instance();
/* Celá hlavička */
require_once "../../Templates/Body_parts/world_header.php";
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/php_header_single_world.php";
?>
<main id="main" class="main wall_main">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-8 section register min-vh-100 d-flex flex-column py-4">
            <div class="card">
               <div class="card-body">
                  <div class="row flex text-center main-color card-title">
                     <h1 class="py-4"> Vytvořte si novou jednotku!</h1>
                  </div>
                  <form onclick="event.preventDefault()" method="POST">
                     <div class="container">
                        <div class="row light-text">
                           <p class="my-0"> Jednotku budete moci využít hned po jejím vytvoření </p>
                           <p class="mb-4"> Pro informace, jak vytvářet jednotky, zamiřte do sekce <a href="<?php echo $config['root_path_url'] . "Components/Wall/warriors.php" ?>"> jednotek </a> </p>
                           <div class="mb-3 col-sm">
                              <label for="name" class="form-label">Název jednotky</label>
                              <input type="text" require_onced class="form-control" id="name" name="name">
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="desc" class="form-label">Krátká poznámka</label>
                              <input type="text" class="form-control" id="desc" name="desc" require_onced>
                           </div>
                        </div>
                        <div class="row light-text">
                           <div class="mb-3 col-sm ">
                              <label for="attack" class="form-label">Útok</label>
                              <input type="number" class="form-control" id="attack" name="attack" require_onced>
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="defense" class="form-label">Obrana</label>
                              <input type="number" class="form-control" id="defense" name="defense" require_onced>
                           </div>
                           <div class="mb-3 col-sm">
                              <label for="agility" class="form-label">Agilita</label>
                              <input type="number" class="form-control" id="agility" name="agility" require_onced>
                           </div>
                           <div class="mb-3 col-sm ">
                              <label for="health" class="form-label">Zdraví</label>
                              <input type="number" class="form-control" id="health" name="health" require_onced>
                           </div>
                        </div>
                        <button id="add_warrior" class="btn btn-primary px-4 b">Přidat!</button>
                        <button id="create_warrior" class="btn btn-primary px-4 b float-end">Vytvořit!</button>
                  </form>
               </div>
            </div>
         </div>
         <div id="warriors" class="warriors">

         </div>
      </div>
   </div>
   </div>
</main>
<script>
   let $warriors = [];
   let $existing_warriors;

   $(document).ready(function() {
      $.ajaxSetup({
         beforeSend: function(xhr) {
            xhr.setRequestHeader('Api-token', '<?php echo $user->getApiToken() ?>');
            xhr.setRequestHeader('Api-hash', '<?php echo $user->getApiHash() ?>');
         }
      });
   });

   $("#add_warrior").click(function() {
      $name = $("#name").val().replace(/(<([^>]+)>)/gi, "");
      $desc = $("#desc").val().replace(/(<([^>]+)>)/gi, "");
      $attack = $("#attack").val();
      $defense = $("#defense").val();
      $agility = $("#agility").val();
      $health = $("#health").val();
      let arr = [$name, $attack, $defense, $agility, $health];
      if (!arr.every(value => value != null && value != "")) {
         Swal.fire({
            title: "Vyplňte, prosím, všechny údaje",
            icon: "error"
         })
         return;
      }
      $regex_new_warrior_name = new RegExp("^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-,\\s]{3,50}$");
      if ($warriors.some(warrior => warrior.name == $name)) {
         showErrorMess('<?php echo $error["error_mess_name_exists"] ?>');
         return;
      }

      if (!($regex_new_warrior_name.test($name))) {
         showErrorMess('<?php echo $error["error_mess_new_warrior_name"] ?>');
         return;
      }
      if ($desc.length > 500 || $attack < 0 || $defense < 0 || $agility < 0 || isEmpty($attack) || isEmpty($defense) || isEmpty($agility) || $health <= 0) {
         showErrorMess('<?php echo $error["error_mess_new_warrior_number"] ?>');
         return;
      }
      let warrior = {
         name: $name,
         desc: $desc,
         attack: $attack,
         defense: $defense,
         agility: $agility,
         health: $health
      }
      $("#warriors").append('<div class="card-body" <span class="d-flex"> <h5 class="card-text pl-4 text-center w-100">' + $name + '</h5>  </span> <p id="warrior_desc" class="mb-1"><b> Popis: </b>' + $desc + '</p> <p id="warrior_attack" class="mb-1"> <b>Útok: </b>' + $attack + '</p> <p id="warrior_defense" class="mb-1"> <b> Obrana: </b> ' + $defense + '</p> <p id="warrior_agility" class="mb-1"> <b> Agilita: </b> ' + $agility + '</p> <p id="warrior_hp" class="mb-1"> <b> Zdraví: </b> ' + $health + '</p> </div>');
      $warriors.push(warrior);
      $("#name").val("");
      $("#desc").val("");
      $("#attack").val("");
      $("#defense").val("");
      $("#agility").val("");
      $("#health").val("");
   });

   $("#create_warrior").click(function() {
      if ($warriors.length == 0) {
         showInfoMess('Nejdříve prosím přidejte válečníky pomocí tlačítka "Přidej". Poté jich vytvořte, kolik budete chtít a odešlete tímto tlačítkem');
      }
      $warriors.forEach(function($warrior) {
         $url = (isEmpty($warrior["desc"])) ?
            "<?php echo $config['root_path_url'] ?>Restapi/v1/warriors/<?php echo $id_world ?>/" + $warrior["name"] + "/" + $warrior["attack"] + "/" + $warrior["defense"] + "/" + $warrior["agility"] + "/" + $warrior["health"] :
            "<?php echo $config['root_path_url'] ?>Restapi/v1/warriors/<?php echo $id_world ?>/" + $warrior["name"] + "/" + $warrior["desc"] + "/" + $warrior["attack"] + "/" + $warrior["defense"] + "/" + $warrior["agility"] + "/" + $warrior["health"];

         $.ajax({
            url: $url,
            type: "POST",
            async: false,
            success: function($result) {
               showSuccessMess("Válečníci přidáni do vašeho světa!");
            }
         }).fail(function(data) {
            showErrorMess(data.responseText);
         });
         $warriors = [];
         $("#warriors").html("")
      });
   });
</script>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>