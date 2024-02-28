
-- CREATE TABLE IF NOT EXISTS `verwendungszweck`   
-- (`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB; 


-- CREATE TABLE IF NOT EXISTS `musikstueck_verwendungszweck` 
-- (
-- `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
-- , `MusikstueckID` int(11) UNSIGNED  NOT NULL 
-- , `VerwendungszweckID` int(11) UNSIGNED  NOT NULL 
-- , PRIMARY KEY (`ID`)   
-- ) 
-- ENGINE = InnoDB;

-- ALTER TABLE `musikstueck_verwendungszweck` 
-- ADD CONSTRAINT uc_musikstueck_verwendungszweck 
-- UNIQUE (MusikstueckID, verwendungszweckID);

-- ALTER TABLE `musikstueck_verwendungszweck` 
--     ADD  FOREIGN KEY (`MusikstueckID`) 
--     REFERENCES `musikstueck`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ALTER TABLE `musikstueck_verwendungszweck` 
--     ADD  FOREIGN KEY (`VerwendungszweckID`) 
--     REFERENCES `verwendungszweck`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT;


/**********************************************************/


/* Daten übernehmen */ 

-- create or REPLACE view tmp_Verwendungszwecke as 
-- select distinct verwendungszweck 
-- from musikstueck 
-- where Verwendungszweck is not null 
-- and  Verwendungszweck <> ''
-- order by Verwendungszweck ; 


/* -- Sichtprüfung */
--  select * from tmp_Verwendungszwecke order by Verwendungszweck 
-- 


/* -- Funktion SPLIT_STRING neu angelegt! */

-- create or REPLACE view tmp_Verwendungszwecke_split as 
-- SELECT SPLIT_STRING(Verwendungszweck, ',', 1) as Verwendungszweck
-- FROM musikstueck 
-- WHERE Verwendungszweck is not null and Verwendungszweck <> ''
-- UNION 
-- SELECT SPLIT_STRING(Verwendungszweck, ',', 2)
-- FROM musikstueck 
-- WHERE Verwendungszweck is not null and Verwendungszweck <> ''
-- UNION 
-- SELECT SPLIT_STRING(Verwendungszweck, ',', 3)
-- FROM musikstueck 
-- WHERE Verwendungszweck is not null and Verwendungszweck <> ''
-- Order by Verwendungszweck

/* -- Sichtprüfung */
--  select * from tmp_Verwendungszwecke_split order by Verwendungszweck 


/* Tabelle "verwendungszweck" befüllen */ 
-- insert into verwendungszweck (Name)
-- select * from tmp_Verwendungszwecke_split 
-- where Verwendungszweck is not null 
-- and Verwendungszweck <> ''
-- and Verwendungszweck <> '(unbestimmt)'
; 

-- /* Liste alt/neu testen  */ 
-- select m.ID, m.Name as musikstueck_name, m.Verwendungszweck, v.Name 
-- from musikstueck m
-- left join verwendungszweck v
-- on ( 
--         SPLIT_STRING(m.Verwendungszweck, ',', 1)=v.Name 
--         or 
--         SPLIT_STRING(m.Verwendungszweck, ',', 2)=v.Name 
--         or 
--         SPLIT_STRING(m.Verwendungszweck, ',', 3)=v.Name         
-- ) 
-- where m.Verwendungszweck is not null 
-- and m.Verwendungszweck <> ''
-- and m.Verwendungszweck <> '(unbestimmt)'
-- order by m.ID 


-- /* Tabelle "musikstueck_verwendungszweck" befüllen */ 
-- insert into musikstueck_verwendungszweck (MusikstueckID, VerwendungszweckID)
-- select DISTINCT m.ID as MusikstueckID, v.ID as verwendungszweckID 
-- from musikstueck m
-- left join verwendungszweck v
-- on ( 
--         SPLIT_STRING(m.Verwendungszweck, ',', 1)=v.Name 
--         or 
--         SPLIT_STRING(m.Verwendungszweck, ',', 2)=v.Name 
--         or 
--         SPLIT_STRING(m.Verwendungszweck, ',', 3)=v.Name         
-- ) 
-- where m.Verwendungszweck is not null 
-- and m.Verwendungszweck <> ''
-- and m.Verwendungszweck <> '(unbestimmt)'
-- order by m.ID 




/* Verwendungszweck "(unbestimmt) entfernen */ 

-- SELECT * FROM verwendungszweck where Name='(unbestimmt)'
/* ID 1 */ 
-- delete from musikstueck_verwendungszweck where VerwendungszweckID=1

-- delete from verwendungszweck where ID=1



/* Spalte musikstueck.Verwendungszweck löschen */ 

-- ALTER TABLE `musikstueck` DROP `Verwendungszweck`;

/* Testabfrage */ 

select m.ID as MusikstueckID
    , m.Name as Musikstück 
    , v.ID as VerwendungszweckID
    , v.Name as Verwendungszweck 
from musikstueck m 
left join musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
left join verwendungszweck v on mv.VerwendungszweckID=v.ID 
where mv.ID is not null 
order by m.ID, v.ID 


/* sonst ... Testdatensätze prod entfernen: */ 
delete from musikstueck_verwendungszweck where VerwendungszweckID=6
delete from verwendungszweck where ID=6






