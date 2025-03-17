/*
Allen Musikstücken einer Sammlung soll eine definierte Epoche zugeordnet werden 
Vorlage ist Epoche am Musikstück Nummer 1 

*/


update musikstueck as m 
inner join 
(
    SELECT SammlungID, min(EpocheID) EpocheID_ref
    from musikstueck 
    WHERE Nummer=1 
    and EpocheID IS NOT NULL 
    AND SammlungID = 419  -- XX SammlungID 
    group by SammlungID
) m_ref
on m.SammlungID = m_ref.SammlungID 
set m.EpocheID = m_ref.EpocheID_ref
where m.SammlungID = 419  -- XX SammlungID 
and m.EpocheID IS NULL