
-- /* neue Tabelle "standort"  */
-- CREATE TABLE IF NOT EXISTS `standort`   
-- (`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB
-- ; 



-- /* neue Tabelle befüllen, Test */
-- insert into standort (Name)
-- select distinct Standort 
-- from sammlung 
-- where coalesce(Standort, '') <> ''
-- ; 
-- select * from standort order by Name
-- ; 

-- /* sammlung > SammlungID hinzufügen */ 
-- ALTER TABLE `sammlung` ADD `StandortID` INT NULL
--  ;

-- /* update  */ 
-- update sammlung
-- inner join standort 
-- on COALESCE(sammlung.Standort, '') = standort.Name 
-- set sammlung.StandortID = standort.ID
-- where COALESCE(sammlung.Standort, '') <> ''
-- ; 


-- Update  sammlung
-- set StandortID=6 -- Standort "XXX"
-- where StandortID is null 

-- /* Test */ 
-- select sa.ID, sa.Standort, sa.StandortID, st.Name 
-- from sammlung sa left join standort st 
-- on sa.StandortID = st.ID 
-- -- where COALESCE(sa.Standort, '') <> ''
-- order by sa.ID



/* 
to-do: 

// erstellen: insert_standort.php 
// anpassen: index.php -> in Auflistung ergäzen 
// anpassen: foot.php -> in Auflistung ergänzen 

// anlegen: View v_sammlung anlegen 
// anpassen: View v_sammlung für Tabellenaufrufe in index.php / foot.php hinterlegen  


erstellen: cl_standort.php 
erstellen: cl_sammlung.php: Standort -> StandortID 

erstellen: edit_standort.php 

anpassen: edit_sammlung.php 

anpassen: sammlung.Standort löschen 





*/ 


ALTER TABLE sammlung DROP Standort
