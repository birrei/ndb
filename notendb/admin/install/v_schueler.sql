CREATE or REPLACE view v_schueler as 
select schueler.ID 
    , schueler.Name
    , schueler.Bemerkung       
    , v_schueler_instrumente.Instrumente  
    , IF(schueler.Aktiv=1, 'Ja', 'Nein') as Aktiv_JN
FROM schueler 
   LEFT JOIN  v_schueler_instrumente 
    ON v_schueler_instrumente.SchuelerID = schueler.ID 
order by schueler.Name 

/*
, GROUP_CONCAT(DISTINCT 
        IF(sm.ID is not null
                , CONCAT('* ', sm.Name, ': ', material.Name)
                , CONCAT('* ', material.Name)
                ) 
        order by 
            IF(sm.ID is not NULL, CONCAT(sm.Name, ': ', material.Name), material.Name)
        SEPARATOR '<br />') as Materialien
    , GROUP_CONCAT(
        DISTINCT concat('* ', sammlung.Name, ' / ', musikstueck.Name, 
                    IF(satz.Name <> '', CONCAT(' / ', satz.Name), ''), 
                    IF(schueler_satz.StatusID is not null, CONCAT(' / Status: ', status.Name), ''),
                    IF(schueler_satz.Bemerkung <> '', CONCAT(' / ', schueler_satz.Bemerkung), '')
        )  
        order by sammlung.Name, musikstueck.Nummer 
        SEPARATOR '<br />') as Noten 
*/