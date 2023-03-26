<?php
if (!class_exists("Errors")) {
   class Errors
   {
      private $error_message = "";
      private $error_header = "";
      private $code_of_error = "";
      private $list = [
         "error_page" => array('error_id' => -1, 'error_name' => 'Chyba stránky na stránky', 'error_desc' => 'Podařilo se vám rozbít stránku na chyby!', 'code_of_error' => 404),
         "permissions" => array('error_id' => 1, 'error_name' => 'Chybějí vám pravomoce', 'error_desc' => 'K tomé části stránky nemáte přístup!', 'code_of_error' => 403),
         "non_existing_world" => array('error_id' => 2,  'error_name' => 'Neexistující svět', 'error_desc' => 'Tento svět neexistuje! Nejspíše byl tento svět smazán.', 'code_of_error' => 404),
         "error_no_world_id" => array('error_id' => 3, 'error_name' => 'Není poznat, v jakém jste světě', 'error_desc' => 'Ve vaší adrese bohužel není zadán svět, do kterého byste rádi. <br>', 'code_of_error' => 404)
      ];
      private $list_error_messages = array(
         //Proměnné s regulérními výrazy 
         "regex_registration_name" => "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů-]{5,20}$/",
         "regex_registration_password" =>  "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-]{8,40}$/",
         "regex_new_world_name" => "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-,\s]{3,25}$/",
         "regex_new_world_desc" => "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,\s]{5,500}$/",
         "regex_new_warrior_name" => "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-,\s]{3,40}$/",
         "regex_new_warrior_desc" => "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-,\s]{5,500}$/",
         /* Proměnné s chybovými hláškami */
         "error_what_happened" => "Něco se pokazilo! Chyba byla odeslána administrátorům, kteří ji prověří a opraví. Omlouváme se za komplikace.",
         "error_mess_register_name" => "Jméno musí být v rozsahu 5-20 znaků!",
         "error_mess_register_password" => "Heslo musí být alespoň 8 znaků dlouhé!",
         "error_mess_world_name" => "Název vašeho světa musí být v rozsahu 3-25 znaků!",
         "error_mess_world_desc" => "Popis vašeho světa musí mín nejméně 5 znaků a mít nejvýše 500 znaků!",
         "error_mess_existing_name" => "Toto jméno je již zabráno, vyberte prosím jiné",
         "error_mess_new_warrior_name" => "Jméno tohoto válečníka je moc krátké či dlouhé",
         "error_mess_new_warrior_desc" => "Popisek této jednotky je moc krátký či dlouhý",
         "error_mess_new_warrior_number" => "Zadal jste hodnotu útoku, obrany či agility zápornou",
         "error_mess_no_permission" => "K této akci nemáte pravomoce",
         "error_mess_max_world_count" => "Již máte maximální počet světů!",
         "error_mess_no_input_new_warrior" => "Nezadal jste jeden z parametrů válečníka.",
         "error_mess_existing_warrior" => "Válečník s tímto jménem již existuje",
         "error_mess_name_exists" => "Válečníka s tímto jménem jste už vytvořil",
         "error_mess_new_warrior_health" => "Zdraví válečníka nemůže být záporné či nula!",
         /* Api */
         "error_api_permission" => "Na toto nemáte oprávnění!",
         /* Proměnné s informačními hláškami */
         "info_mess_success_register" => "Váš účet byl úspěšně vytvořen!",
         "info_mess_success_warrior_creation" => "Vaše jednotka byla úspěšně vytvořena!"
      );

      public function __construct($id)
      {
         if ($id != 0) {
            foreach ($this->list as $errors) {
               if ($errors["error_id"] == $id) {
                  $this->error_message = $errors["error_desc"];
                  $this->error_header = $errors["error_name"];
                  $this->code_of_error = $errors['code_of_error'];
               }
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
      public function getList()
      {
         return $this->list_error_messages;
      }
      public function setList($list_error_messages)
      {
         return $this->list_error_messages = $list_error_messages;
      }
   }
}
