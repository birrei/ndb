-- Version aus show_table4.php (obsolete)
      
SELECT
	schueler.ID AS SchuelerID 
	, schueler.Name as `Schüler` 
  , kalender.Datum
  , kalender.Wochentag_Name as Wochentag
  , CASE 
    WHEN ( ferien.ID IS NOT NULL OR feiertag.ID IS NOT NULL)  		-- Entweder Ferientag oder Feiertag 
	  THEN 0
	WHEN (ferien.ID IS NULL AND feiertag.ID IS  NULL) 		-- Weder Ferientag noch Feiertag 
	  THEN 1  
	ELSE 
  -1 -- Fehler, sollte nicht vorkommen 
    END AS Eintrag
  , GROUP_CONCAT(COALESCE(feiertag.Bezeichnung, ''), ' ', COALESCE(ferien.Bezeichnung, '')  SEPARATOR ',') AS `Nicht-Eintrag Ausschlussgrund`      
  , schuljahr.Bezeichnung AS Schuljahr  
FROM schueler 
  INNER JOIN kalender 
    ON kalender.Wochentag_Nr = schueler.Unterricht_Wochentag
  INNER JOIN schuljahr 
    ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
  LEFT JOIN ferien 
    ON ferien.SchuljahrID = schuljahr.ID  
    AND kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
  LEFT JOIN feiertag 
    ON feiertag.SchuljahrID = schuljahr.ID 
    AND kalender.Datum = feiertag.Datum 
WHERE schueler.Aktiv =1  
        AND  (ferien.ID IS NULL AND feiertag.ID IS  NULL) -- Eintrag ja (weder Ferien noch Feiertag )
        -- AND ferien.ID IS NOT NULL OR feiertag.ID IS NOT NULL -- Eintrag nein, weil Ferien oder Feiertag 
GROUP BY schueler.ID, kalender.Datum 
ORDER BY schueler.ID, kalender.Datum 



--- Befüllung 

/*
 * 
-- INSERT INTO schueler_kalender (SchuelerID, Datum )           
SELECT schueler.ID AS SchuelerID, kalender.Datum
-- SELECT schueler.ID AS SchuelerID , schueler.Name as `Schüler` , kalender.Datum, kalender.Wochentag_Name as Wochentag 
FROM schueler 
  INNER JOIN kalender 
    ON kalender.Wochentag_Nr = schueler.Unterricht_Wochentag
  INNER JOIN schuljahr 
    ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
  LEFT JOIN (
  	SELECT schueler_kalender.SchuelerID , schueler_kalender.Datum 
  	FROM schueler_kalender 
  	INNER JOIN schuljahr 
  	ON schueler_kalender.Datum  BETWEEN schueler_kalender.Datum  AND schueler_kalender.Datum 
  	AND schuljahr.ID=4 
  ) AS  schueler_kalender_vorhanden 
  ON schueler.ID = schueler_kalender_vorhanden.SchuelerID 
  AND kalender.Datum  = schueler_kalender_vorhanden.Datum 
  LEFT JOIN ferien 
    ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
    AND ferien.SchuljahrID = schuljahr.ID  
  LEFT JOIN feiertag 
    ON kalender.Datum = feiertag.Datum 
    AND  feiertag.SchuljahrID = schuljahr.ID 
WHERE schueler.Aktiv =1  
AND schueler_kalender_vorhanden.Datum IS NULL -- schon vorhandene Einträge ausschließen 
AND schuljahr.ID=4
AND  (ferien.ID IS NULL AND feiertag.ID IS  NULL) 
GROUP BY kalender.Datum, schueler.ID 
ORDER BY schueler.ID, kalender.Datum


 * */