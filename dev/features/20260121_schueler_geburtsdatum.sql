
ALTER TABLE schueler DROP IF EXISTS COLUMN Geburtsdatum; -- nur MariaDB 

ALTER TABLE schueler ADD Geburtsdatum Date;   


