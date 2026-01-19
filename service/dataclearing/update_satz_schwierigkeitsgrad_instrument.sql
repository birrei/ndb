/*
In einer definierten Sammlung soll bei allen Schwierigkeitsgraden ein bestimmtes Instrument 
durch ein bestimmtes anderes Instrument ersetzt werden. 
*/

update satz_schwierigkeitsgrad 
inner join satz on satz_schwierigkeitsgrad.SatzID = satz.ID 
inner join musikstueck on satz.MusikstueckID = musikstueck.ID 
set InstrumentID=12 -- Violine 
where musikstueck.SammlungID=338  
and satz_schwierigkeitsgrad.InstrumentID = 17 -- Viola



