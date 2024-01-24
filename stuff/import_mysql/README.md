# Import per phpMyadmin 

Import der csv-Dateien über phpMyAdmin, Tabellen umbenennen  

```
RENAME TABLE `TABLE 2` TO `Musikstueck`;   
RENAME TABLE `TABLE 3` TO `Komponist`;   
RENAME TABLE `TABLE 4` TO `Musikstueck_tmp`;   
RENAME TABLE `TABLE 5` TO `Sammlung`;   
RENAME TABLE `TABLE 6` TO `Satz`;   
RENAME TABLE `TABLE 7` TO `Verlag`;   
```

# IDs in Schlüssel- und Idendity-Felder umwandeln 

```
ALTER TABLE `Komponist` 
  CHANGE `ID` `ID` INT unsigned NOT NULL AUTO_INCREMENT, 
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `Musikstueck` 
  CHANGE `ID` `ID` INT unsigned NOT NULL AUTO_INCREMENT, 
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `Sammlung` 
  CHANGE `ID` `ID` INT unsigned NOT NULL AUTO_INCREMENT, 
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `Satz` 
  CHANGE `ID` `ID` INT unsigned NOT NULL AUTO_INCREMENT, 
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `Verlag` 
  CHANGE `ID` `ID` INT unsigned NOT NULL AUTO_INCREMENT, 
  ADD PRIMARY KEY (`ID`);

```

# Inhalte prüfen 
```
 -- Prüfen: ist Inhalt von Tabelle Musikstueck_tmp bereits in Tabelle Musikstueck erfasst?  
 select * 
from Musikstueck_tmp mt
left join 
 ( 
    select k.Nachname Komponist_Name, m.Name as Musikstueck_Name 
    from Musikstueck m left join Komponist k on m.KomponistID = k.ID
   -- where k.Nachname	 like "%Bois%"
  ) km
  
on mt.Titel like concat("%", km.Komponist_Name, "%") 
  and mt.Titel like concat("%", km.Musikstueck_Name, "%") 
    
-- where mt.Titel like "%Bois%"

```

# Export als SQL (DDL und Inhalte)

Erzeugte Datei: dbs8693768.sql

# Import localhost

XAMPP / MySQL, DB "test" -> dbs8693768.sql. Hat geklappt, allerdings sind die Tabellennamen nun alle klein geschreiben (z.B. Musikstueck -> musikstueck). Da die Kleinschreibung allgemein empfohlen wird, lasse ich das so. 


# Import Dev DB
Entsprechend des lokalen Imports -> Datenbank-Namen anpassen: Anfangsbuchstaben klein 





