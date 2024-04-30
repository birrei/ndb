

CREATE TABLE IF NOT EXISTS `besrythm`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 

CREATE TABLE IF NOT EXISTS `satz_besrythm` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `BesRhytmID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

ALTER TABLE `satz_besrythm` 
ADD CONSTRAINT uc_satz_besrythm 
UNIQUE (SatzID, BesRhytmID)
;

ALTER TABLE `satz_besrythm` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_besrythm` 
    ADD  FOREIGN KEY (`BesRhytmID`) 
    REFERENCES `besrythm`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

select * from besrythm; 
select * from satz_besrythm; 


/**********************************************************/


--- Views: 
--- v_satz_tmp_bes_rhytm.sql: 
--  v_satz_tmp_bes_rhytm, v_tmp_BesRhytm

select * from v_satz_tmp_bes_rhytm
;
select * from v_tmp_besrhytm
;

-- KOrrekturen 

Update satz set Bemerkung = REPLACE(Bemerkung, 'Viertel"', 'Viertel')
;
Update satz set Bemerkung = REPLACE(Bemerkung, 'Auftakte, verschiedenartige', 'Auftakte verschiedenartige')
;
Update satz set Bemerkung = REPLACE(Bemerkung, 'Punktierungen,viele', 'Punktierungen viele')
;
Update satz set Bemerkung = REPLACE(Bemerkung, '-Viertel', ' Viertel')
;



-- /* prüfen, wie oft ein Kommatrenner vorkommt */ 

SELECT RhytmBes 
, CHAR_LENGTH(RhytmBes) - CHAR_LENGTH(REPLACE(RhytmBes, ',', '')) as anzahl 
FROM v_tmp_besrythm
WHERE RhytmBes LIKE '%,%'
-- --- > max. 2


-- /* Tabelle "besrythm" befüllen */ 

create or REPLACE view v_tmp_besrythm_split as 
select * 
from (
SELECT SPLIT_STRING(RhytmBes, ',', 1) as RhytmBes
FROM v_satz_tmp_bes_rhytm 
WHERE coalesce(RhytmBes,'') <> '' and RhytmBes <> ''
UNION 
SELECT SPLIT_STRING(RhytmBes, ',', 2) as RhytmBes
FROM v_satz_tmp_bes_rhytm 
WHERE coalesce(RhytmBes,'') <> '' and RhytmBes <> ''
UNION 
SELECT SPLIT_STRING(RhytmBes, ',', 3) as RhytmBes
FROM v_satz_tmp_bes_rhytm 
WHERE coalesce(RhytmBes,'') <> '' and RhytmBes <> ''
UNION 
SELECT SPLIT_STRING(RhytmBes, ',', 4) as RhytmBes
FROM v_satz_tmp_bes_rhytm 
WHERE coalesce(RhytmBes,'') <> '' and RhytmBes <> ''
) as t 
where RhytmBes <> ''
ORDER BY RhytmBes
;

select * from v_tmp_besrythm_split
;
insert into besrythm (Name)
select RhytmBes from v_tmp_besrythm_split 
where coalesce(RhytmBes,'') <> ''
order by RhytmBes
; 
select * from besrythm
; 


-- /* Tabelle "satz_besrythm" befüllen */ 

select * from v_satz_tmp_bes_rhytm
;
create or REPLACE view v_satz_tmp_besrythm_split as 
SELECT * 
FROM (
SELECT ID, RhytmBes as RhytmBesS, SPLIT_STRING(RhytmBes, ',', 1) as RhytmBes
FROM v_satz_tmp_bes_rhytm 
where coalesce(RhytmBes,'') <> ''
UNION 
SELECT ID, RhytmBes as RhytmBesS, SPLIT_STRING(RhytmBes, ',', 2) as RhytmBes
FROM v_satz_tmp_bes_rhytm
where coalesce(RhytmBes,'') <> ''
UNION 
SELECT ID, RhytmBes as RhytmBesS, SPLIT_STRING(RhytmBes, ',', 3) as RhytmBes
FROM v_satz_tmp_bes_rhytm
where coalesce(RhytmBes,'') <> ''
UNION 
SELECT ID, RhytmBes as RhytmBesS, SPLIT_STRING(RhytmBes, ',', 4) as RhytmBes
FROM v_satz_tmp_bes_rhytm
where coalesce(RhytmBes,'') <> ''
) tmp 
where coalesce(RhytmBes,'') <> ''
order by ID
; 
select * from v_satz_tmp_besrythm_split
; 


insert into satz_besrythm (SatzID, BesrhytmID) 
select distinct 
    satz.ID as SatzID 
    -- , satz.RhytmBesS
    -- , satz.RhytmBes
    , besrythm.ID as BesrhytmID 
 --   , besrythm.Name as besrythm_Name
from v_satz_tmp_besrythm_split as satz  
inner join 
besrythm 
on satz.RhytmBes= besrythm.Name
order by satz.ID
;
 select * from satz_besrythm
-- ; 

-- TEST 
select satz.ID
    , satz.Bemerkung 
    , besrythm.ID as BesRhytmID
    , besrythm.Name 
from satz 
left JOIN satz_besrythm on satz.ID = satz_besrythm.SatzID
left join besrythm on satz_besrythm.BesRhytmID = besrythm.ID 
where satz_besrythm.ID is not null 
order by satz.ID 
;



-- /* satz.Bemerkung bereinigen ... */
