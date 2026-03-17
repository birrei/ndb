
    DROP TABLE kalender; 

    CREATE TABLE kalender (
        datum DATE PRIMARY KEY,
        wochentag_nr TINYINT NOT NULL, -- 1 (So) bis 7 (Sa) oder 0-6
        wochentag_name VARCHAR(12) NOT NULL, 
        kalenderwoche VARCHAR(10) NOT NULL
    )


select * from kalender k  
-- where k.datum between '2020-12-01' and '2021-01-31' 
order by datum 


-- Achtung 
-- datum	wochentag_nr	wochentag_name	kalenderwoche
-- 2020-12-28	1	Montag	53
-- 2020-12-29	2	Dienstag	53
-- 2020-12-30	3	Mittwoch	53
-- 2020-12-31	4	Donnerstag	53

-- 2021-01-01	5	Freitag	53
-- 2021-01-02	6	Samstag	53
-- 2021-01-03	7	Sonntag	53




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