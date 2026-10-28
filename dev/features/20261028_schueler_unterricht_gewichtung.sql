
-- ALTER TABLE schueler DROP COLUMN IF EXISTS Unterricht_Gewichtung; -- nur MariaDB

ALTER TABLE schueler DROP COLUMN Unterricht_Gewichtung; 

ALTER TABLE schueler ADD Unterricht_Gewichtung DECIMAL(3, 2) DEFAULT 1;  

SELECT ID, Name, Unterricht_Gewichtung FROM schueler ORDER BY Unterricht_Gewichtung  ; 



