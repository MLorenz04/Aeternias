<?php
require_once "../../../Components/Classes/Config.php";

$config = Config::getInstance();
/* Hlavička */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/head.php";
/* Navigační menu */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/feedback.php";
/* Navbar */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/navbar_battle.php";
/* Sidebar */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/sidebar_world.php";
$slug_battle = $_GET["slug_battle"];
?>

<main>
   <h1> Bitva </h1>
   <div class="container_battle">
      <div id="first" class="power first">
         <p> 50 % </p>
      </div>
      <div id="second" class="power second">
         <p> 50 % </p>
      </div>
   </div>
   <div id="messages" class="messages">
   </div>

</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>
<script>
   window.onload = function() {
      $interval = setInterval(call_api, 1250);

      function call_api() {
         $.ajax({
            url: "<?php echo $config['root_path_url'] ?>Files/battle<?php echo $slug_battle ?>.json",
            method: "POST",
            async: false,
            success: function($data) {
               if ($data["first_army_hp"] == 0) {
                  $("#first").width("0%");
                  $("#second").width("100%");
                  $("#first > p").text("");
                  $("#second > p").text("Výhra!");
                  setTimeout(() => {
                     $("#second").css("border-radius", "1rem");
                  }, 900);
                  clearInterval($interval);
                  return;
               }
               if ($data["second_army_hp"] == 0) {
                  $("#first").width("100%");
                  $("#second").width("0%");
                  $("#first > p").text("Výhra!");
                  $("#second > p").text("");
                  setTimeout(() => {
                     $("#first").css("border-radius", "1rem");
                  }, 900);
                  clearInterval($interval);
                  return;
               }
               $first_percent = (($data["first_army_hp"]) / (($data["first_army_hp"] + $data["second_army_hp"]) / 100)).toFixed(1);
               $second_percent = (($data["second_army_hp"]) / (($data["first_army_hp"] + $data["second_army_hp"]) / 100)).toFixed(1);
               $("#first").width($first_percent + "%");
               $("#second").width($second_percent + "%");
               $("#first > p").text(($data["first_army_hp"]).toFixed(1) + "♥");
               $("#second > p").text(($data["second_army_hp"]).toFixed(1) + "♥");
               /// Tady dořešit výpis
               $("#messages").html("");
               for (let single_mess of $data["messages"]) {
                  console.log();
                  $("#messages").append("<div class='container " + single_mess["type"] + "'>" + single_mess["message"] + "</div>");
               }
            }
         });
      }
   }
</script>