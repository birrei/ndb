

CREATE TABLE IF NOT EXISTS `erprobt`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 

CREATE TABLE IF NOT EXISTS `satz_erprobt` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `ErprobtID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

ALTER TABLE `satz_erprobt` 
ADD CONSTRAINT uc_satz_erprobt 
UNIQUE (SatzID, ErprobtID)
;

ALTER TABLE `satz_erprobt` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_erprobt` 
    ADD  FOREIGN KEY (`ErprobtID`) 
    REFERENCES `erprobt`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

select * from erprobt
; 

select * from satz_erprobt
; 


insert into erprobt 
select ID, Erprobt 
from v_tmp_erprobt
order by Erprobt
;
select * from erprobt
;


insert into satz_erprobt (SatzID, ErprobtID) 
select distinct satz.ID as SatzID, erprobt.ID as ErprobtID
-- , satz.Name as Satz, satz.Erprobt, erprobt.Name as Erprobt_Name 
from satz 
inner join 
erprobt 
on satz.Erprobt = erprobt.Name
where coalesce(satz.Erprobt, '') <> ''
; 
select * from satz_erprobt
; 

select satz.ID
    , satz.Erprobt
    , erprobt.ID as ErprobtID
    , erprobt.Name 
from satz 
left JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID
left join erprobt on satz_erprobt.ErprobtID = erprobt.ID
-- WHERE Coalesce(satz.Erprobt, '') <> ''
where erprobt.ID is not NULL



/*
  * Umstellung Satz > Erprobt

    * Anpassen: View v_musikstueck, v_satz  
    * erstellen: cl_erprobt.php
    * erstellen: insert_erprobt.php (verbesserte Variante)
    * erstellen: edit_erprobt.php (verbesserte Variante)
    * ergänzen: Zeile in index.php 
    * anpassen: cl_satz: function add_erprobt 
    * anpassen: cl_satz: function print_table_erprobte  (angepasste Variante!)
    * cl_satz.php: Feld "Erprobte" entfernen 
    * edit_satz.php: Feld "Erprobte" entfernen 
    * erstellen: edit_satz_add_erprobt.php (verbesserte Variante!)
    * erstellen: edit_satz_erprobte.php  (verbesserte Variante!)
    * Erfassung / Bearbeitung / Abrufe testen 
    * Ergänzen/anpassen: search_musikstueck.php 
    * View v_tmp_Erprobte löschen, def. aus ddl_views.sql entfernen
    * Produduktivnahme - 29.03.2024 - 17:00 


erledigt: 
    * Tabellen erstellen + Inhalte migrieren : 20240408_satz_erprobt.sql

*/

/* altes Feld "erprobten" entfernen */

-- ALTER TABLE `satz` DROP `Erprobte`;



