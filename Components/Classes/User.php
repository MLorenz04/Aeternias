<?php 
if (!class_exists("User")) {
class User {
   private $id;
   private $username;
   private $dict = array();

   function __construct($id,$username) {
      $this->id = $id;
      $this->username = $username;
   }
   
   function get_id() {
      return $this->id;
   }
   function set_id($id) {
      $this->id = $id;
   }
   function get_username() {
      return $this->username;
   }
   function set_username($username) {
      $this->username = $username;
   }
   function get_permissions() {
      return $this->dict;
   }
   function set_permissions() {
      global $con;
      $sql = "select id_world, type_of_permission from permissions where id_owner = $this->id";
      $result = $con->query($sql);
      while($row = $result -> fetch_assoc()) {
         array_push($this->dict,$row['id_world'], $row['type_of_permission']);
      }
   }
}
}
