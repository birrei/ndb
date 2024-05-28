SELECT CONCAT('DROP VIEW IF EXISTS ', TABLE_NAME, ';') as cmd  
FROM information_schema.TABLES 
WHERE TABLE_TYPE LIKE 'VIEW'; 

select * 
from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
where 1=1
-- and table_schema='test'
and table_name='musikstueck'

/* Spalten einer Tabelle anzeigen */ 
SHOW COLUMNS FROM test.satz; 

/* Musiksstücke und Verwendungszwecke  */
select m.ID as MusikstueckID
    , m.Name as Musikstück 
    , v.ID as VerwendungszweckID
    , v.Name as Verwendungszweck 
from musikstueck m 
left join musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
left join verwendungszweck v on mv.VerwendungszweckID=v.ID 
where mv.ID is not null 
order by m.ID, v.ID 


/* Musikstücke mit mit mehreren Verwendungs-Zwecken */

    select m.ID, count(distinct mv.VerwendungszweckID) anzahl_verwendungszwecke 
    from musikstueck m 
    left join musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
    left join verwendungszweck v on mv.VerwendungszweckID=v.ID 
    where mv.ID is not null 
    group by m.ID 
    having count(distinct mv.VerwendungszweckID) > 1
    order by anzahl_verwendungszwecke DESC 



/* satz und Lookups */


select satz.ID
, satz.Name

FROM 
    satz 

    left join satz_lookup on satz_lookup.SatzID = satz.ID 
    left join lookup on lookup.ID = satz_lookup.LookupID 
    left join lookup_type on lookup_type.ID = lookup.LookupTypeID

group by satz.ID 


        

