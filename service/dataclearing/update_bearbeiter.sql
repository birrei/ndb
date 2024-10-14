/*
allen Musikstücken einer Sammlung soll der gleiche Bearbeiter zugeordnet werden
Vorlage: Bearbeiter am Musikstück Nummer 1 

*/

update musikstueck as m 
inner join 
(
    SELECT SammlungID, Bearbeiter as Bearbeiter_ref
    from musikstueck 
    WHERE Nummer=1 
    and COALESCE(Bearbeiter, '') <> ''  
    AND SammlungID = 282 -- XX SammlungID 
    group by SammlungID
) m_ref
on m.SammlungID = m_ref.SammlungID 
set m.Bearbeiter = m_ref.Bearbeiter_ref
where m.SammlungID = 282 -- XX SammlungID 
AND COALESCE(m.Bearbeiter, '') = ''  
