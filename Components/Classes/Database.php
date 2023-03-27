<?php
if (!class_exists("Database")) {
   class Database
   {
      public static $instance;
      public $database;
      public $db_server;
      public $db_user;
      public $db_password;
      public $db_name;
      /**
       * Konstruktor
       */
      function __construct($db_server, $db_user, $db_password, $db_name)
      {
         $this->db_server = $db_server;
         $this->db_user = $db_user;
         $this->db_password = $db_password;
         $this->db_name = $db_name;
      }
      /**
       * Funkce, která vytvoří instanci třídy Database, ovšem nastaví $instance s připojením do ní pouze jednou
       */
      function get_instance()
      {
         if (is_null(self::$instance)) {
            self::$instance = new mysqli($this->db_server, $this->db_user, $this->db_password, $this->db_name);
            return self::$instance;
         } else {
            return self::$instance;
         }
      }
   }
}
