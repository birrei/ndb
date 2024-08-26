/*
in Auswahl soll bei allen Schwierigkeitsgraden ein bestimmtes Instrument 
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

    WHERE 1=1 
    and musikstueck.SammlungID = 280
    and satz_schwierigkeitsgrad.InstrumentID = 12 -- Violine 1
    and satz_schwierigkeitsgrad.InstrumentID <> 17 -- Ersetzer (Einschränkung wg. dubletten-Vermeidung)
) ref 
on ref.ID = s.ID 
set s.InstrumentID =  17


-- ID	Name	Bearbeiten
-- 1	Orchester	Bearbeiten
-- 2	Beuchofonium	Bearbeiten
-- 8	Posaune	Bearbeiten



on 
