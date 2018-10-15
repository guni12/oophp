---
title: "Redovisnings-sidan"
---
Redovisning
=========================



Kmom01 - Kmom03
-------------------------

Eftersom jag inte är säker på att kursen kommer att ingå eller bli rättad backar jag inte utan låter kmom 1 och 2 ingå under kmom3.

Jag har passat på att byta dator över sommaren och hoppa över cygwin. Jag har också php 7.2 istället för 5.6 nu, vilket ibland skickar nya felmeddelanden.

Det är riktigt bra att gå tillbaka till grunder då och då. Info som kan skickas med headern, eller läggas i session klarnade en del. Använda autoloader från scratch, se hur den letar upp aktuella filer, det är en stor hjälp.

Jag ville göra denna kurs därför att den så noggrant går igenom tester. Att ha testverktygen installerade i sin egen dator och i sina projekt är mycket intressant och kommer att hjälpa mig att bli lite mer professionell. Även att påminna mig om var "facit" finns och att verkligen gå till dessa sidor och kontrollera, t.ex. "Php the right way".

Jag valde att inte satsa så mycket på utseendet just nu, eftersom jag har gjort det mer i tidigare kurser. Den lilla styling jag gör går genom sass, så att jag nosar på den tekniken också.

Att skriva alla docBlock kommentarer kan kännas tidskrävande. Men jag har också märkt att det ställer krav på mig att veta vad varje funktion faktiskt gör och är till för. Vad är det för typ av variabel jag skickar. Fostrande och bra. Resultatet skulle vara enklare att läsa om inte alla felutskrifter kom med, `Warning: count(): Parameter...`.

UML är likaså fostrande. Jag fick tänka efter en extra gång om jag hade publika eller privata variabler, funktioner och vilka typer som funktionerna hanterar.

Eftersom jag gjort kurserna i lite egen ordning, Ramverk1 och Exjobb förra läsåret bl.a., var det mycket bra att få med sig denna kurs. Nu förstår jag bättre hur allt knyts ihop med namespaces inuti ramverket.

white/grey/black box testing: white box testas av utvecklare med t.ex. enhetstester, black box testas av oberoende testare utan kunskap om koden eller om kodning, grey box testing används som ett steg däremellan - för att se om de små enhetstesterna fungerar i interaktion med varandra t.ex.

Positive testing förväntar att testerna ska fungera, att rätt värden stoppas in i variablerna t.ex. Man testar olika möjliga och tillåtna inmatningar. Negative testing räknar med felinmatningar och förväntar felmeddelande eller att inmatningen inte går att göra.

Tärningsspelet var en ganska krävande uppgift för mig. Detta trots att vi redan gjort delar av den i kmom2. Jag gjorde först spelet med en tärning och inkluderade därefter den grafiska klassen och till sist tärningshands-klassen.

Som så ofta blev både mina funktioner och mina klasser för långa och jag fick jobba med att effektivisera koden. Jag ville använda sessions så den delen ligger kvar i routen, dvs `router\000_hundra.php`.

Man kan välja antal tärningar mellan 1 och 5 och för säkerhets skull gör man det i en `droplist`. De två spelarna, människa och dator, hanteras i klassen `Player` och de samlas i själva spelklassen `Hundred`. För att komma igång att spela måste man ange ett namn, men antal tärningar är default en stycken.

Med fem tärningar spelar datorn två rundor, med 3-4 tärningar spelar den 3 rundor och med 1-2 tärningar 5 rundor. Efter rundorna räknas poängen samman och läggs till totalen för datorn. Om en etta slås avslutas rundorna, inga poäng räknas och turen går över till den mänskliga spelaren som själv avgör hur många rundor hen gör. Vid vinst får man ett litet meddelande i röd text.

Jag har inte riktigt erövrat skillnaden mellan ternary operator och null coalescing operator. Den senare är kortare och ser mer effektiv ut, men visade sig inte göra som jag tänkt alla gånger, t.ex. om ingen inmatning görs i min droplist. Mer att lära!

Min kod har 100% kodtäckning och jag har jobbat en hel del med att förkorta funktionerna och göra dem något mer testbara. Men förbättringar här medförde försämringar där och jag är bara halvnöjd med resultatet. Med random variabler är det lite krångligt att testa överallt. Jag lade in fler getters än jag hade gjort utan testerna, men det blir ändå inte helt stabilt. Jag hoppas på det där att man lär sig skriva bättre för tester från början.






Kmom04
-------------------------

* Trait och Interface

`HistogramInterface` och `HistogramTrait` valde jag att knyta till `DiceHand`-klassen. Och histogramutskriften `histAsText()` fick ligga i `Hundred` eftersom jag ville ha koll på flera rundor av flera tärningar. Histogramfunktionen `getHistogramMax()` använder jag i spel-återkopplingen, bara för att ha med den någonstans.

