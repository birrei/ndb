CREATE OR REPLACE VIEW v_musikstueck_verwendungszwecke AS 
SELECT musikstueck_verwendungszweck.MusikstueckID         
    , GROUP_CONCAT(DISTINCT verwendungszweck.Name  ORDER BY verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke     
FROM musikstueck_verwendungszweck 
    LEFT JOIN verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.verwendungszweckID 
GROUP BY musikstueck_verwendungszweck.MusikstueckID 




