CREATE OR REPLACE VIEW v_satz_instrumente_schwierigkeitsgrade AS        
SELECT satz_schwierigkeitsgrad.SatzID 
     , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  
        ORDER BY schwierigkeitsgrad.Name SEPARATOR ', ') as Schwierigkeitsgrade                   
FROM satz_schwierigkeitsgrad 
LEFT JOIN instrument_schwierigkeitsgrad 
      ON instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
      AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
GROUP BY satz_schwierigkeitsgrad.SatzID 
    

