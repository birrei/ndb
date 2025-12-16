CREATE OR REPLACE view v_sammlung_standorte as  
SELECT sammlung_standort.SammlungID
	  , GROUP_CONCAT(DISTINCT standort.Name  order by  standort.Name SEPARATOR ', ') Standorte 
FROM sammlung_standort 
INNER JOIN standort 
ON standort.ID = sammlung_standort.StandortID 
GROUP BY sammlung_standort.SammlungID
