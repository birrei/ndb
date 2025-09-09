CREATE OR REPLACE VIEW v_material_instrumente_schwierigkeitsgrade AS        
SELECT material_schwierigkeitsgrad.MaterialID 
     , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  
        ORDER BY schwierigkeitsgrad.Name SEPARATOR ', ') as Schwierigkeitsgrade                   
FROM material_schwierigkeitsgrad 
LEFT JOIN instrument_schwierigkeitsgrad 
      ON instrument_schwierigkeitsgrad.InstrumentID = material_schwierigkeitsgrad.InstrumentID
      AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = material_schwierigkeitsgrad.SchwierigkeitsgradID
LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = material_schwierigkeitsgrad.SchwierigkeitsgradID 
LEFT JOIN instrument on instrument.ID = material_schwierigkeitsgrad.InstrumentID 
GROUP BY material_schwierigkeitsgrad.MaterialID 
    

