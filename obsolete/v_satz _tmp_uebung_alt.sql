create or replace view v_satz_tmp_Uebung as 
/* Vorbedingung: Übung erste der 4 Eigenschaften */ 
with satz1 as (
    select ID
    , Bemerkung 
    , Bemerkung1
    , case 
    when Bemerkung1 like '%, MelodBes%' 
        then REPLACE(Bemerkung1 , ', MelodBes', '], MelodBes') 
    when Bemerkung1 like '%, RhytmBes%' 
        then REPLACE(Bemerkung1 , ', RhytmBes', '], RhytmBes') 
    when Bemerkung1 like '%, DynamBes%' 
        then REPLACE(Bemerkung1 , ', DynamBes', '], DynamBes') 
    else concat(Bemerkung1, ']') 
    end as Bemerkung2 -- Teil "Übung" innerhalb "[]"

    from 
    (
    select ID, Bemerkung
    , REPLACE(Bemerkung, 'Übung', '[Übung') Bemerkung1 
    from satz where Bemerkung like '%Übung%'
    ) as s1
) 
, satz2 as (
    select
        ID
        , Bemerkung
        , Bemerkung2
        , substring(Bemerkung2, locate('[', Bemerkung2)) as Bemerkung3
    from satz1 
)
, satz3 as (
    select 
    ID
    , Bemerkung
    , Bemerkung3
        -- , length(Bemerkung3)
        -- , locate(']', Bemerkung3)
    , substring(Bemerkung3, 1, ( locate(']', Bemerkung3) )) as Bemerkung4
   from satz2 
)
select ID
    , REPLACE(REPLACE(REPLACE(Bemerkung4, 'Übung:', ''), '[',''), ']', '') as Uebung
    , Bemerkung
from satz3 



; 
create or replace view v_tmp_Uebung
as
select distinct NULL as ID, Uebung
from v_satz_tmp_Uebung
order by Uebung
