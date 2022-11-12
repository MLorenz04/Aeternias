<?php
/* Konfigurační soubory */
$config = require "../../config.php";
/* Založení session */
session_start();
/* Proměnné */
$nickname = $_SESSION["username"];
/* Kontrola přihlášení */
require "../Security/check_login.php";
/* Hlavička */
require "../Elements/head.php";
?>

<nav class="navbar navbar-expand-lg bg-light">
   <div class="container-fluid">
      <i class="bi bi-list toggle-sidebar-btn ham-menu px-4"></i>
      <a class="navbar-brand main-color" href="#" onclick="load_brief()"><?php echo $config["project_name"] ?> </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
         </ul>
         <p class="link-dark navbar-text m-0 p-0 px-2 "> <a class="text-decoration-none" href="./profile?username=<?php echo $nickname ?>"> <?php echo $nickname ?> </a></p>
         <a href="../Profile/PHP/log_off.php"> <button class=" mx-2 btn btn-primary"> Odhlásit </button> </a>
      </div>
   </div>
</nav>
<aside>
   <div class="sidebar">
      <ul class="sidebar-nav px-0">
         <li class="nav-item p-1">
            <a class="nav-link sidebar-item align-items-center" href="#info" onclick="load_help()"><i class="bi bi-info-circle"></i><span> Informace </span></a>
         </li>
         <li class="nav-item p-1">
            <a class="nav-link sidebar-item align-items-center" href="#worlds" onclick="load_worlds()"><i class="bi bi-globe2"></i><span> Světy </span></a>
         </li>
         <li class="nav-item p-1">
            <a class="nav-link sidebar-item align-items-center" href="#warriors" onclick="load_warriors()"><i class="bi bi-diagram-3"></i><span> Jednotky </span></a>
         </li>
         <li class="nav-item p-1">
            <a class="nav-link sidebar-item align-items-center" href="#tutorials" onclick="load_tutorial()"><i class="bi bi-question-circle"></i><span> Návody </span></a>
         </li>
      </ul>
   </div>
</aside>
<main id="main" class="main wall_main">
   <div id="content">
      <?php
      require "./brief_wall.php";
      ?>
   </div>
</main>

<?php
require "../Elements/footer.php";
/* Přesměrovávač na určité podstránky s pomocí Ajaxu */
require "../Helpers/redirectors.php";
?>