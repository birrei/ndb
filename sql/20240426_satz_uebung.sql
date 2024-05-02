

CREATE TABLE IF NOT EXISTS `uebung`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 

CREATE TABLE IF NOT EXISTS `satz_uebung` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `UebungID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

ALTER TABLE `satz_uebung` 
ADD CONSTRAINT uc_satz_uebung 
UNIQUE (SatzID, UebungID)
;

ALTER TABLE `satz_uebung` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_uebung` 
    ADD  FOREIGN KEY (`UebungID`) 
    REFERENCES `uebung`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

select * from uebung; 
select * from satz_uebung; 


/**********************************************************/


--- Views: 
--- v_satz_tmp_uebung.sql: 
--  v_satz_tmp_uebung, v_tmp_uebung



select * from v_tmp_uebung;
select * from v_satz_tmp_uebung


-- -- KOrrekturen 
--  Update satz 
--  set Bemerkung = REPLACE(Bemerkung, 'Tonarten,weit entfernte', 'weit entfernte Tonarten')


/* prüfen, wie oft ein Kommatrenner vorkommt */ 

SELECT Uebung
, CHAR_LENGTH(Uebung) - CHAR_LENGTH(REPLACE(Uebung, ',', '')) as anzahl 
FROM v_satz_tmp_uebung
WHERE Uebung LIKE '%,%'
--- > max. 2 


/* Tabelle "uebung" befüllen */ 

create or REPLACE view v_tmp_uebung_split as 
SELECT SPLIT_STRING(Uebung, ',', 1) as Uebung
FROM v_satz_tmp_uebung 
WHERE coalesce(Uebung,'') <> ''and Uebung <> ''
UNION 
SELECT SPLIT_STRING(Uebung, ',', 2) as Uebung
FROM v_satz_tmp_uebung 
WHERE coalesce(Uebung,'') <> ''and Uebung <> ''
UNION 
SELECT SPLIT_STRING(Uebung, ',', 3) as Uebung
FROM v_satz_tmp_uebung 
WHERE coalesce(Uebung,'') <> ''and Uebung <> ''
ORDER BY Uebung

;
select * from v_tmp_uebung_split 
;

insert into uebung (Name)
select Uebung from v_tmp_uebung_split 
where coalesce(Uebung,'') <> ''
order by Uebung
; 
select * from uebung
; 


/* Tabelle "satz_uebung" befüllen */ 

-- create or REPLACE view v_satz_tmp_uebung_split as 
-- SELECT * 
-- FROM (
-- SELECT ID, Uebung as Uebungen, SPLIT_STRING(Uebung, ',', 1) as Uebung
-- FROM v_satz_tmp_uebung 
-- where coalesce(Uebung,'') <> ''
-- UNION 
-- SELECT ID, Uebung as Uebungen, SPLIT_STRING(Uebung, ',', 2) as Uebung
-- FROM v_satz_tmp_uebung
-- where coalesce(Uebung,'') <> ''
-- UNION 
-- SELECT ID, Uebung as Uebungen, SPLIT_STRING(Uebung, ',', 3) as Uebung
-- FROM v_satz_tmp_uebung
-- where coalesce(Uebung,'') <> ''
-- ) tmp 
-- where coalesce(Uebung,'') <> ''
-- order by ID

-- ; 
-- select * from v_satz_tmp_uebung_split
-- ; 

-- insert into satz_uebung (SatzID, UebungID) 
-- select distinct 
--     satz.ID as SatzID 
--     , uebung.ID as UebungID 
--     -- , satz.Bemerkung
--     -- , satz.Uebung
--     -- , Uebung.Name 
-- from v_satz_tmp_uebung_split as satz  
-- inner join 
-- uebung 
-- on satz.Uebung = uebung.Name
-- order by satz.ID
-- ; 

-- select * from satz_uebung
-- ; 

-- TEST 
select satz.ID
    , uebung.ID as UebungID
    , uebung.Name 
    , satz.Bemerkung 
from satz 
left JOIN satz_uebung on satz.ID = satz_uebung.SatzID
left join uebung on satz_uebung.UebungID = uebung.ID 
where satz_uebung.ID is not null 
order by satz.ID 
;



/* satz.Bemerkung bereinigen ... */
