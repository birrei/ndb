SELECT f.ID 
    , f.Bezeichnung 
    , f.Datum 
    , s.Bezeichnung AS Schuljahr 
    , f.Bundesland           
FROM schuljahr s 
    INNER JOIN feiertag f on f.SchuljahrID = s.ID 
WHERE 1=1