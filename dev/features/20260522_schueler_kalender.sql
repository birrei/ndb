


/*
 * 

SELECT * FROM schuljahr


SELECT * FROM v_schueler_kalender_vorlage WHERE SchuelerID = 32 ORDER BY Datum

SELECT * 
FROM v_schueler_kalender_vorlage 
WHERE Eintrag = 1 
AND SchuelerID = 32 
ORDER BY Datum



SELECT * 
FROM v_schueler_kalender_vorlage WHERE 
Eintrag=1 AND SchuelerID = 32 
ORDER BY Datum 

--- Test
SELECT SchuelerID, Datum, count(*) 
FROM v_schueler_kalender_vorlage
GROUP BY SchuelerID, Datum  
HAVING count(*) > 1


 **/

/*

AbsageID -> Absage des Schülers 
Als wesentliche Information / Unterschiedung: 
1: Absage ohne Unterricht nachgeben 
2: Absage mit Unterricht nachgeben 
Der reale Grund kann ggf. im Feld "Bemerkung" abgelegt werden. 

Eine weiter differenzierte Tabelle mit den Absagegründen würde ich hier nicht vorsehen. 



 * */

DROP TABLE `schueler_kalender`; 
CREATE TABLE `schueler_kalender` (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    SchuelerID INT NOT NULL,  
    Datum DATE NOT NULL,
    AbsageID INT NULL DEFAULT 0, 
    Bemerkung VARCHAR(255),
    CONSTRAINT uk_SchuelerID_Datum UNIQUE (SchuelerID,Datum),     
    CONSTRAINT fk_SchuelerID
    FOREIGN KEY (SchuelerID)
    REFERENCES schueler(ID)
    ON DELETE RESTRICT ON UPDATE RESTRICT    
)
;



INSERT INTO schueler_kalender (SchuelerID, Datum) 
SELECT DISTINCT k_v.SchuelerID, k_v.Datum 
FROM v_schueler_kalender_vorlage k_v
	 LEFT JOIN 
	 schueler_kalender k
	 ON k_v.SchuelerID = k.SchuelerID 
	 AND k_v.Datum = k.Datum 
WHERE Eintrag = 1 
AND k.ID IS NULL 
;




SELECT * FROM schueler_kalender 

SELECT * FROM schueler_kalender WHERE SchuelerID=32 ORDER BY Datum DESC 








SELECT schueler.Name AS `Schüler Name`
          , schueler.Bemerkung `Schueler Bemerkung` 
          , kalender.Wochentag_Name 
          -- , IF(schueler.Unterricht_Wochentag=0, '', wochentage.wochentag_name) as   `Unterricht Wochentag`     
          , uebung.Datum 
          , schueler.Unterricht_Reihenfolge as `Unterricht Reihenfolge` 
          , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
          , SUM(uebung.Anzahl ) as `Summe Minuten` 
          , (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) as `Abweichung Dauer` 
          -- , GROUP_CONCAT(uebung.Name, ' (', coalesce(uebungtyp.Name, '') , ')'  order by uebung.Name separator '<br>') Inhalte 
          , GROUP_CONCAT(uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Reihenfolge separator '<br>') `Übungen Inhalte`  
          , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterrichtstag Geplant`                   
    FROM  schueler_kalender
    		INNER JOIN 
    		kalender 
    			ON schueler_kalender.Datum = kalender.Datum 
          	INNER JOIN schueler 
          		ON schueler_kalender.SchuelerID = schueler_kalender.SchuelerID 
    	   	LEFT JOIN uebung 
	   			ON schueler.ID = uebung.SchuelerID 
	   			AND schueler_kalender.Datum = uebung.Datum 
          -- LEFT JOIN wochentage ON wochentage.wochentag_nr = schueler.Unterricht_Wochentag                   
          left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
            WHERE 1=1 
            AND uebung.SchuelerID=32
    GROUP BY schueler.ID, schueler_kalender.Datum  
    ORDER BY uebung.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name                     

