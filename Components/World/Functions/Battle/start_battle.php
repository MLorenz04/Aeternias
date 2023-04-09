<?php
require "prepare_battle.php";
$battle = new Battle($a1, $a2, $slug, $id_world, $id);
?>
<pre> 
<?php
$battle->start_battle();
?>
</pre>