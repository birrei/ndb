
ALTER TABLE schueler DROP COLUMN IF EXISTS Unterricht_Dauer; -- nur MariaDB

ALTER TABLE schueler ADD Unterricht_Dauer TINYINT DEFAULT 0 ;   



