<?php
require "prepare_battle.php";
$battle = new Battle($a1, $a2, $slug, $id_world, $id);
$battle->start_battle();
