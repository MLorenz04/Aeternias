<nav class="navbar navbar-expand-lg navbar-light bg-light">
   <div class="container-fluid px-4">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand main-color" href="<?php echo $config['root_url'] . "Components/Wall/wall.php" ?>" onclick="load_brief()"><?php echo $config["project_name"] ?> </a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">
            <a class="nav-link sidebar-item" data-toggle="modal" data-target="#exampleModal">
               Feedback
            </a>
         </ul>
      </div>
      <div>
         <a href="<?php echo $config["root_url"] . 'Components/Profile/PHP/log_off.php' ?>"> <button class="btn btn-primary"> Odhlásit </button> </a>
      </div>
   </div>
</nav>