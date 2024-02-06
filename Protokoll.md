# Protokoll 
Änderungenerfordenisse, die sich aus Erfassungssitzungen ergeben haben. 

## Dezember 2023 - Neue Spalte "JahrAuffuehrung"
Neue Spalte "musikstueck.JahrAuffuehrung". Datentyp integer in der Annahme, dass der Inhalt "Jahre letzte Aufführung" bedeuten soll.  


## 02.02.2023, 06.02.2024 - Termin mit AG, Umsetzung Änderungswünsche (dev)
 * Die Spalte Spalte "musikstueck.JahrAuffuehrung" soll mehrere "Aufführungsjahre" aufnehmen können. Vorläufige Lösung: zu varchar ändern.

 * Besetzung - Eigenschaften müssen einzeln filterbar sein. Umsetzung eingeplant 

## 03.02. Umsetzung Korrekturen 
 s.a. ..\ddl\updates\20240203_korrekturen.sql (auf prod schon erledigt)

## ab 03.02. Umsetzung Musikstück / Besetzung dev 
\ddl\updates\20240203_musikstueck_zu_besetzung.sql 

## Planung 
* demo aus prod erneuern 
* Test Updates auf Demo 
* Info AG, Planung für Termin 

