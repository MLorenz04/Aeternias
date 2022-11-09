/* Načte zkrácené info */
function load_brief() {
   $.ajax({
     url: "../../Components/Wall/brief_wall.php",
     success: function (result) {
      $("#content").html(result);
     },
   });
}

/* Načte tutoriál */
function load_tutorial() {
   $.ajax({
     url: "../../Components/Wall/tutorial.php",
     success: function (result) {
      $("#content").html(result);
     },
   });
}

/* Načte informace */
function load_help() {
   $.ajax({
     url: "../../Components/Wall/information.php",
     success: function (result) {
      $("#content").html(result);
     },
   });
}

/* Načte světy */
function load_worlds() {
   $.ajax({
     url: "../../Components/Wall/worlds.php",
     success: function (result) {
      $("#content").html(result);
     },
   });
}

/* Načte formulář pro vytvoření nového světa */
function load_create_new_world() {
  $.ajax({
    url: "../../Components/World/Page/new_world.php",
    success: function (result) {
     $("#content").html(result);
    },
  });
}

/* Načte jednotky */
function load_warriors() {
   $.ajax({
     url: "../../Components/Wall/warriors.php",
     success: function (result) {
      $("#content").html(result);
     },
   });
}