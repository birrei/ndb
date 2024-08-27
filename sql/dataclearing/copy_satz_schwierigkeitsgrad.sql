/*
Schwierigkeitsgrad eines Instruments soll für ein anderes Instrument kopiert werden 
*/


insert into satz_schwierigkeitsgrad (SatzID, InstrumentID, SchwierigkeitsgradID ) 

SELECT satz_schwierigkeitsgrad.SatzID
  -- , satz_schwierigkeitsgrad.InstrumentID 
  , 2 as InstrumentID_neu -- Orchester 
  , satz_schwierigkeitsgrad.SchwierigkeitsgradID
  -- , ssref.InstrumentID as InstrumentID_ref
from satz
left join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
left join instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
left Join musikstueck on musikstueck.ID = satz.MusikstueckID 
left JOIN satz_schwierigkeitsgrad ssref 
    on  ssref.SatzID = satz_schwierigkeitsgrad.SatzID
    -- and  ssref.InstrumentID = satz_schwierigkeitsgrad.InstrumentID    
    and   ssref.InstrumentID=2
WHERE 1=1 
and musikstueck.SammlungID = 268
and satz_schwierigkeitsgrad.InstrumentID = 12 -- Violine 1
and ssref.InstrumentID IS NULL

order by satz_schwierigkeitsgrad.SatzID

