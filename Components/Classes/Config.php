<?php
require_once "Database.php";
if (!class_exists('Config')) {
    /**
     * Třída pro konfiguraci, řešení funkčnosti na localhostu a serveru
     * 
     * @author Matyáš Lorenz
     */
    class Config
    {
        private static $document_root = "";
        private static $document_root_url = "";
        private static $db_name = "";
        private static $db_user = "";
        private static $db_password = "";
        private static $db_server = "";
        private static $database;
        private static $instance = null;

        /**
         * Získá pole s informaceni v konfiguraci
         * Singleton Pattern
         * 
         * @return self::$instance Pole konfigurace
         */

        static function getInstance()
        {
            if (is_null(self::$instance)) {
                /* Pokud na localhost */
                if ($_SERVER['DOCUMENT_ROOT'] == "C:/xampp/htdocs") {
                    self::$document_root = $_SERVER['DOCUMENT_ROOT'] . "/Omega/";
                    self::$document_root_url = "/Omega/";
                    self::$db_server = "localhost";
                    self::$db_name = "Aeternias";
                    self::$db_user = "root";
                    self::$db_password = "";
                } else {
                    self::$document_root = $_SERVER['DOCUMENT_ROOT'] . "/";
                    self::$document_root_url = "/";
                    self::$db_server = "sql6.webzdarma.cz";
                    self::$db_name = "aeterniascz9913";
                    self::$db_user = "aeterniascz9913";
                    self::$db_password = "StarClan1*";
                }
                /* Vrací pole údajů */
                self::$database = Database::getInstance(self::$db_server, self::$db_user, self::$db_password, self::$db_name);
                self::$instance = array(
                    'project_name' => 'Aeternias', //Jméno projektu
                    'root_path_require_once' => self::$document_root, //Root adresář
                    'root_path_url' => self::$document_root_url, //Protože nemůžeme přistupovat k souborům absolutní cestou na disku
                    'db' => self::$database //Připojení do databáze
                );
            }
            return self::$instance;
        }
        /**
         * Konstruktor na vytvoření a nastavení proměnných 
         * 
         *  Singleton Pattern
         */
        private function __construct()
        {
        }
    }
}
