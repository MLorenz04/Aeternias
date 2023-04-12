<?php
/* Konfigurační soubory */
require_once "../Classes/Config.php";
$config = Config::getInstance();
/* Celá hlavička */
require_once $config['root_path_require_once'] . "/Components/Templates/Body_parts/normal_header.php";
?>
<main id="main" class="main wall_main">
   <div id="content">
      <div class="container px-4 pb-4">
         <h1 class="text-center wall-header"> Restapi </h1>
         <h3 class="text-center"> Pomocník k vytváření aplikací </h3>
         <hr>
         <p>
            Restapi umožňuje vývojářům využívat HTTP request metody GET, POST, PUT a DELETE k zacházení s obsahem vašich profilů.
            Pokud jste tedy vývojář, v následujících krocích vám ukážeme, jak s Restapi pracovat.
         </p>
         <p> Jako první bude důležité získat vaše údaje k <b>restapi</b>. Ty můžete najít na vašem profilu.
            <b> Tyto údaje jsou velmi citlivé! Nikomu je nesvěřujte! </b>
            Zde najdete dva údaje - Api-hash a Api-token.
         </p>
         <p> Jakmile budete dělat HTTP požadavek na stránku, kterou potřebujete, ujistěte se, že tyto dvě proměnné vkládáte do hlavičky requestu! </p>
         <div class="container-img">
            <img src="<?php echo $config['root_path_url'] ?>Source/IMG/Api.png">
         </div>
         <p> Následující příklady mají vždy nadpis metody. <b> Ten je důležité použít! </b> Pokud použijete metodu GET na vytvoření, POST na získání či DELETE na úpravu, nikdy se vám nepodaří požadavek vykonat </p>
         <hr>
         <section id="warriors">
            <h2> Válečníci </h2>
            <hr>
            <h3> GET </h3>
            <p> Získá válečníky podle id světa
            <p> <strong> /Restapi/v1/warriors/&ltid-světa&gt </strong> </p>
            <h3> POST </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Vytváření válečníka. Jde dvěma způsoby - bez popisku i s popiskem
            <p> S popiskem: <strong> /Restapi/v1/warriors/&ltjméno&gt/&ltpopisek&gt/&ltútok&gt/&ltobrana&gt/&ltagility&gt/&ltzdraví&gt </strong> </p>
            <p> Bez popisku: <strong> /Restapi/v1/warriors/&ltjméno&gt/&ltútok&gt/&ltobrana&gt/&ltagility&gt/&ltzdraví&gt </strong> </p>
            <h3> PUT </h3>
            <p> V přípravě </p>
            <h3> DELETE </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Smaže válečníka ze světa </p>
            <p> /Restapi/v1/warriors/&ltid-světa&gt/&ltid-válečníka&gt </p>
            <hr>
         </section>
         <section id="users">
            <h2> Uživatelé </h2>
            <hr>
            <h3> GET </h3>
            <p> V přípravě </p>
            <h3> POST </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Vytváření uživatele </p>
            <p> <strong> /Restapi/v1/users/&ltjméno&gt/&ltemail&gt/&ltheslo&gt</strong> </p>
            <h3> PUT </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Úprava uživatelských údajů. Momentálně není dokonalá, jsou potřeba všechny údaje. </p>
            <p> S heslem: <strong> /Restapi/v1/users/&ltid&gt/&ltjméno&gt/&ltemail&gt/&ltheslo&gt/ </strong> </p>
            <p> Bez hesla: <strong> /Restapi/v1/users/&ltid&gt/&ltjméno&gt/&ltemail&gt </strong> </p>
            <h3> DELETE </h3>
            <p> V přípravě </p>
            <hr>
         </section>
         <section id="permissions">
            <h2> Pravomoce </h2>
            <hr>
            <h3> GET </h3>
            <p> Zjistí, jestli uživatel pravomoce má, nebo je nemá
            <p> <strong> /Restapi/v1/permissions/&ltid-světa&gt/&ltid-uživatele&gt </strong> </p>
            <h3> POST </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Přidá uživateli pravomoce </p>
            <p> <strong> /Restapi/v1/permissions/&ltid-světa&gt/&ltjméno-uživatele&gt </strong> </p>
            <h3> PUT </h3>
            <p> V přípravě </p>
            <h3> DELETE </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Odebere pravomoce uživateli </p>
            <p> <strong> /Restapi/v1/permissions/&ltid-světa&gt/&ltid-uživatele&gt </strong> </p>
         <hr>
         </section>
         <section id="world">
            <h2> Svět </h2>
            <hr>
            <h3> GET </h3>
            <p> Aktuálně jen vrácení obecné informace o všech existujících světěch. Plánuje se přidat pro jednotlivý svět </p>
            <p> <strong> /Restapi/v1/worlds </strong> </p>
            <h3> POST </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Přidání světa </p>
            <p> <strong> /Restapi/v1/worlds/&ltnázev-světa&gt/&ltpopis-světa&gt </strong> </p>
            <h3> PUT </h3>
            <p> V přípravě </p>
            <h3> DELETE </h3>
            <p class="text-danger"> Pouze pro přihlášené uživatele pomocí Api-tokenu a Api-hashe
            <p> Odebrání světa </p>
            <p> <strong> /Restapi/v1/permissions/&ltid-světa&gt </strong> </p>
         </section>
      </div>
   </div>
</main>
<?php
require_once $config['root_path_require_once'] . "Components/Templates/Body_parts/footer.php";
?>