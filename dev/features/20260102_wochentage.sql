DROP TABLE IF EXISTS wochentage; 

CREATE TABLE wochentage (
    wochentag_id INT PRIMARY KEY AUTO_INCREMENT, -- Eindeutige ID
    wochentag_name VARCHAR(50) NOT NULL,         -- Name des Tages (z.B. 'Montag')
    wochentag_nr tinyint UNIQUE NOT NULL          -- Index 0=Mo, 6=So (WEEKDAY())
);

INSERT INTO wochentage (wochentag_name, wochentag_nr ) 
VALUES
('(nicht ausgewählt)',0),
('Montag',1),
('Dienstag', 2),
('Mittwoch', 3),
('Donnerstag', 4),
('Freitag',5),
('Samstag', 6),
('Sonntag', 7);


select * from wochentage;

-- 3. Beispiel für die Nutzung (Wochentag aus Datum ermitteln)


SELECT
    wochentag_name,
    DAYOFWEEK(CURRENT_DATE()) AS tag_als_zahl, -- Aktueller Tag als Zahl (1=So)
    WEEKDAY(CURRENT_DATE()) AS tag_als_index  -- Aktueller Tag als Index (0=Mo)
FROM wochentage
WHERE wochentag_index_weekday = WEEKDAY(CURRENT_DATE());


