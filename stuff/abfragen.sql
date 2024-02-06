/* Thema Musikstück, Besetzung  */

-- Musikstück,  Anzahl Besetzungen 

SELECT m.ID, m.Name, count(distinct b.ID) anzahl_besetzungen  
from musikstueck m 
left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
left join besetzung b on mb.BesetzungID = b.ID
group by  m.ID, m.Name
HAVING count(distinct b.ID) > 1

-- Vergleich Feld "Besetzung" sowie zugehörigen Datensätzen aus Tabelle "besetzung"
SELECT m.ID, m.Name, m.Besetzung, b.Name as b_Besetzung 
from musikstueck m 
left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
left join besetzung b on mb.BesetzungID = b.ID
WHERE m.ID = 36 -- alle Jahre wieder 

-- ... wie zuvor, aber Daten aus  besetzung.Name auf eine Zeile zusammengezogen 
SELECT m.ID, m.Name
    , GROUP_CONCAT(distinct b.Name order by b.Name SEPARATOR '; ')  as Besetzung_b  
from musikstueck m 
left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
left join besetzung b on mb.BesetzungID = b.ID
-- WHERE m.ID = 36 -- alle Jahre wieder 
