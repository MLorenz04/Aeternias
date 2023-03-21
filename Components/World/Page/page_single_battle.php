<?php
require "../../Classes/Config.php";
$config = (new Config())->get_instance();
$id = $_GET["id"];
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html>

<head>
   <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $config['root_path_url'] ?>Source/IMG/favicon.ico">
   <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $config['root_path_url'] ?>Source/IMG/favicon.ico">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-16">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Aeternias</title>
   <link href="<?php echo $config['root_path_url'] ?>Source/CSS/all.css" rel="stylesheet">
   <!-- Third-party libraries -->
   <!-- Jquery -->
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
   <!-- Sweet alert -->
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- Animation css -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
   <script src="<?php echo $config['root_path_url'] ?>vendor/cookies.js"></script>
   <script src="<?php echo $config['root_path_url'] ?>vendor/slug_gen.js"></script>
</head>

<body>

   <body>
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

   </body>
   <script>
      window.onload = function() {
         $interval = setInterval(call_api, 1250);

         function call_api() {
            $.ajax({
               url: "<?php echo $config['root_path_url'] ?>Files/battle<?php echo $id ?>.json",
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

</html>