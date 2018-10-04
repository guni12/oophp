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

Här är redovisningstexten



Kmom05
-------------------------

Här är redovisningstexten



Kmom06
-------------------------

Här är redovisningstexten



Kmom07-10
-------------------------

Här är redovisningstexten
