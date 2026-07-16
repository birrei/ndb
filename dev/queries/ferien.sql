SELECT f.ID 
          , f.Bezeichnung 
          , f.Datum_Start  AS `Datum von` 
          , f.Datum_Ende  AS `Datum bis` 
          , s.Bezeichnung AS Schuljahr 
          , f.Bundesland 
          -- , s.Datum_Start  as `Datum Schuljahr von` 
          -- , s.Datum_Ende  as `Datum Schuljahr bis` 
FROM schuljahr s 
    INNER JOIN  ferien f on f.SchuljahrID = s.ID 
WHERE 1=1 