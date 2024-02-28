/* 
Umwandlung Feld satz.Stricharten zu Unterauswahl 
*/ 

-- CREATE TABLE IF NOT EXISTS `strichart`   
-- (`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB; 

-- CREATE TABLE IF NOT EXISTS `satz_strichart` 
-- (
-- `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
-- , `SatzID` int(11) UNSIGNED  NOT NULL 
-- , `StrichartID` int(11) UNSIGNED  NOT NULL 
-- , PRIMARY KEY (`ID`)   
-- ) 
-- ENGINE = InnoDB;

-- ALTER TABLE `satz_strichart` 
-- ADD CONSTRAINT uc_satz_strichart 
-- UNIQUE (SatzID, StrichartID);

-- ALTER TABLE `satz_strichart` 
--     ADD  FOREIGN KEY (`SatzID`) 
--     REFERENCES `satz`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ALTER TABLE `satz_strichart` 
--     ADD  FOREIGN KEY (`StrichartID`) 
--     REFERENCES `strichart`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT;


/**********************************************************/

/* Daten übernehmen */ 

-- view distinct stricharten 
-- create or REPLACE view tmp_Stricharten as 
-- select distinct Stricharten from satz 
-- where Stricharten is not null 
-- and  Stricharten <> ''
-- order by Stricharten ; 


-- Sichtprüfung 
-- select * from tmp_Stricharten order by Stricharten 


---- zusätzliches Komma entfernen 
-- Update satz 
-- set Stricharten ='Détaché, Legato, Martélé breites' 
-- WHERE ID=54 
-- AND Stricharten='Détaché, Legato, Martélé, breites'


/* -- Funktion SPLIT_STRING neu angelegt! */

-- create or REPLACE view tmp_Stricharten_split as 
-- SELECT SPLIT_STRING(Stricharten, ',', 1) as Strichart
-- FROM satz 
-- WHERE Stricharten is not null and Stricharten <> ''
-- UNION 
-- SELECT SPLIT_STRING(Stricharten, ',', 2)
-- FROM satz 
-- WHERE Stricharten is not null and Stricharten <> ''
-- UNION 
-- SELECT SPLIT_STRING(Stricharten, ',', 3)
-- FROM satz 
-- WHERE Stricharten is not null and Stricharten <> ''
-- UNION 
-- SELECT SPLIT_STRING(Stricharten, ',', 4)
-- FROM satz 
-- WHERE Stricharten is not null and Stricharten <> ''
-- ORDER BY Strichart

-- ;

/* Tabelle "strichart" befüllen */ 
-- insert into strichart (Name)
-- select * from tmp_Stricharten_split 
-- where Strichart is not null 
-- and Strichart <> ''
-- ; 

/* Liste Stricharten testen, Tabelle "satz_strichart" befüllen */ 

--- select s.ID, s.Name satz_name, s.Stricharten, sa.Name 
-- insert into satz_strichart (SatzID, StrichartID)
-- select DISTINCT s.ID as SatzID, sa.ID as StrichartID 
-- from satz s
-- left join strichart sa
-- on ( 
--         SPLIT_STRING(s.Stricharten, ',', 1)=sa.Name 
--         or 
--         SPLIT_STRING(s.Stricharten, ',', 2)=sa.Name 
--         or 
--         SPLIT_STRING(s.Stricharten, ',', 3)=sa.Name 
--         or 
--         SPLIT_STRING(s.Stricharten, ',', 4)=sa.Name 
-- ) 
-- where s.Stricharten is not null 
-- and s.Stricharten <> ''
-- order by s.ID 


/* altes Feld "stricharten" entfernen */

ALTER TABLE `satz` DROP `Stricharten`;
