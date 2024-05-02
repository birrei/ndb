create or replace view v_satz_tmp_uebung as 
select ID
    , REPLACE(REPLACE(REPLACE(Bemerkung4, 'Übung:', ''), '[',''), ']', '') as Uebung
    , Bemerkung
from 
    (
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
            )  satz1 
        ) satz2 
    ) satz3 



; 
create or replace view v_tmp_uebung
as
select distinct NULL as ID, Uebung
from v_satz_tmp_uebung
order by Uebung
