<?php
session_start();
$mess = wordwrap($_POST["message"], 70);
$email = $_POST["email"];
$nickname = $_POST["username"];
$result = mail("matyaslorenz@seznam.cz", "Feedback", $mess, $email);
if($result == true) {
   return true;
   exit();
} 
   return false;