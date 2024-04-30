

CREATE TABLE IF NOT EXISTS `besdynam`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 

CREATE TABLE IF NOT EXISTS `satz_besdynam` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `BesDynamID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

ALTER TABLE `satz_besdynam` 
ADD CONSTRAINT uc_satz_besdynam 
UNIQUE (SatzID, BesDynamID)
;

ALTER TABLE `satz_besdynam` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_besdynam` 
    ADD  FOREIGN KEY (`BesDynamID`) 
    REFERENCES `besdynam`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

select * from besdynam; 
select * from satz_besdynam; 


/**********************************************************/


--- Views: 
--- v_satz_tmp_bes_dynam.sql: 
--  v_satz_tmp_bes_dynam, v_tmp_BesDynam

select * from v_satz_tmp_bes_dynam
;
select * from v_tmp_besdynam
;

-- KOrrekturen 

Update satz set Bemerkung = REPLACE(Bemerkung, 'Echo"', 'Echo')
;
Update satz set Bemerkung = REPLACE(Bemerkung, 'Stufendynamik"', 'Stufendynamik')
;
Update satz set Bemerkung = REPLACE(Bemerkung, 'Crescendo"', 'Crescendo')
; 

/* prüfen, wie oft ein Kommatrenner vorkommt */ 

SELECT DynamBes 
, CHAR_LENGTH(DynamBes) - CHAR_LENGTH(REPLACE(DynamBes, ',', '')) as anzahl 
FROM v_tmp_besdynam
WHERE DynamBes LIKE '%,%'
--- > max. 2


/* Tabelle "besdynam" befüllen */ 

create or REPLACE view v_tmp_besdynam_split as 
select * 
from (
SELECT SPLIT_STRING(DynamBes, ',', 1) as DynamBes
FROM v_satz_tmp_bes_dynam 
WHERE coalesce(DynamBes,'') <> '' and DynamBes <> ''
UNION 
SELECT SPLIT_STRING(DynamBes, ',', 2) as DynamBes
FROM v_satz_tmp_bes_dynam 
WHERE coalesce(DynamBes,'') <> '' and DynamBes <> ''
) as t 
where DynamBes <> ''
ORDER BY DynamBes
; 

select * from v_tmp_besdynam_split
;
insert into besdynam (Name)
select DynamBes from v_tmp_besdynam_split 
where coalesce(DynamBes,'') <> ''
order by DynamBes
; 
select * from besdynam
; 


/* Tabelle "satz_besdynam" befüllen */ 

create or REPLACE view v_satz_tmp_besdynam_split as 
SELECT * 
FROM (
SELECT ID, DynamBes as DynamBesS, SPLIT_STRING(DynamBes, ',', 1) as DynamBes
FROM v_satz_tmp_bes_dynam 
where coalesce(DynamBes,'') <> ''
UNION 
SELECT ID, DynamBes as DynamBesS, SPLIT_STRING(DynamBes, ',', 2) as DynamBes
FROM v_satz_tmp_bes_dynam
where coalesce(DynamBes,'') <> ''
UNION 
SELECT ID, DynamBes as DynamBesS, SPLIT_STRING(DynamBes, ',', 3) as DynamBes
FROM v_satz_tmp_bes_dynam
where coalesce(DynamBes,'') <> ''
) tmp 
where coalesce(DynamBes,'') <> ''
order by ID
; 
select * from v_satz_tmp_besdynam_split
; 


insert into satz_besdynam (SatzID, BesdynamID) 
select distinct 
    satz.ID as SatzID 
    -- , satz.DynamBesS
    -- , satz.DynamBes
    , besdynam.ID as BesdynamID 
 --   , besdynam.Name as besdynam_Name
from v_satz_tmp_besdynam_split as satz  
inner join 
besdynam 
on satz.DynamBes= besdynam.Name
order by satz.ID
;
select * from satz_besdynam
; 

-- TEST 
select satz.ID
    , satz.Bemerkung 
    , besdynam.ID as BesDynamID
    , besdynam.Name 
from satz 
left JOIN satz_besdynam on satz.ID = satz_besdynam.SatzID
left join besdynam on satz_besdynam.BesDynamID = besdynam.ID 
where satz_besdynam.ID is not null 
order by satz.ID 
;



/* satz.Bemerkung bereinigen ... */
