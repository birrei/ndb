CREATE OR REPLACE VIEW v_musikstueck_besetzungen AS 
SELECT musikstueck_besetzung.MusikstueckID         
    , GROUP_CONCAT(DISTINCT besetzung.Name  ORDER BY besetzung.Name SEPARATOR ', ') Besetzungen       
FROM musikstueck_besetzung 
    LEFT JOIN besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
GROUP BY musikstueck_besetzung.MusikstueckID 




