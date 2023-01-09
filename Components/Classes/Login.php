<?php 

class User {
   private $id;
   private $username;

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
}
?>