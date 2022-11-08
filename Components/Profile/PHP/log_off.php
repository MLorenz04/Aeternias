<?php
session_start();
unset($_SESSION["is_logged"]);
session_destroy();
if(!(isset($_SESSION["is_logged"]))) { 
header("location: /Omega/index.php");
}
