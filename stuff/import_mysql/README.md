#  Migration Azure SQL DB -> MySQL 

## Export aus Azure SQL DB 
... (über SSMS Export-Funktion, Export zu Excel)

## Import per phpMyadmin 

Import der csv-Dateien über phpMyAdmin  
Tabelleninhalte prüfen (Korrekturen in Excel, z.T. falsche Struktur übertragen)
Tabellen umbenennen  

```
RENAME TABLE `TABLE 2` TO `Musikstueck`;   
RENAME TABLE `TABLE 3` TO `Komponist`;   
RENAME TABLE `TABLE 4` TO `Musikstueck_tmp`;   
RENAME TABLE `TABLE 5` TO `Sammlung`;   
RENAME TABLE `TABLE 6` TO `Satz`;   
RENAME TABLE `TABLE 7` TO `Verlag`;   
```

## IDs in Schlüssel-/IDENDITIY -Felder umwandeln 

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

## Tabelle musikstueck_tmp prüfen  
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

## Export als SQL (DDL und Inhalte)

Erzeugte Datei: dbs8693768.sql

##  Import localhost

XAMPP / MySQL, DB "test" -> dbs8693768.sql. Hat geklappt, allerdings sind die Tabellennamen nun alle klein geschrieben (z.B. Musikstueck -> musikstueck). Da die Kleinschreibung  empfohlen wird, lasse ich das so. 

##  Import Dev  (Web.de)
Datenbank-Namen anpassen: Anfangsbuchstaben klein 

## DEV: Korrekturen 
### Integration "Unbekannt" - Einträge 
Fehlende IDs 0 für "unbekannt" ergänzen 
Identity - Eintrag anschließend updaten 
```
insert into verlag (ID, Name, Bemerkung) values(0,"nv","falls unbekannt") 

```

Update "unbekannt"- Einträge auf ID=-1


### Fremdschlüssel-Einschänkungen definieren   
(ggf. Datentypen korrigieren)

1) Sammlung > Verlag
```
ALTER TABLE `sammlung` ADD  FOREIGN KEY (`VerlagID`) REFERENCES `verlag`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
```
2) Satz > Musikstueck  
```
ALTER TABLE `satz` ADD FOREIGN KEY (`MusikstueckID`) REFERENCES `musikstueck`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
```

3) Musikstueck > Komponist  
```
ALTER TABLE `musikstueck` ADD  FOREIGN KEY (`KomponistID`) REFERENCES `komponist`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
```


# Anhang 
## Abfragen 

```
-- sammlung ohne verlag 
select * 
from sammlung s 
left join verlag v on s.VerlagID = v.ID
where v.ID is null 

-- satz ohne musikstück  
select * 
from satz s 
left join musikstueck m 
on s.MusikstueckID = m.ID 
where m.ID is null 

-- musikstueck KonponistID nicht in komponist 
select * 
from musikstueck m 
left join komponist k 
on m.KomponistID = k.ID
where k.ID is null 



```









