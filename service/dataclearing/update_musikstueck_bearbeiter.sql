
/* Bearbeiter für def. Sammlung ID nachpflegen: 
   Inhalt Bearbeiter von definiertem Musikstück für alle Musikstücke übernehmen 
*/ 

update musikstueck as m 
-- select m.ID, m.Name, m.Bearbeiter, m_ref.Bearbeiter_ref
inner join 
(
    SELECT SammlungID, Bearbeiter as Bearbeiter_ref
    from musikstueck 
    WHERE Nummer=1 -- ggf ändern, falls nicht passend 
    and COALESCE(Bearbeiter, '') <> ''  
    AND SammlungID = 282 -- XX SammlungID 
    group by SammlungID
) m_ref
on m.SammlungID = m_ref.SammlungID 
set m.Bearbeiter = m_ref.Bearbeiter_ref
WHERE COALESCE(m.Bearbeiter, '') = ''




-- Test 

SELECT SammlungID, Bearbeiter, count(*) as Anzahl 
from musikstueck 
WHERE SammlungID = 282  -- XX SammlungID 
group by SammlungID, Bearbeiter
