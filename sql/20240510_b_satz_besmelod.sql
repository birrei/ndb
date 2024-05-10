

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

create or replace view v_satz_tmp_bes_melod as 
select ID
    , REPLACE(REPLACE(REPLACE(Bemerkung4, 'MelodBes:', ''), '[',''), ']', '') as MelodBes
    , Bemerkung
from 
-- satz3 
(
select 
    ID
    , Bemerkung
    , Bemerkung3
        -- , length(Bemerkung3)
        -- , locate(']', Bemerkung3)
    , substring(Bemerkung3, 1, ( locate(']', Bemerkung3) )) as Bemerkung4
   from 
   -- satz2 
   (
    select
        ID
        , Bemerkung
        , Bemerkung2
        , substring(Bemerkung2, locate('[', Bemerkung2)) as Bemerkung3
    from 
    -- satz1 
    (
    select ID
    , Bemerkung 
    , Bemerkung1
    , case 
    -- when Bemerkung1 like '%, MelodBes%' 
    --     then REPLACE(Bemerkung1 , ', MelodBes', '], MelodBes') 
    when Bemerkung1 like '%, RhytmBes%' 
        then REPLACE(Bemerkung1 , ', RhytmBes', '], RhytmBes') 
    when Bemerkung1 like '%, DynamBes%' 
        then REPLACE(Bemerkung1 , ', DynamBes', '], DynamBes') 
    else concat(Bemerkung1, ']') 
    end as Bemerkung2 -- Teil "Übung" innerhalb "[]"

    from 
    (
        select ID, Bemerkung
        , REPLACE(Bemerkung, 'MelodBes', '[MelodBes') Bemerkung1 
        from satz where Bemerkung like '%MelodBes%'
    ) as s1
     ) as satz1 

   ) as satz2 
) as satz3
; 


create or replace view v_tmp_BesMelod
as
select distinct NULL as ID, MelodBes 
from v_satz_tmp_bes_melod
order by MelodBes

; 

select * from v_satz_tmp_bes_melod;


select * from v_tmp_BesMelod; 



select * from v_satz_tmp_bes_melod
;
select * from v_tmp_BesMelod
;


/**********************************************************/




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

/**********************************************************/

/* lookup Besonderheit */ 

create or REPLACE view v_tmp_besmelod_split as 
select distinct 'Melodik' as Typ, MelodBes as Name  
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


insert into besonderheit (Typ, Name)
select distinct Typ, Name 
from v_tmp_besmelod_split 
where coalesce(Name,'') <> ''
order by Name
; 
select * from besonderheit
; 

/* Tabelle "satz_besonderheit" befüllen */ 

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

-- insert test 
select distinct 
    satz.ID as SatzID 
    , satz.MelodBesS
    , satz.MelodBes
    , besonderheit.ID as besonderheit_ID 
    , besonderheit.Name as besonderheit_Name
    , besonderheit.Typ
from v_satz_tmp_besmelod_split as satz  
inner join 
besonderheit 
on satz.MelodBes= besonderheit.Name
where besonderheit.Typ='Melodik'
order by satz.ID


-- insert 
insert into satz_besonderheit (SatzID, BesonderheitID) 
select distinct 
    satz.ID as SatzID 
    , besonderheit.ID 
from v_satz_tmp_besmelod_split as satz  
inner join 
besonderheit 
on satz.MelodBes= besonderheit.Name
where besonderheit.Typ='Melodik'
order by satz.ID
;

select * from satz_besonderheit
; 
-- 35 Zeilen 



-- TEST satz 
select satz.ID 
    , satz.Bemerkung   
    , besonderheit.Name 
    , besonderheit.Typ     
from satz 
left JOIN satz_besonderheit on satz.ID = satz_besonderheit.SatzID
left join besonderheit on besonderheit.ID = satz_besonderheit.BesonderheitID
where besonderheit.Typ='Melodik'
and satz_besonderheit.ID is not null 
order by satz.ID 
;

