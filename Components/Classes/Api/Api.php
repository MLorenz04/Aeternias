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

class Api
{
   protected $api_token, $api_hash;
   protected $config;
   protected $errors;
   protected $user;
   protected $security;
   protected $using_website;
   public function __construct($check_token)
   {
      $this->config = (new Config())->get_instance();
      $this->errors = (new Errors(0))->getList();
      $this->security = (new Security());
      if ($check_token == true) {
         $this->check_api_tokens();
         $this->create_user();
      }
      (isset($_SESSION["logged_user"])) ? $this->using_website = true : $this->using_website = false;
   }

   public function isUsingWebsite()
   {
      return $this->using_website;
   }

   public function setToken($token)
   {
      return $this->api_token = $token;
   }

   public function getToken()
   {
      return $this->api_token;
   }

   public function setHash($hash)
   {
      return $this->api_hash = $hash;
   }
   public function getHash()
   {
      return $this->api_hash;
   }

   public function check_api_tokens()
   {
      $headers = apache_request_headers();
      foreach ($headers as $header => $value) {
         if (strtolower($header) == "api-hash" ) $this->setHash($value);
         if (strtolower($header) == "api-token" ) $this->setToken($value);
      }
   }
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
   public function is_user_okay()
   {
      if ($this->user == false || $this->user = null) {
         return false;
      }
      return true;
   }
}

$a1 = new Api(true);
$a1->getToken();
