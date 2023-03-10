<?php

function get_id_by_name($username)
{
   global $con;
   /* SQL příkazy */
   $sql = "select id from user where username = '$username'";
   $result = $con->query($sql);
   while ($row = $result->fetch_assoc()) {
      return $result['id'];  //Vrácení id
   }
}