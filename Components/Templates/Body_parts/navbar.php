<nav class="navbar navbar-expand-lg">
   <div class="container-fluid px-4">
      <a class="navbar-brand main-color navbar-link" href="<?php echo $config['root_path_url'] . "Components/Wall/wall.php" ?>" onclick="load_brief()"><?php echo $config['project_name'] ?> </a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">
            <li>
               <a class="nav-link sidebar-item navbar-link" onclick="show_feed()" data-toggle="modal" data-target="#exampleModal">
                  Feedback
               </a>
            </li>
         </ul>
      </div>
      <div>
         <a href="<?php echo $config["root_path_url"] ?>Components/Profile/Page/profile.php?id=<?php print($user->getId()) ?>"> <button class="btn btn-primary"> Profil </button> </a>
      </div>
   </div>
</nav>