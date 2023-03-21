<nav class="navbar navbar-expand-lg">
   <div class="container-fluid px-4">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand main-color navbar-link" href="<?php echo $config['root_path_url'] . "Components/Wall/wall.php" ?>" onclick="load_brief()"><?php echo $config['project_name'] ?> </a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">
            <li>
               <a class="nav-link sidebar-item navbar-link" onclick="show_feed()"data-toggle="modal" data-target="#exampleModal">
                  Feedback
               </a>
            </li>
         </ul>
      </div>
      <div>
         <button onclick="toggle_dark_mode()" id="dark-mode" class="btn btn-secondary"> Světlý mód</button>
         <a href="<?php echo $config['root_path_url'] . 'Components/Profile/Functions/log_off.php' ?>"> <button class="btn btn-primary navbar-link"> Odhlásit </button> </a>
      </div>
   </div>
</nav>