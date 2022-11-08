<?php 
if(!(isset($_SESSION["is_logged"]))) {
   header("location: /Omega/index.php");
}
?>