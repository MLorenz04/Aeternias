<?php
/* Konfigurační soubory */
$config = require "../../config.php";
/* Založení session */
session_start();
/* Security */ 
require $config["root"] . "Components/Security/security_functions.php";
/* Kontrola přihlášení  */
if (check_login() == False) {
  header("location: " . $config["root_url"] . "index.php");
  exit();
}
/* Require s ostatními requires */
require $config['root'] . "/Components/Helpers/php_header.php";
/* Proměnné */
$nickname = $_SESSION["username"];
?>
<main id="main" class="main wall_main">
   <div id="content">
      <div class="container px-4 pb-4">
         <h1 class="wall-header text-center"> Jednotky </h1>
         <p> Válečníci a jednotky jsou důležitou součástí každého světa. Díky nim se mohou odehrávat bitvy v jakémkoliv prostředí a umožní vám tak rozhodnout o výsledku.
            V následujících řádcích se dočtete o tom, jak si válečníka vytvořit, jaké hodnoty mu nastavit a jak poznat přesíleného bojovníka.
         </p>
         <h4> Jak tedy fungují? </h4>
         <p> Jednotky můžete vytvářet ve svém vlasntím světě. Aeternias nabízí na ukázku několik jednotek, které si můžete libovolně upravit a případně i smazat.
            Jakmile jednotku vytvoříte, uloží se pouze do vašeho světa. V záložce "Bitvy" ve vašem světě ji pak uvidíte při vybírání armády. <strong> Čím silnější jednotky budou, tím zvětšují šanci na výhru</strong> </p>
         <p> Jednotky mají několik atributů: <strong> Sílu</strong>, <strong>obranu</strong>, <strong> agilitu </strong> a <strong>typ útoku</strong>. Podle typu útoku můžete i dělit vojáky.
         <p> <strong> Síla </strong> indukuje obecnou sílu jednotky. Je základním údajem při výpočtu.
         <p> <strong> Obrana </strong> zvyšuje pravděpodobnost na přežití jednotky v souboji
         <p> <strong> Agilita </strong> představuje šanci, že se jednotka vyhne útoku.
            <li>
               <strong> Útok na blízko -> </strong>
               Kopiník, šermíř.
            </li>
            <li> <strong> Útok na dálku -> </strong>
               Lukostřelec, prakostřelec
            </li>
            <li> <strong> Útok pomocí magie -> </strong>
               Kouzelník, mág,
            </li>
            <li> <strong> Útok dělostřelectvem -> </strong>
               Houfnice, dělo, katapult
            </li>
         </ul>
         <p> Při vytváření jednotky je dobré si stanovit nějakého <strong>"Training Dummy"</strong>, například obyčejného banditu nebo vojáka s mečem. Teď si sami představte; kolik by jich byla vaše jednotka schopná zabít, než by sama zemřela? <br>
            <strong> Je dobré pracovat s více faktory</strong> a detailně vše promyslet; bude mág po použití magie rychle unavený? Jak dlouho se bude dělo nebo houfnice nabíjet, než ji na nějakou vzdálenost zničí? Dokáže lučištník vždy trefit svůj cíl?
         </p>
         <p> Při výběru obrany je zase dobré vzít si nějaké oblečení, třeba kroužkovaný kyrys, co na sobě váš Training dummy bude mít. Dokáže odrazit šípy? Projde skrze něj sečná či bodná rána? </p>
         <p> A výběr typu útoku je snad jasný. ;)
         <h5> Jak se ovšem počítá souboj? </h5>
         <p> Souboj jeden na jednoho je poměrně jednoduchý -> Čím je jedna postava silnější, tím větší má šanci na výhru. Ovšem ne vždy zvítězí jasně lepší jednotka.
            Momentálně se na principu boje ještě pracuje a bude těžké najít správný matematický algoritmus, který by toto řešil.
      </div>
   </div>
</main>

<?php
require "../Elements/footer.php";
/* Přesměrovávač na určité podstránky s pomocí Ajaxu */
require "../Helpers/redirectors.php";
?>