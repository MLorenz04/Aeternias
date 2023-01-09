<?php
session_start();
$mess = wordwrap($_POST["message"], 70); 
$nickname = $_SESSION["logged_user"] -> get_user();
$result = mail("matyaslorenz@seznam.cz", "Feedback", $mess, $nickname);
if($result == true) {
   return true;
   exit();
} 
   return false;