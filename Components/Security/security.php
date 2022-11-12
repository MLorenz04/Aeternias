<?php 
//Proměnné s regulérními výrazy 
$regex_registration_name = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů-]{5,20}$/";
$regex_registration_password =  "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-]{8,40}$/";
$regex_new_world_name = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-]{3,25}$/";
$regex_new_world_desc = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,\s]{20,500}$/";

/* Proměnné s chybovými hláškami */
$error_mess_register_name = "Jméno musí být v rozsahu 5-20 znaků!";
$error_mess_register_password = "Heslo musí být alespoň 8 znaků dlouhé!";
$error_mess_world_name = "Název vašeho světa musí být v rozsahu 3-25 znaků!";
$error_mess_world_desc = "Popis vašeho světa musí mín nejméně 15 znaků a mít nejvýše 500 znaků!";
$error_mess_existing_name = "Toto jméno je již zabráno, vyberte prosím jiné";
/* Proměnné s informačními hláškami */
$info_mess_success_register = "Váš účet byl úspěšně vytvořen!";
function prevent_sql_injection() {
   //Vyřešit, probrat s Mandíkem
}
?>