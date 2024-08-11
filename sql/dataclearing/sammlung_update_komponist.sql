/*
allen Musikstücken einer Sammlung soll der gleiche Komponist zugeordnet werden 
Vorlage ist der Komponist am Musikstück Nummer 1 

*/

update musikstueck as m 
inner join 
(
    SELECT SammlungID, min(KomponistID) KomponistID_ref
    from musikstueck 
    WHERE Nummer=1 
    and KomponistID IS NOT NULL 
    AND SammlungID = 274 
    group by SammlungID
) m_ref
on m.SammlungID = m_ref.SammlungID 
set m.KomponistID = m_ref.KomponistID_ref
where m.SammlungID = 274 
and m.KomponistID IS NULL