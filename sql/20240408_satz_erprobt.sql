

CREATE TABLE IF NOT EXISTS `erprobt`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 


select * from erprobt
; 

insert into erprobt 
select ID, Erprobt 
from v_tmp_erprobt
order by Erprobt
;
select * from erprobt
;

ALTER TABLE `satz` ADD `ErprobtID` INT NULL

;
update satz
inner join erprobt  
on COALESCE(satz.Erprobt, '') = erprobt.Name 
set satz.ErprobtID = erprobt.ID
where COALESCE(satz.Erprobt, '') <> ''
; 

-- /* Test */ 
select satz.ID as SatzID
    , satz.Erprobt
    , erprobt.ID as ErprobtID
    , erprobt.Name Erprobt_Name
from satz left join erprobt
on satz.ErprobtID = erprobt.ID 
where COALESCE(satz.Erprobt, '') <> ''
order by satz.ID 
;


ALTER TABLE `satz` CHANGE `ErprobtID` `ErprobtID` INT(11) UNSIGNED NULL DEFAULT NULL
;

ALTER TABLE `satz` 
ADD  FOREIGN KEY (`ErprobtID`) 
REFERENCES `erprobt`(`ID`) 
ON DELETE RESTRICT ON UPDATE RESTRICT
;


ALTER TABLE `satz` DROP `Erprobt`;


/*
Umstellung Satz > Erprobt

erledigt: 
    * Tabellen erstellen + Inhalte migrieren : 20240408_satz_erprobt.sql
    * Anpassen: View v_satz
    * erstellen: cl_erprobt.php
    * erstellen: insert_erprobt.php
    * erstellen: edit_erprobt.php 
    * ergänzen: Zeile in index.php 
    * cl_satz.php: Feld "Erprobt" ändern in "ErprobtID"
    * edit_satz.php: Feld "Erprobt" ändern in Select-Element  
    * Anpassung cl_musikstueck (Abfrage für print_table_saetze())
    * Erfassung / Bearbeitung / Abrufe testen 
    * Ergänzen/anpassen: suche.php 
    * View v_tmp_Erprobt löschen, def. aus ddl_views.sql entfernen
    * Altes Feld "Satz.Erprobt" entfernen 
    * nochmal testen: Suche, Erfassung Satz  
    * Produduktivnahme - 09.04.2024 
    * info AG 

*/




