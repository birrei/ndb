/*
Bei Sammlungen, die zu einem bestimmen Standort gehören, 
soll bei allen Musikstücken eine definierte Besetzung zugeordnet werden  
*/


/*
09.08.2024 

Gegebener Standort:
24	VL 01

zu ergänzende Besetzung: 
1	Violine und Klavier
*/


insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select musikstueck.ID
      , 1 as BesetzungID -- XX! 
from sammlung 
inner join musikstueck on sammlung.ID = musikstueck.SammlungID
left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID
and musikstueck_besetzung.BesetzungID =1  -- XX! 
left join besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
where sammlung.StandortID =24 -- XX! 
and musikstueck_besetzung.BesetzungID IS NULL; 