Jag fick klura lite hur man får tillgång till sitt trait. Den egna klassen `Histogram` skulle jag antagligen inte gjort i mitt "normala" fall. Jag har en tendens att göra väldigt långa filer och klasser och behöver komma på hur jag lägger ut saker. Först lade jag funktionen `getHistogramMax()` i `DiceHand`-klassen. Och då kördes den mycket riktigt inte via ingående trait, vilket jag förstod genom phpunit-testerna.

* Hur gjorde du för att skapa intelligensen och taktiken till tärningsspelet?

Om datorn spelar fler tärningar gör den färre försök. Om medel av tärningsslagen i försöket är högre än 3.5 så nöjer den sig. Inte så avancerat, men datorn vinner över mig ibland med denna simpla algoritm.

Jag valde att stoppa in båda spelarna i sessionen och bygga på mitt system från tidigare kmom, dvs först skapas två `Player`-objekt och så initierar jag spelklassen `Hundred` med dessa. Slutligen lägger jag detta objekt i sessionen.

Spel-routen `hundred\player` kanske inte är optimal nu med så många variabler i sig. Å andra sidan är template-filerna mindre. Jag lade också till en klass för view `Formview`. För att skicka med variablerna dit för `form action` behöver anax-klasser injectas och jag misstänker att detta kommer i senare kursmoment.

Jag har haft oerhörd hjälp av att behålla Development-fliken i ramverket. Så smidigt att se vad som ligger i sessionen hela tiden på det sättet.

* Enhetstester och kodtäckning

Jag trodde att det skulle vara mer omfattande att uppdatera enhetstesterna än det visade sig vara. De allra flesta koderna fungerade forfarande och övriga krävde små förändringar. De nya histogram-funktionerna behövde förstås nya tester.

Integration av beroenden i testerna ser jag fram emot att erövra. Att testa olika scenarier behöver jag också förstå mer kring.

Jag har 100% kodtäckning, men min `Hundred` vill bli för lång. Jag gjorde en hjälpklass för att komma under 10 publika klasser. Till min förvåning behövde jag fortfarande inte ändra något i mina testklasser pga detta. Jag inser att strukturen kan bli renare och mer genomtänkt, men jag nöjer mig för nu. Och messdetectorn visar ok.








Kmom05
-------------------------

Detta kursmoment blev mycket omfattande för mig av olika skäl.

Först förstod jag bättre att utnyttja `$app` och fixa länkar utifrån `$app`. Ja att `$app` i princip är `$di`. Inte mycket behövde då vara kvar i route. Jag gjorde en ny klass och förlorade all testbarhet. Mina route-funktioner returnerade ju ingenting.

Till att börja med skickade jag med hela `$app` till olika funktioner, men fick bättre testbarhet när jag bytte till att bara skicka med `\Anax\Database\Database`.

Då och då behöver jag kontrollera superglobala variabler. Sebastian Bergmann och Stackoverflow hjälpte mig vidare:

