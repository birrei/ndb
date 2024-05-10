

/**********************************************************/

create or replace view v_satz_tmp_bes_dynam as 
select ID
    , REPLACE(REPLACE(REPLACE(Bemerkung4, 'DynamBes:', ''), '[',''), ']', '') as DynamBes
    , Bemerkung
from (
    select 
    ID
    , Bemerkung
    , Bemerkung3
    , substring(Bemerkung3, 1, ( locate(']', Bemerkung3) )) as Bemerkung4
   from 
   (
    select
        ID
        , Bemerkung
        , Bemerkung2
        , substring(Bemerkung2, locate('[', Bemerkung2)) as Bemerkung3
    from (
    select ID
        , Bemerkung 
        , Bemerkung1
        , concat(Bemerkung1, ']') as Bemerkung2 
        from 
        (
        select ID, Bemerkung
        , REPLACE(Bemerkung, 'DynamBes', '[DynamBes') Bemerkung1 
        from satz where Bemerkung like '%DynamBes%'
        ) as s1
    ) 
    satz1 
   )
   satz2 
) 
satz3 
; 

create or replace view v_tmp_BesDynam
as 
select distinct NULL as ID, DynamBes
from v_satz_tmp_bes_dynam
order by DynamBes
;

select * from v_satz_tmp_bes_dynam
;
select * from v_tmp_besdynam
;


/**********************************************************/




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
select distinct 'Dynamik' as Typ, DynamBes as Name 
-- select * 
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



insert into besonderheit (Typ, Name)
select distinct Typ, Name 
from v_tmp_besdynam_split 
where coalesce(Name,'') <> ''
order by Name
; 
select * from besonderheit
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



-- insert test 
select distinct 
    satz.ID as SatzID 
    , satz.DynamBesS
    , satz.DynamBes
    , besonderheit.ID as besonderheit_ID 
    , besonderheit.Name as besonderheit_Name
    , besonderheit.Typ
from v_satz_tmp_besdynam_split as satz  
inner join 
besonderheit 
on satz.DynamBes= besonderheit.Name
where besonderheit.Typ='Dynamik'
order by satz.ID
;

insert into satz_besonderheit (SatzID, BesonderheitID) 
select distinct 
    satz.ID as SatzID 
    , besonderheit.ID 
from v_satz_tmp_besdynam_split as satz  
inner join 
besonderheit 
on satz.DynamBes= besonderheit.Name
where besonderheit.Typ='Dynamik'
order by satz.ID
;
select * from satz_besonderheit
; 

-- TEST satz 
select satz.ID 
    , besonderheit.Name 
    , besonderheit.Typ
    , satz.Bemerkung            
from satz 
left JOIN satz_besonderheit on satz.ID = satz_besonderheit.SatzID
left join besonderheit on besonderheit.ID = satz_besonderheit.BesonderheitID
where besonderheit.Typ='Dynamik'
and satz_besonderheit.ID is not null 
order by satz.ID 
;

/* satz.Bemerkung bereinigen ... */
