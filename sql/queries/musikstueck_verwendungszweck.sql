
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

