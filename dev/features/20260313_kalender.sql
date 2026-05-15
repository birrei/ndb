

DROP TABLE kalender; 

CREATE TABLE kalender (
    ID INT NOT NULL AUTO_INCREMENT, 
   `Name` varchar(100) NOT NULL,      
    Datum DATE ,
    Wochentag_Nr TINYINT NOT NULL, -- 1 (Mo) bis 7 (So)
    Wochentag_Name VARCHAR(12) NOT NULL, 
    Kalenderwoche VARCHAR(10) NOT NULL, 
    Unterricht_Geplant tinyint(1) DEFAULT 0,    
    PRIMARY KEY (`ID`)       
)


select * from kalender order by datum DESC 
