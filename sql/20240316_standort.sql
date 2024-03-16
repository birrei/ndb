
/* neue Tabelle "standort"  */
CREATE TABLE IF NOT EXISTS `standort`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 



/* neue Tabelle befüllen, Test */
insert into standort (Name)
select distinct Standort 
from sammlung 
where coalesce(Standort, '') <> ''
; 
select * from standort order by Name
; 

/* sammlung > SammlungID hinzufügen */ 
ALTER TABLE `sammlung` ADD `StandortID` INT NULL
 ;

/* update  */ 
update sammlung
inner join standort 
on COALESCE(sammlung.Standort, '') = standort.Name 
set sammlung.StandortID = standort.ID
where COALESCE(sammlung.Standort, '') <> ''
; 

/* Test */ 
select sa.ID, sa.Standort, sa.StandortID, st.Name 
from sammlung sa left join standort st 
on sa.StandortID = st.ID 
where COALESCE(sa.Standort, '') <> ''
order by sa.ID

/* 
to-do: 

// anlegen: insert_standort.php 
// index.php -> in Auflistung ergäzen 
// foot.php -> in Auflistung ergänzen 

View v_sammlung anlegen 
View v_sammlung für Tabellenaufrufe in index.php / foot.php hinterlegen  


cl_standort.php 
cl_sammlung.php: Standort -> StandortID 

anlegen: edit_standort.php 

edit_sammlung.php anpassen

Testen ... 
Wenn OK: Spalte sammlung.Standort löschen 





*/ 


ALTER TABLE sammlung DROP Standort
