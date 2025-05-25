

-- dev -- danach verworfen 
-- CREATE TABLE `ndbsettings` (
--   `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
--   `Name` varchar(100) NULL, -- Name der Einstellung, frei wählbar 
--   `set_key` varchar(50) NULL,
--   `set_value` varchar(50) NULL,
--   `ts_insert` datetime DEFAULT current_timestamp(),
--   `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
--   PRIMARY KEY (`ID`), 
--   CONSTRAINT UC_dbsettings_set_key UNIQUE (set_key)
-- ) 


-- INSERT ndbsettings (Name, set_key, set_value) 
-- VALUES('Schüler Übung Satz/Material - StatusID Aktiv', 'StatusID_Aktiv', 4); 

-- INSERT ndbsettings (Name, set_key, set_value) 
-- VALUES('Schüler Übung Satz/Material - StatusID Standard', 'StatusID_default', 1);


-- select * from ndbsettings ;


-- -- update ndbsettings 
-- -- set Name='Schüler Übung Satz/Material - StatusID Aktiv', 
-- -- set_key='StatusID_Aktiv'
-- -- WHERE ID=1