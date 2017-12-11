-----------------
1. Zadání
-----------------

1.1. Úvod:

1.1.0. Během uplynulého měsíce byl náš nevelký startup na výrobu hraček nové generace velmi oblíbený, a proto jsme se rozhodli pokračovat v práci na této myšlence. S rostoucím počtem zákazníků je potřeba poskytnout pohodlný způsob objednání zboží.

1.2. Konečný cíl / Požadavky:

1.2.0. Potřebujeme webovou stránku - integrální a nezávislé řešení, které bychom mohli hostit na našem serveru. Webová stránka splní následující cíle:

1.2.1. Možnost pro všechny uživatele zobrazit všechny informace o poskytovaných produktech, tedy:

1.2.1.1. Cena
1.2.1.2. Pokud je k dispozici (pokud produkt není k dispozici - stále je možnost prohlížet např. recenze a cenu)
1.2.1.3. hodnocení produktu (založeno na uživatelské zpětné vazbě)
1.2.1.4. uživatelské recenze produktu

1.2.2. Možnost registrace na strnánce pro následující:

1.2.2.1. Možnost objednání zboží
1.2.2.2. Možnost napsání recenze
1.2.2.3. Možnost smazání svého účtu

1.2.3. Kromě toho, pro úpravu údajů o produktech a uživatelích, bude vytvořena další webová stránka pro správce.

1.2.4. Softwarové prostředí:

1.2.4.1. Serverová část musí být v php. Podporovaná verze: >= 7.0
1.2.4.2. Webová stránka musí byt Single-Page-Application, být resposivní a správně zobrazená ve všech prohlížečích.
1.2.4.3. Design musí být intuitivní a user-friendly.

---------------------------
2. Implementace 
---------------------------

2.1. Frontend:

2.1.0. Frontendová část je realizovaná ve formě SinglePageApplication pomoci frameworku AngularJS verze 1.6.4.

2.1.1. Stránky: 

2.1.1.1. Hlavní stránka s krátkým popisem produktů, obrázky produktů apod. 
2.1.1.2. Stránka s detailním popisem produktu, recenzí. Umožňuje všem uživatelům přidávat produkty do nákupního koše a taky umožňuje přihlášeným uživatelům hodnotit produkt: psát recenze a vystavovat hodnocení od 1 do 5.
2.1.1.3. Stránka registrace nových uživatele. 

2.1.2. Ostatní:

2.1.2.1. Modální okno přihlášení uživatele.
2.1.2.2. V záhlaví stánky možnost odhlášení a smazání svého účtu.
2.1.2.3. Modální okno upozornění pří "nebezpečných operacích".
2.1.2.4. Zobrazení statusových hlášek v záhlaví stránky - success, warning nebo error

2.2. Backend:

2.2.0. Backendová část je realizovaná v PHP v. 7.0 bez využití dálích frameworků. 

2.2.1. Struktura:

2.2.1.0. PHP soubory jsou rozdělené do čtyřech složek: 

2.2.1.1. "classes" - třídy - obsahovou třídy produktů, klientů, recenze, uživatele a výjimek. 
2.2.1.2. "requests" - hlavní ovladače HTTP požadavků: jsou rozdělené do dvou kategorií: požadavků správce a uživatelů. Pak jsou rozdělené podle charakteru požadavku a jeho cíle.
2.2.1.3. "validators" - validace dat
2.2.1.4. "helpers" - pomocné metody, jako kontrola autorizace, loginu apod.

2.3. Uložiště dat

2.3.1. Data jsou uložená ve formatu .json, dle požadávku. 
2.3.2. Hesla jsou zakodováná pomocí password_hash() v řežimu PASSWORD_BCRYPT.
2.3.3. Databáze nebyla vytvořená.