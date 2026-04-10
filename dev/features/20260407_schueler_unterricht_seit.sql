
ALTER TABLE schueler DROP IF EXISTS COLUMN Unterricht_Seit; -- nur MariaDB 

ALTER TABLE schueler ADD Unterricht_Seit Date;   


