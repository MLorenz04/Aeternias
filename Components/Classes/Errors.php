<?php
if (!class_exists("Errors")) {
   class Errors
   {
      private $error_message = "";
      private $error_header = "";
      private $code_of_error = "";
      private $list = [
         "error_page_error" => array('error_id' => 0, 'error_name' => 'Chyba stránky na stránky', 'error_desc' => 'Podařilo se vám rozbít stránku na chyby!', 'code_of_error' => 404),
         "permissions" => array('error_id' => 1, 'error_name' => 'Chybějí vám pravomoce', 'error_desc' => 'K tomé části stránky nemáte přístup!', 'code_of_error' => 403),
         "non_existing_world" => array('error_id' => 2,  'error_name' => 'Neexistující svět', 'error_desc' => 'Tento svět neexistuje! Nejspíše byl tento svět smazán.', 'code_of_error' => 404),
         "error_no_world_id" => array('error_id' => 3, 'error_name' => 'Není poznat, v jakém jste světě', 'error_desc' => 'Ve vaší adrese bohužel není zadán svět, do kterého byste rádi. <br>', 'code_of_error' => 404)
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
      public function getInstance()
      {
         return $this;
      }
      public function getErrorMessage()
      {
         return $this->error_message;
      }
      public function getErrorHeader()
      {
         return $this->error_header;
      }
      public function getCodeOfError()
      {
         return $this->code_of_error;
      }
   }
}
