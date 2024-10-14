
-- /* neue Tabelle "epoche"  */
-- CREATE TABLE IF NOT EXISTS `epoche`   
-- (`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB
-- ; 


-- /* neue Tabelle befüllen, Test */
-- insert into epoche (Name)
-- select distinct Epoche 
-- from musikstueck
-- where coalesce(Epoche, '') <> ''
-- ; 
-- select * from epoche order by Name
-- ; 


-- /* Referenz-Spalte anlegen */ 
-- ALTER TABLE `musikstueck` ADD `EpocheID` INT NULL
--  ;


-- /* update  */ 
-- update musikstueck
-- inner join epoche 
-- on COALESCE(musikstueck.Epoche, '') = epoche.Name 
-- set musikstueck.EpocheID = epoche.ID
-- where COALESCE(musikstueck.Epoche, '') <> ''
-- ; 

-- /* Test */ 
-- select musikstueck.ID as MusikstueckID, musikstueck.Epoche, epoche.ID as EpocheID, epoche.Name Epoche_Name
-- from musikstueck left join epoche
-- on musikstueck.EpocheID = epoche.ID 
-- where COALESCE(musikstueck.Epoche, '') <> ''
-- order by musikstueck.ID 


-- ALTER TABLE `musikstueck` CHANGE `EpocheID` `EpocheID` INT(11) UNSIGNED NULL DEFAULT NULL;

-- ALTER TABLE `musikstueck` 
-- ADD  FOREIGN KEY (`EpocheID`) 
-- REFERENCES `epoche`(`ID`) 
-- ON DELETE RESTRICT ON UPDATE RESTRICT;

