
-- unterricht an einem Feiertag / Ferientag? 

  SELECT schueler_kalender.Datum       
          , kalender.Wochentag_Name as Wochentag     
          , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
          , SUM(uebung.Anzahl ) as `Summe Minuten` 
          , (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) as `Abweichung Dauer` 
          , GROUP_CONCAT(uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Reihenfolge separator '<br>') `Übungen Inhalte`  
          , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterrichtstag Geplant`   
          , ferien.Bezeichnung AS Ferientag 
          , feiertag.Bezeichnung AS Feiertag 
          , schuljahr.Bezeichnung AS Schuljahr                          
    FROM  schueler_kalender
    		INNER JOIN 
    		kalender 
            ON schueler_kalender.Datum = kalender.Datum         
        INNER JOIN schueler 
            ON schueler.ID= schueler_kalender.SchuelerID 
        LEFT JOIN schuljahr 
          ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
        LEFT JOIN ferien 
          ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
        LEFT JOIN feiertag 
          ON kalender.Datum = feiertag.Datum             
        LEFT JOIN uebung 
            ON schueler.ID = uebung.SchuelerID 
            AND schueler_kalender.Datum = uebung.Datum                  
        LEFT join uebungtyp 
            ON uebung.UebungtypID=uebungtyp.ID 
        WHERE  (ferien.ID IS NOT NULL OR feiertag.ID IS NOT NULL) 
        GROUP BY schueler.ID, schueler_kalender.Datum  
        HAVING COUNT(DISTINCT uebung.ID) > 0         
        -- ORDER BY schueler_kalender.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name     
        

       