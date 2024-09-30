/*
In einer defnierten Sammlung soll bei allen Schwierigkeitsgraden ein bestimmtes Instrument 
durch ein bestimmtes anderes Instrument ersetzt werden. 
*/

update satz_schwierigkeitsgrad as s 
inner join 
(
    SELECT musikstueck.SammlungID
      , satz_schwierigkeitsgrad.ID 
    from satz
    inner join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
    inner join instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
    inner Join musikstueck on musikstueck.ID = satz.MusikstueckID
    inner join sammlung on sammlung.ID = musikstueck.SammlungID 
    WHERE 1=1 
    and sammlung.StandortID = 6 -- XX 
    -- and musikstueck.SammlungID = 179 -- XX 
    and satz_schwierigkeitsgrad.InstrumentID = 1 -- XX 
    and satz_schwierigkeitsgrad.InstrumentID <> 12 -- XX 
) ref
on ref.ID = s.ID 
set s.InstrumentID =  12 -- XX 

