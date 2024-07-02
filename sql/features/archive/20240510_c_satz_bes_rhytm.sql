
/**********************************************************/

create or replace view v_satz_tmp_bes_rhytm as 
select ID
    , REPLACE(REPLACE(REPLACE(Bemerkung4, 'RhytmBes:', ''), '[',''), ']', '') as RhytmBes
    , Bemerkung
from (
        select 
    ID
    , Bemerkung
    , Bemerkung3
        -- , length(Bemerkung3)
        -- , locate(']', Bemerkung3)
    , substring(Bemerkung3, 1, ( locate(']', Bemerkung3) )) as Bemerkung4
   from 
   (
    select
        ID
        , Bemerkung
        , Bemerkung2
        , substring(Bemerkung2, locate('[', Bemerkung2)) as Bemerkung3
    from 
    (
    select ID
        , Bemerkung 
        , Bemerkung1
        , case 
        -- when Bemerkung1 like '%, MelodBes%' 
        --     then REPLACE(Bemerkung1 , ', MelodBes', '], MelodBes') 
        -- when Bemerkung1 like '%, RhytmBes%' 
        --     then REPLACE(Bemerkung1 , ', RhytmBes', '], RhytmBes') 
        when Bemerkung1 like '%, DynamBes%' 
            then REPLACE(Bemerkung1 , ', DynamBes', '], DynamBes') 
        else concat(Bemerkung1, ']') 
        end as Bemerkung2 -- Teil "Übung" innerhalb "[]"

        from 
        (
        select ID, Bemerkung
        , REPLACE(Bemerkung, 'RhytmBes', '[RhytmBes') Bemerkung1 
        from satz where Bemerkung like '%RhytmBes%'
        ) as s1
    )satz1 

   )satz2 

) satz3 
; 

create or replace view v_tmp_BesRhytm
as
select distinct NULL as ID, RhytmBes
from v_satz_tmp_bes_rhytm
order by RhytmBes
;

select * from v_satz_tmp_bes_rhytm
;
select * from v_tmp_BesRhytm
;
/***************************************************************/


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




create or REPLACE view v_tmp_besrythm_split as 
select distinct 'Rythmik' as Typ, RhytmBes as Name 
-- select * 
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


insert into besonderheit (Typ, Name)
select distinct Typ, Name 
from v_tmp_besrythm_split 
where coalesce(Name,'') <> ''
order by Name
; 
select * from besonderheit
; 



-- /* Tabelle "satz_besrythm" befüllen */ 


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


-- insert test 
select distinct 
    satz.ID as SatzID 
    , satz.RhytmBesS
    , satz.RhytmBes
    , besonderheit.ID as besonderheit_ID 
    , besonderheit.Name as besonderheit_Name
    , besonderheit.Typ
from v_satz_tmp_besrythm_split as satz  
inner join 
besonderheit 
on satz.RhytmBes= besonderheit.Name
where besonderheit.Typ='Rythmik'
order by satz.ID
;


insert into satz_besonderheit (SatzID, BesonderheitID) 
select distinct 
    satz.ID as SatzID 
    , besonderheit.ID 
from v_satz_tmp_besrythm_split as satz  
inner join 
besonderheit 
on satz.RhytmBes= besonderheit.Name
where besonderheit.Typ='Rythmik'
order by satz.ID
;
select * from satz_besonderheit
; 



-- TEST satz 
select satz.ID 
    , satz.Bemerkung   
    , besonderheit.Name 
    , besonderheit.Typ     
from satz 
left JOIN satz_besonderheit on satz.ID = satz_besonderheit.SatzID
left join besonderheit on besonderheit.ID = satz_besonderheit.BesonderheitID
where besonderheit.Typ='Rythmik'
and satz_besonderheit.ID is not null 
order by satz.ID 
;





-- /* satz.Bemerkung bereinigen ... */
