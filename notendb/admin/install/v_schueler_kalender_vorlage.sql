CREATE OR REPLACE VIEW v_schueler_kalender_vorlage AS 

SELECT schueler.ID as SchuelerID 
	, schueler.Name 
	, kalender.Datum
	, kalender.Wochentag_Name 
	, ferien.Bezeichnung AS Ferientag 
	, feiertag.Bezeichnung AS Feiertag 
	, schuljahr.Bezeichnung AS Schuljahr      
	  , IF(Unterricht_Geplant=1, 'X' , '') as `Unterricht Geplant` 	
	  , uebungen.Anzahl_Uebungen 
	  , CASE 
		  -- Entweder Ferientag oder Feiertag 
		  	WHEN ( ferien.ID IS NOT NULL OR feiertag.ID IS NOT NULL)  AND  COALESCE(uebungen.Anzahl_Uebungen,0) = 0
		  		THEN 0
		  	WHEN ( ferien.ID IS NOT NULL OR feiertag.ID IS NOT NULL)  AND  COALESCE(uebungen.Anzahl_Uebungen,0) > 0
		  		THEN 1
		  	-- Weder Ferientag noch Feiertag 
		  	WHEN (ferien.ID IS NULL AND feiertag.ID IS  NULL) 
		  		THEN 1  
		  	ELSE 
	  			-1 
	  		END AS Eintrag 
	  , 'Plankalender aus Schüler-Wochentag' AS Quelle 
FROM schueler 
	INNER JOIN kalender 
		ON kalender.Wochentag_Nr = schueler.Unterricht_Wochentag
	LEFT JOIN schuljahr 
		ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
	LEFT JOIN ferien 
		ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
	LEFT JOIN feiertag 
		ON kalender.Datum = feiertag.Datum
	LEFT JOIN (
		SELECT uebung.SchuelerID, uebung.Datum , Count(*) Anzahl_Uebungen 
		FROM uebung
		-- WHERE SchuelerID = 32
		GROUP BY  uebung.SchuelerID, uebung.Datum
		) uebungen
		ON schueler.ID = uebungen.SchuelerID 
		AND kalender.Datum = uebungen.Datum
-- WHERE schueler.ID=32
WHERE schuljahr.ID=3 -- XXXX 
UNION 
-- gehaltene Unterrichtstage ausserhalb des regulären Wochentags 
SELECT schueler.ID 
	, schueler.Name 
	, uebungen.Datum
	, uebungen.Wochentag_Name 
	, uebungen.Ferientag  
	, uebungen.Feiertag   
	, uebungen.Schuljahr   	
   , IF(uebungen.Unterricht_Geplant=1, 'X' , '') as `Unterricht Geplant` 
   , uebungen.Anzahl_Uebungen
   , 1 as Eintrag  
   , 'Erfasste Unterrichte (Übungen)' AS Quelle    
FROM schueler 
	INNER JOIN (
		SELECT uebung.SchuelerID 
				 , kalender.Datum
				, kalender.Wochentag_Nr 
				, kalender.Wochentag_Name 
				, kalender.Unterricht_Geplant 
				, ferien.Bezeichnung AS Ferientag 
				, feiertag.Bezeichnung AS Feiertag 
				, schuljahr.Bezeichnung AS Schuljahr 			
				, Count(*) Anzahl_Uebungen 
		FROM uebung
		INNER JOIN kalender ON uebung.Datum=kalender.Datum 
		LEFT JOIN schuljahr 
			ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
		LEFT JOIN ferien 
			ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
		LEFT JOIN feiertag 
			ON kalender.Datum = feiertag.Datum
		-- WHERE uebung.SchuelerID = 32
		WHERE schuljahr.ID=3 -- XXXX 
		GROUP BY uebung.SchuelerID, uebung.Datum		
	) uebungen
	ON uebungen.SchuelerID = schueler.ID 
	AND uebungen.Wochentag_Nr <> schueler.Unterricht_Wochentag
-- where schueler.ID=32
ORDER BY Datum 



