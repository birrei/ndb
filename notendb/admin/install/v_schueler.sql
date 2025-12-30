CREATE or REPLACE view v_schueler as 
SELECT schueler.ID 
    , schueler.Name
    , schueler.Bemerkung       
    , v_schueler_instrumente.Instrumente  
    , IF(schueler.Aktiv=1, 'Ja', 'Nein') as Aktiv_JN  
FROM schueler 
   LEFT JOIN  v_schueler_instrumente ON v_schueler_instrumente.SchuelerID = schueler.ID 
   LEFT JOIN uebung ON schueler.ID = uebung.SchuelerID 
GROUP By schueler.ID 
ORDER BY schueler.Name 

