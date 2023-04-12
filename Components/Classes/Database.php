<?php
if (!class_exists("Database")) {
   class Database
   {
      public static $instance;
      public static $database;
      public static $db_server;
      public static $db_user;
      public static $db_password;
      public static $db_name;
      /**
       * Konstruktor
       */
      private function __construct() {
      }
      /**
       * Funkce, která vytvoří instanci třídy Database, ovšem nastaví $instance s připojením do ní pouze jednou
       */
      static function getInstance($db_server, $db_user, $db_password, $db_name)
      {
         self::$db_server = $db_server;
         self::$db_user = $db_user;
         self::$db_password = $db_password;
         self::$db_name = $db_name;
         if (is_null(self::$instance)) {
            self::$instance = new mysqli(self::$db_server, self::$db_user, self::$db_password, self::$db_name);
            return self::$instance;
         } else {
            return self::$instance;
         }
      }
   }
}
