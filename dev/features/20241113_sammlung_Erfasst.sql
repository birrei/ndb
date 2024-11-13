
/*
Neues Feld: Sammlung "Erfasst" ja/nein. 

Es soll abfragbar sein, welche Sammlungen (fertig) erfasst sind. 

Hintergund: 
Manche Sammlungen (Musistücke/Sätze) sind - wissentlich - vorübergehend - (noch) unvollständig erfasst. 
Um diese Fälle später erkennen zu können, wird als  Workaround das Kürzel "XXX" im Titel verwendet. 
Diese Lösung ist auf Dauer unbefriedigend. 

Weiterer Nachteil: Die vorhandenenn Unvollständigkeits-Test geben zu viele Ergebniszeilen aus. 
Diejenigen Fälle, bei denen tatsächlich - versehentlich - etwas übersehen wurde, 
lassen sich daraus nicht systemisch abgrenzen . 

Nach Implementierung des Felds "Erfasst" sollen Tests/Datenprüfungen angepasst werden: 
Nur Sammlungen mit "Erfasst"=Ja abfragen

*/

ALTER TABLE sammlung DROP COLUMN IF EXISTS Erfasst
; 

ALTER TABLE `sammlung` ADD `Erfasst` BOOLEAN default false;  
; 

/*
show create table sammlung;

CREATE TABLE `sammlung` (
...
  `Erfasst` tinyint(1) DEFAULT 0,
... 
) 

Hinweis: boolean wird intern als tinyint gespeichert, aber: 
wg. readability / intention clearness wird bei gewollter ja/nein-Bedeutung 
trotzdem die Def. des bool(ean) als Datentyp empfohlen (im DDL-Code). 

*/


/*
Dateien anpassen: 

// - edit_sammlung.php 
// - cl_sammlung.php 
// - help_erfassung.php 
// - v_sammlung.sql


*/

update sammlung set Erfasst=1 where Name NOT LIKE '%XXX%' and Erfasst=0;

