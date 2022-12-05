<?php 
//Proměnné s regulérními výrazy 
$regex_registration_name = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů-]{5,20}$/";
$regex_registration_password =  "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-]{8,40}$/";
$regex_new_world_name = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-,\s]{3,25}$/";
$regex_new_world_desc = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,\s]{5,500}$/";
$regex_new_warrior_name = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,-,\s]{3,20}$/";
$regex_new_warrior_desc = "/^[a-zA-z0-9+,ě,š,č,ř,ž,ý,á,í,é,ů,ú,Ě,Š,Č,Ř,Ž,Ý,Á,Í,É,Ú,Ů,!,*,\s]{5,500}$/";
/* Proměnné s chybovými hláškami */
$error_what_happened = "Něco se pokazilo! Chyba byla odeslána administrátorům, kteří ji prověří a opraví. Omlouváme se za komplikace.";
$error_mess_register_name = "Jméno musí být v rozsahu 5-20 znaků!";
$error_mess_register_password = "Heslo musí být alespoň 8 znaků dlouhé!";
$error_mess_world_name = "Název vašeho světa musí být v rozsahu 3-25 znaků!";
$error_mess_world_desc = "Popis vašeho světa musí mín nejméně 5 znaků a mít nejvýše 500 znaků!";
$error_mess_existing_name = "Toto jméno je již zabráno, vyberte prosím jiné";
$error_mess_new_warrior_name = "Jméno tohoto válečníka je moc krátké či dlouhé";
$error_mess_new_warrior_desc = "Popisek této jednotky je moc krátký či dlouhý";
$error_mess_new_warrior_number = "Zadal jste hodnotu útoku, obrany či agility zápornou";
$error_mess_no_permission = "K této akci nemáte pravomoce";
/* Proměnné s informačními hláškami */
$info_mess_success_register = "Váš účet byl úspěšně vytvořen!";
$info_mess_success_warrior_creation = "Vaše jednotka byla úspěšně vytvořena!";
