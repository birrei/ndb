/* 
Anforderung: Eigenschaften müssen einzeln filterbar sein. Einem Musikstück müssen mehrere Besetzungen zuordenbar sein 
-> Neue Tabellen "besetzung", "musikstueck_besetzung"   
*/

/* Tabelle "besetzung" */

CREATE TABLE besetzung  
	(`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT 
     , Name VARCHAR(100) NOT NULL 
     , PRIMARY KEY (`ID`)
    )
    ENGINE = InnoDB; 

/* Tabelle "musikstueck_besetzung" (Verknüpfungstabelle zwischen musikstueck und besetzung) */ 

CREATE TABLE `musikstueck_besetzung` 
   (`MusikstueckID` int(11) UNSIGNED  NOT NULL 
   , `BesetzungID` int(11) UNSIGNED  NOT NULL 
   ) 
   ENGINE = InnoDB;

ALTER TABLE `musikstueck_besetzung` ADD PRIMARY KEY(`MusikstueckID`, `BesetzungID`);


/* Befüllung der Tabelle Besetzung (aus den Inhalten von Spalte musikstueck.Besetzung) 
Geprüft: Im Feld "Besetzung" gibt es max. 3 separate Einträge 
*/ 

/*
1. 
Teil vor dem 1. Komma 
*/

INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung 
TRIM(SUBSTRING_INDEX(Besetzung, ';',1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and besetzung <> '' 
and TRIM(SUBSTRING_INDEX(Besetzung, ';',1)) not in (select Name from besetzung )


/*
2. 
Teil nach dem letzten Semikolon
*/
INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung 
TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and besetzung <> '' 
and TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  not in (
select Name from besetzung 
)



/*
3. 
 Teil nach dem 1. und vor dem 2. Semikolon 

*/
INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung,  
TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and besetzung <> '' 
and TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))    not in (select Name from besetzung )


/* test match, insert musikstueck_besetzung */ 

insert into musikstueck_besetzung (MusikstueckID, BesetzungID) 
SELECT DISTINCT m.ID as MusikstueckID, b.ID as BesetzungID
-- , m.Besetzung, b.Name 
FROM musikstueck m left join `besetzung` b 
-- on m.Besetzung like concat('%', b.Name, '%')  
on 
( 
    TRIM(SUBSTRING_INDEX(m.Besetzung, ';',-1)) = b.Name
    or 
    TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  = b.Name
    or 
    TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))  = b.Name
    )
where 
m.Besetzung is not null 
and m.Besetzung <> ''
; 
-- and b.Name is nULL -- Test fehlende Zuordnung   


/* fkeys */ 
ALTER TABLE `musikstueck_besetzung` ADD  FOREIGN KEY (`MusikstueckID`) REFERENCES `musikstueck`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `musikstueck_besetzung` ADD  FOREIGN KEY (`BesetzungID`) REFERENCES `besetzung`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/* 
Spalte musikstueck.Besetzung löschen 

*/