* [https://github.com/sebastianbergmann/phpunit/issues/705](https://github.com/sebastianbergmann/phpunit/issues/705)
* [https://stackoverflow.com/questions/30123803/setting-post-for-filter-input-arrayinput-post-in-phpunit-test](https://stackoverflow.com/questions/30123803/setting-post-for-filter-input-arrayinput-post-in-phpunit-test)

Och en början till förståelse om mockobjekt har jag fått härifrån: [https://jtreminio.com/blog/unit-testing-tutorial-part-iv-mock-objects-stub-methods-and-dependency-injection/](https://jtreminio.com/blog/unit-testing-tutorial-part-iv-mock-objects-stub-methods-and-dependency-injection/)


`var_dump` på mock-objektet visar att det innehåller alla ursprungliga funktioner. Intressant och hjälper mig vidare. Den returnerar null och det gäller att tänka ut vad man vill testa egentligen. Här har jag mer att lära.

När jag skulle testa mina databas-funktioner uppträdde många problem med min utvecklingsmiljö. Jag hade nöjt mig med att ha xampp i windows-delen och inte installera klart apache i wsl-delen. Nu gjorde jag detta och fick en hel massa konflikter med dubbla processer.

Mödosamt lyckades jag få ordning på detta. Först fick jag döda apache-processen som jag inte riktigt nådde med `kill -9 $(pidof apache2)`

Ett nytt portnummer till phpmyadmin i xampp-delen fick jag hjälp med härifrån: [https://stackoverflow.com/questions/32173242/conflicting-ports-of-mysql-and-xampp](https://stackoverflow.com/questions/32173242/conflicting-ports-of-mysql-and-xampp)

Porten behövde sättas på flera ställen och det tog ett tag innan jag förstod var och hur.
`mysqld.exe: Table '.\mysql\user' is marked as crashed and should be repaired`

`As Apache port, we also can NOT change the MySQL port through the XAMPP Control Panel, to change it we have to edit MySQL configuration file.`

Jag behövde sätta porten i - `my.ini`

`xampp>phpMyAdmin config.inc.php $cfg['Servers'][$i]['host'] = '127.0.0.1:3307';`

och i `php.ini` `mysqli.default_port=3307`

Härefter kunde jag ändå inte nå mysql: 

`SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it.`

Inget svar fanns i `mysql_error.log`

Slutligen behövde jag ha porten med i dsn-variablerna också: 

`"dsn" => "mysql:host=127.0.0.1;`<span class ="red">`port=3307;`</span>`dbname=oophp;"`, och Voila!

Hädanefter måste jag komma ihåg detta!!!

Det positiva med detta är att jag nu har två operativ-system i ett, mer fullt ut. Jag bytte port på localhost i wsl också och kan verkligen kolla utfall i båda varianterna. Riktigt bra!


Jag har lagt mitt huvudfokus på testning eftersom jag vill försöka bli bättre på dessa. Mitt tärningsspel har drygt 98% kodtäckning och det är en if-sats som förstör alltihop.

`if ($average > 3.5 && $this->dices > 2)` är svår att kontrollera och går igenom ibland och blir rött ibland. Jag har inte kommit på lösningen med den trots

* [https://stackoverflow.com/questions/18741147/how-to-unit-test-function-with-some-randomness](https://stackoverflow.com/questions/18741147/how-to-unit-test-function-with-some-randomness)
* [https://softwareengineering.stackexchange.com/questions/147134/how-should-i-test-randomness](https://softwareengineering.stackexchange.com/questions/147134/how-should-i-test-randomness)
* [https://media.readthedocs.org/pdf/phpunit/latest/phpunit.pdf](https://media.readthedocs.org/pdf/phpunit/latest/phpunit.pdf)

Vid databastesningen märkte jag att sqlite inte gillar autoincrement, därför fick jag ha olika sql-inmatning för att skapa tabellerna. Efter tilldelning av rättigheter till databas test med test/test så fungerar phpunit lokalt också på mysql, men jag väljer sqlite som standard. Mysql-alternativet finns med i testfilerna, fast avmarkerat.

Lokal mysql-adress för mig är: `$mysql  = "c:/xampp/mysql/bin/mysql.exe";`

För att kunna reset-a databasen lokalt behövde jag åter se till att portnumret skickades med

`--host=127.0.0.1 --port=3307`

Jag försökte förstå att rendera config-filen för databas-inlogg etc, men hittade inga publika getters för detta. För att ha tillgång till uppgifterna lade jag dem nu i functions.php, fast en liten sidofil som jag kallar för `secret.php` och som jag hoppas inte skickas med till github.

Det blir felmeddelande i mitt fall - `exit status 127` om jag inte ställer om till unix vid reset test. Jag gjorde en funktion för detta:

`isUnix() ? "/usr/bin/mysql" : "c:/xampp/mysql/bin/mysql.exe";`

Sass väljer att ha två stegs indentering, vilket stylelint klagade på. Jag har mycket lite style så det gick att rätta med `replace`, men jag tror jag framöver kommer att stå fast vid less.

Publiceringen till skolans server gav mig problem med `Disk quota exceeded (122)`, men det finns en bra tråd för detta på forumet.

Efter att ha gjort en routefil `movie.php` som ligger under `/route` så testade jag att göra en `MovieController`. Variadic-funktionen förenklar mycket. Däremot har jag inte kommit på hur jag ska testa denna klass ännu. Det är mitt sätt att skicka med mockade klasser som inte stämmer: `Trying to get property of non-object`, så jag hoppar över den just nu. Övriga movie-klasser har 100% täckning, men denna drar ner siffrorna.

<h5>Min implementation</h5>


Förutom grundfunktionerna kan man återställa databasen. På studentservern lyckades jag inte göra det via kommando. Jag vet inte om det är tänkt att man ska kunna göra det utan att vara root. Men jag hittade inte heller rätt sökväg till mysql där. Istället har jag gjort en serie vanliga sql-frågor till databasen som läses ifrån en fil. (Och för att dessa ska fungera med testning har jag gjort en egen fil till min sqlite::memory.)

Sortering och paginering finns också, liksom cimage. Däremot har jag hoppat över login-funktioner eftersom jag gjort sådana i andra kursmoment. Och återkommer kanske till detta i slutuppgiften.


Kmom06
-------------------------

Här är redovisningstexten



Kmom07-10
-------------------------

Här är redovisningstexten
