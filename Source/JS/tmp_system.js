body = $("body");
sidebar = $(".sidebar");
links = $(".sidebar-item > span");
button = $("#dark-mode");
navbar = $("nav");
nav_link = $(".navbar-link");
card_title = $(".card-title");
buttons = $(".btn-primary");
feedback = $(".modal-title");
icons = $("i:not(.text-dark-always)");
texts = $(".light-text");
function toggle_dark_mode() {
  button.attr("onclick", "untoggle_dark_mode()");
  button.html("Tmavý mód");
  body.addClass("dark-mode");
  sidebar.addClass("dark-mode-secondary");
  links.addClass("dark-mode-text");
  card_title.addClass("light-mode-text");
  navbar.addClass("dark-mode");
  navbar.addClass("dark-mode-text");
  nav_link.addClass("dark-mode-text");
  icons.addClass("text-light");
  feedback.addClass("light-mode-text");
  texts.addClass("light-mode-text");

  setCookie("template", "dark", "30", "/");
}

function untoggle_dark_mode() {
  nav_link.removeClass("dark-mode-text");
  body.removeClass("dark-mode");
  sidebar.removeClass("dark-mode-secondary");
  links.removeClass("dark-mode-text");
  navbar.removeClass("dark-mode");
  navbar.removeClass("dark-mode-text");
  button.attr("onclick", "toggle_dark_mode()");
  card_title.removeClass("light-mode-text");
  icons.removeClass("text-light");
  button.html("Světlý mód");
  feedback.removeClass("light-mode-text");
  texts.removeClass("light-mode-text");

  setCookie("template", "light", "30", "/");
}
