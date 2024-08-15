/*
Allen Musikstücken einer Sammlung soll eine definierte Besetzung zugeordnet werden 
(falls diese nicht bereits vorhanden ist) 
*/


/*
09.08.2024 

zu ergänzende Besetzung: 
1	Violine und Klavier
*/


insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select musikstueck.ID
      , 1 as BesetzungID -- XXX ID der zu ergänzenden Besetzung  
from sammlung 
inner join musikstueck on sammlung.ID = musikstueck.SammlungID
left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID
and musikstueck_besetzung.BesetzungID =1  -- XXX ID der zu ergänzenden Besetzung  
left join besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
where sammlung.ID =276 -- ID der Sammlung XX! 
and musikstueck_besetzung.BesetzungID IS NULL; 

