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
            if ($_SERVER['DOCUMENT_ROOT'] == "C:/xampp/htdocs") {
                $this->document_root = $_SERVER['DOCUMENT_ROOT'] . "/Omega/";
                $this->document_root_url = "/Omega/";
                $this->db_server = "localhost";
                $this->db_name = "Aeternias";
                $this->db_user = "root";
                $this->db_password = "";
            }
            /* Pokud je projekt na serveru, nastaví se přístupy do databáze */
            if ($_SERVER['DOCUMENT_ROOT'] == "/3w/users/a/aeternias.cz/web/") {
                $this->document_root = $_SERVER['DOCUMENT_ROOT'] . "/";
                $this->document_root_url = "/";
                $this->db_server = "sql6.webzdarma.cz";
                $this->db_name = "aeterniascz9913";
                $this->db_user = "aeterniascz9913";
                $this->db_password = "StarClan1*";
            }
            /* Vrací pole údajů */
            $DBCl = new Database($this->db_server, $this->db_user, $this->db_password, $this->db_name);
            $this->database = $DBCl->get_instance();
        }
    }
}
