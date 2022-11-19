<?php
/* Konfigurační soubor */

/* Pokud je projekt na mém localhostu, tak se nastaví proměnné podle mého vývoje */
$document_root = $document_root_url = $db_name = $db_user = $db_password = $db_server = "";
if($_SERVER['DOCUMENT_ROOT'] == "C:/xampp/htdocs") {
    $document_root = $_SERVER["DOCUMENT_ROOT"] . "/Omega/";
    $document_root_url = "/Omega/";
    $db_server = "localhost";
    $db_name = "Aeternias";
    $db_user = "root";
    $db_password = "";
}
/* Pokud je projekt na serveru, nastaví se přístupy do databáze */
if($_SERVER["DOCUMENT_ROOT"] == "/3w/users/a/aeternias.cz/web/") {
    $document_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    $document_root_url = "/";
    $db_server = "sql6.webzdarma.cz";
    $db_name = "aeterniascz9913";
    $db_user = "aeterniascz9913";
    $db_password = "StarClan1*";
}

return array(
    'project_name' => 'Aeternias', //Jméno projektu
    'root' => $document_root, //Root adresář
    'root_url' => $document_root_url, //Protože nemůžeme přistupovat k souborům absolutní cestou na disku
    'db' => new mysqli($db_server, $db_user, $db_password, $db_name) //Připojení do databáze
);
?>