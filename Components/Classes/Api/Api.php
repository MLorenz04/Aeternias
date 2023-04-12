<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
$env = "";
if ($_SERVER['DOCUMENT_ROOT'] == "C:/xampp/htdocs") {
   $env = "/Omega/";
}
require $_SERVER['DOCUMENT_ROOT'] . $env . "Components/Classes/Config.php";
require $_SERVER['DOCUMENT_ROOT'] . $env . "Components/Classes/Errors.php";
require $_SERVER['DOCUMENT_ROOT'] . $env . "Components/Classes/Security.php";
require $_SERVER['DOCUMENT_ROOT'] . $env . "Components/Classes/World.php";

/**
 * Odděděná třída API pro zpracování požadavků ohledně světa
 * @author Matyáš Lorenz
 * @extends Api
 */
class Api
{
   protected $api_token, $api_hash;
   protected $config;
   protected $errors;
   protected $user;
   protected $security;
   protected $using_website;
   /**
    * Konstruktor
    *
    * @return mixed $check_token True/False iformace, jsou-li potřeba ověřit uživatelovi API údaje
    */
   public function __construct($check_token)
   {
      $this->config = Config::getInstance();
      $this->errors = (new Errors(0))->getList();
      $this->security = (new Security());
      if ($check_token == true) {
         $this->check_api_tokens();
         $this->create_user();
      }
   }
   /** 
    * Metoda nastavující token uživateli
    *
    * @param mixed $token Token uživatele
    * @return info Informaci, zdali se podařilo nastavit
    */
   public function setToken($token)
   {
      return $this->api_token = $token;
   }
   /**
    * Metoda na získání uživatelova API tokenu
    * @return info Api token
    */
   public function getToken()
   {
      return $this->api_token;
   }
   /** 
    * Metoda nastavující hash uživateli
    *
    * @param mixed $hash hash uživatele
    * @return info Informaci, zdali se podařilo nastavit
    */
   public function setHash($hash)
   {
      return $this->api_hash = $hash;
   }
   /**
    * Metoda na získání uživatelova API hashe
    * @return info Api hash
    */
   public function getHash()
   {
      return $this->api_hash;
   }
   /**
    * Metoda přiražující z HTTP headeru Api token a Hash uživateli
    */
   public function check_api_tokens()
   {
      $headers = apache_request_headers();
      foreach ($headers as $header => $value) {
         if (strtolower($header) == "api-hash") $this->setHash($value);
         if (strtolower($header) == "api-token") $this->setToken($value);
      }
   }
   /**
    * Pomocná metoda na vytvoření objektu uživatele, který api využívá
    */
   public function create_user()
   {
      $sql = "select id from users where api_token = '" . $this->getToken() . "' and api_email = '" . $this->getHash() . "'";
      $result = $this->config["db"]->query($sql);
      if (mysqli_num_rows($result) > 0) {
         $row = $result->fetch_assoc();
         $u1 = new User($row['id']);
         $this->user = $u1;
      } else {
         $this->user = false;
      }
   }
   /**
    * Metoda na kontrolu uživatelova stavu
    * @return info True/False info, zdali je v pořádku, či ne
    */
   public function is_user_okay()
   {
      return ($this->user == false || $this->user = null) ? false : true;
   }
}

$a1 = new Api(true);
$a1->getToken();
