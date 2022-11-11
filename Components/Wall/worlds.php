<div class="container px-4 pb-4">
  <h1 class="text-center wall-header"> Světy </h1>
  <h3 class="text-center"> Vytvořte si svůj vlastní svět a generujte epické bitvy! </h3>
  <div class="container-worlds">
    <div class="card m-4" style="width: 18rem;">
      <div class="card-body body-add-world">
        <h5 class="card-title text-center">Vytvořit svět</h5>
        <i onclick="load_create_new_world()" class="bi bi-plus text-center d-flex justify-content-center" style="max-height:100px; font-size:6rem; color:#2d2d2d; cursor:pointer"></i>
      </div>
    </div>
    <?php
    /* Výpis všech uživatelových světů */
    require "./your_world.php";
    ?>
  </div>
</div>