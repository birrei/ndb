/*
Allen Musikstücken einer Sammlung soll eine definierte Gattung zugeordnet werden 
Vorlage ist Gattung am Musikstück Nummer 1 

*/

update musikstueck as m 
inner join 
(
    SELECT SammlungID, min(GattungID) GattungID_ref
    from musikstueck 
    WHERE Nummer=1 
    and GattungID IS NOT NULL 
    AND SammlungID = 419  -- XX SammlungID 
    group by SammlungID
) m_ref
on m.SammlungID = m_ref.SammlungID 
set m.GattungID = m_ref.GattungID_ref
where m.SammlungID = 419  -- XX SammlungID 
and m.GattungID IS NULL