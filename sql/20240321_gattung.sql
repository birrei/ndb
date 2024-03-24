
/* neue Tabelle "gattung"  */
-- CREATE TABLE IF NOT EXISTS `gattung`   
-- (`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB
-- ; 


-- /* neue Tabelle befüllen, Test */
-- insert into gattung (Name)
-- select distinct Gattung 
-- from musikstueck
-- where coalesce(Gattung, '') <> ''
-- ; 
-- select * from gattung order by Name
-- ; 

-- ALTER TABLE `musikstueck` ADD `GattungID` INT NULL
--  ;


-- /* update  */ 
-- update musikstueck
-- inner join gattung 
-- on COALESCE(musikstueck.Gattung, '') = gattung.Name 
-- set musikstueck.GattungID = gattung.ID
-- where COALESCE(musikstueck.Gattung, '') <> ''
-- ; 

-- /* Test */ 
-- select musikstueck.ID as MusikstueckID, musikstueck.Gattung, gattung.ID as GattungID, gattung.Name Gattung_Name
-- from musikstueck left join gattung
-- on musikstueck.GattungID = gattung.ID 
-- where COALESCE(musikstueck.Gattung, '') <> ''
-- order by musikstueck.ID 


-- ALTER TABLE `musikstueck` CHANGE `GattungID` `GattungID` INT(11) UNSIGNED NULL DEFAULT NULL;

-- ALTER TABLE `musikstueck` 
-- ADD  FOREIGN KEY (`GattungID`) 
-- REFERENCES `gattung`(`ID`) 
-- ON DELETE RESTRICT ON UPDATE RESTRICT;

