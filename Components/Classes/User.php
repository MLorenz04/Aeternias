<?php 
if (!class_exists("User")) {
class User {
   private $id;
   private $username;
   private $world_count;
   private $permissions = array();

   function __construct($id) {
      $this->id = $id;
      $this->username = $this->get_username_from_db();
      $this->world_count = $this->get_world_count();
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
   function get_username_from_db() {
      global $config;
      $con = $config["db"];
      $result = $con->query("select username from users where id=$this->id");
      $this->username = $result -> fetch_assoc();
   }

   function set_username($username) {
      $this->username = $username;
   }
   function get_permissions() {
      return $this->permissions;
   }
   function set_permissions() {
      global $config;
      $con = $config["db"];
      $sql = "select id_world, type_of_permission from permissions where id_owner = $this->id";
      $result = $con->query($sql);
      while($row = $result -> fetch_assoc()) {
         array_push($this->permissions,$row['id_world'], $row['type_of_permission']);
      }
   }
   function get_world_count() {
      global $config;
      $con = $config["db"];
      $sql = "select count(id) from world where id_owner = $this->id";
      $row = $con->query($sql)->fetch_row();
      $this->set_world_count($row[0]);
      return $this->world_count;
   }
   function set_world_count($count) {
      $this->world_count = $count;
   }
}
}
