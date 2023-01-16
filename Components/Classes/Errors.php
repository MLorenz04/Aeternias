<?php
if (!class_exists("Errors")) {
   class Errors
   {
      private $error_message = "";
      private $error_header = "";
      private $code_of_error = "";
      private $list = [
         "permissions" => array('error_id' => 1, 'error_name' => 'Chybějí vám pravomoce', 'error_desc' => 'K tomé části stránky nemáte přístup!', 'code_of_error' => 403),
         "non_existing_world" => array('error_id' => 2,  'error_name' => 'Neexistující svět', 'error_desc' => 'Tento svět neexistuje! Nejspíše byl tento svět smazán.', 'code_of_error' => 404)
      ];
      public function __construct($id)
      {
         foreach ($this->list as $errors) {
            if ($errors["error_id"] == $id) {
               $this->error_message = $errors["error_desc"];
               $this->error_header = $errors["error_name"];
               $this->code_of_error = $errors['code_of_error'];
            }
         }
      }
      public function get_instance()
      {
         return $this;
      }
      public function get_error_message()
      {
         return $this->error_message;
      }
      public function get_error_header()
      {
         return $this->error_header;
      }
      public function get_code_of_error()
      {
         return $this->code_of_error;
      }
   }
}