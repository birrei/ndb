
DROP TABLE kalender; 

CREATE TABLE kalender (
    datum DATE PRIMARY KEY,
    wochentag_nr TINYINT NOT NULL, -- 1 (So) bis 7 (Sa) oder 0-6
    wochentag_name VARCHAR(12) NOT NULL, 
    kalenderwoche VARCHAR(10) NOT NULL
)


select * from kalender order by datum DESC 


-- CREATE TABLE kalender (
--     datum DATE PRIMARY KEY,
--     jahr INT NOT NULL,
--     quartal TINYINT NOT NULL,
--     monat TINYINT NOT NULL,
--     tag TINYINT NOT NULL,
--     tag_name VARCHAR(10) NOT NULL,
--     wochentag TINYINT NOT NULL, -- 1 (So) bis 7 (Sa) oder 0-6
--     kalenderwoche TINYINT NOT NULL,
--     ist_wochenende BOOLEAN NOT NULL,
--     monat_name VARCHAR(15) NOT NULL,
--     quartal_name CHAR(2) NOT NULL -- Q1, Q2, etc.
-- ) 

--  https://gemini.google.com/share/8a13ae377b1d