

CREATE TABLE IF NOT EXISTS `link`   
(`ID` int NOT NULL AUTO_INCREMENT 
, Bezeichnung VARCHAR(225) 
, URL VARCHAR(225) 
, LinktypeID tinyint NOT NULL 
, SammlungID int(10) unsigned
, PRIMARY KEY (`ID`)
)
; 

CREATE TABLE IF NOT EXISTS `linktype`   
(`ID` int NOT NULL AUTO_INCREMENT 
, Name VARCHAR(225) 
, PRIMARY KEY (`ID`)
)
; 

insert into linktype (Name) values('Kauf'); 
insert into linktype (Name) values('Digitalisierte Version'); 
select * from linktype; 



-- insert into link (SammlungID, LinktypeID, Bezeichnung, URL)
-- values(1,1,'Testlink 1', 'http://www.susannereiner.de/');


select link.ID
    , linktype.Name as Link_Typ
    , link.Bezeichnung
    , link.URL
from link left join linktype 
on link.LinktypeID = linktype.ID 





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




ALTER TABLE `sammlung` CHANGE `StandortID` `StandortID` INT(11) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `sammlung` 
ADD  FOREIGN KEY (`StandortID`) 
REFERENCES `standort`(`ID`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;




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
