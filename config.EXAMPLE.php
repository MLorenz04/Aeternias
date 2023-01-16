<?php
require_once "Components/Classes/Database.php";
if (!class_exists('Config')) {
    /**
     * Třída pro konfiguraci, řešení funkčnosti na localhostu a serveru
     * 
     * @author Matyáš Lorenz
     */
    class Config
    {
        private $document_root = "";
        private $document_root_url = "";
        private $db_name = "";
        private $db_user = "";
        private $db_password = "";
        private $db_server = "";
        private $database;
        private static $instance = null;

        /**
         * Získá pole s informaceni v konfiguraci
         * Singleton Pattern
         * 
         * @return self::$instance Pole konfigurace
         */

        function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = array(
                    'project_name' => 'Aeternias', //Jméno projektu
                    'root_path_require_once' => $this->document_root, //Root adresář
                    'root_path_url' => $this->document_root_url, //Protože nemůžeme přistupovat k souborům absolutní cestou na disku
                    'db' => $this->database //Připojení do databáze
                );
            }
                return self::$instance;
        }
        /**
         * Konstruktor na vytvoření a nastavení proměnných 
         * 
         *  Singleton Pattern
         */
        public function __construct()
        {
            /* Pokud na localhost */
            if ($_SERVER['DOCUMENT_ROOT'] == "SERVER_PATH") {
                $this->document_root = "PATH";
                $this->document_root_url = "PATH";
                $this->db_server = "DB_SERVER";
                $this->db_name = "DB_NAME";
                $this->db_user = "DB_USER";
                $this->db_password = "DB_PASSWORD";
            }
            /* Pokud je projekt na serveru, nastaví se přístupy do databáze */
            if ($_SERVER['DOCUMENT_ROOT'] == "LOCAL_PATH") {
                $this->document_root = "PATH";
                $this->document_root_url = "PATH";
                $this->db_server = "DB_SERVER";
                $this->db_name = "DB_NAME";
                $this->db_user = "DB_USER";
                $this->db_password = "DB_PASSWORD";
            }
            /* Vrací pole údajů */
            $DBCl = new Database($this->db_server, $this->db_user, $this->db_password, $this->db_name);
            $this->database = $DBCl->get_instance();
        }
    }
}