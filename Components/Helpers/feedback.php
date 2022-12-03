<?php
session_start();
$mess = wordwrap($_POST["message"], 70);
$nickname = $_SESSION["username"];
$result = mail("matyaslorenz@seznam.cz", "Feedback", $mess, $nickname);
if($result == true) {
   return true;
   exit();
} 
   return false;