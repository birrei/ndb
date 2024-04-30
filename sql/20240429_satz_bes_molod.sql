

CREATE TABLE IF NOT EXISTS `besmelod`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 

CREATE TABLE IF NOT EXISTS `satz_besmelod` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `BesMelodID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

ALTER TABLE `satz_besmelod` 
ADD CONSTRAINT uc_satz_besmelod 
UNIQUE (SatzID, BesMelodID)
;

ALTER TABLE `satz_besmelod` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_besmelod` 
    ADD  FOREIGN KEY (`BesMelodID`) 
    REFERENCES `besmelod`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

select * from besmelod; 
select * from satz_besmelod; 


/**********************************************************/


--- Views: 
--- v_satz_tmp_bes_melod.sql: 
--  v_satz_tmp_bes_melod, v_tmp_BesMelod

select * from v_satz_tmp_bes_melod
;
select * from v_tmp_besmelod
;

-- KOrrekturen 

Update satz set Bemerkung = REPLACE(Bemerkung, 'chromatische Linie, kleine', 'chromatische Linie - kleine')
;
Update satz set Bemerkung = REPLACE(Bemerkung, 'Vorzeichen, zusätzliche', 'Vorzeichen zusätzliche')
:
Update satz set Bemerkung = REPLACE(Bemerkung, 'Vorschläge, kurz', 'Vorschläge kurz')
; 

/* prüfen, wie oft ein Kommatrenner vorkommt */ 

SELECT MelodBes 
, CHAR_LENGTH(MelodBes) - CHAR_LENGTH(REPLACE(MelodBes, ',', '')) as anzahl 
FROM v_tmp_besmelod
WHERE MelodBes LIKE '%,%'
--- > max. 3 


/* Tabelle "besmelod" befüllen */ 

create or REPLACE view v_tmp_besmelod_split as 
select * 
from (
SELECT SPLIT_STRING(MelodBes, ',', 1) as MelodBes
FROM v_satz_tmp_bes_melod 
WHERE coalesce(MelodBes,'') <> '' and MelodBes <> ''
UNION 
SELECT SPLIT_STRING(MelodBes, ',', 2) as MelodBes
FROM v_satz_tmp_bes_melod 
WHERE coalesce(MelodBes,'') <> '' and MelodBes <> ''
UNION 
SELECT SPLIT_STRING(MelodBes, ',', 3) as MelodBes
FROM v_satz_tmp_bes_melod 
WHERE coalesce(MelodBes,'') <> '' and MelodBes <> ''
) as t 
where MelodBes <> ''
ORDER BY MelodBes
; 

select * from v_tmp_besmelod_split
;
insert into besmelod (Name)
select MelodBes from v_tmp_besmelod_split 
where coalesce(MelodBes,'') <> ''
order by MelodBes
; 
select * from besmelod
; 


/* Tabelle "satz_besmelod" befüllen */ 

create or REPLACE view v_satz_tmp_besmelod_split as 
SELECT * 
FROM (
SELECT ID, MelodBes as MelodBesS, SPLIT_STRING(MelodBes, ',', 1) as MelodBes
FROM v_satz_tmp_bes_melod 
where coalesce(MelodBes,'') <> ''
UNION 
SELECT ID, MelodBes as MelodBesS, SPLIT_STRING(MelodBes, ',', 2) as MelodBes
FROM v_satz_tmp_bes_melod
where coalesce(MelodBes,'') <> ''
UNION 
SELECT ID, MelodBes as MelodBesS, SPLIT_STRING(MelodBes, ',', 3) as MelodBes
FROM v_satz_tmp_bes_melod
where coalesce(MelodBes,'') <> ''
) tmp 
where coalesce(MelodBes,'') <> ''
order by ID
; 
select * from v_satz_tmp_besmelod_split
; 


insert into satz_besmelod (SatzID, BesmelodID) 
select distinct 
    satz.ID as SatzID 
    -- , satz.MelodBesS
    -- , satz.MelodBes
    , besmelod.ID as BesmelodID 
 --   , besmelod.Name as besmelod_Name
from v_satz_tmp_besmelod_split as satz  
inner join 
besmelod 
on satz.MelodBes= besmelod.Name
order by satz.ID
;
select * from satz_besmelod
; 

-- TEST 
select satz.ID
    , satz.Bemerkung 
    , besmelod.ID as BesMelodID
    , besmelod.Name 
from satz 
left JOIN satz_besmelod on satz.ID = satz_besmelod.SatzID
left join besmelod on satz_besmelod.BesMelodID = besmelod.ID 
where satz_besmelod.ID is not null 
order by satz.ID 
;



/* satz.Bemerkung bereinigen ... */
