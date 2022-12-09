$(window).on("load", function () {
  $(".loader").css("display", "none")
  if (getCookie("template") == "dark") {
    toggle_dark_mode();
  } else {
    untoggle_dark_mode();
  }
});
