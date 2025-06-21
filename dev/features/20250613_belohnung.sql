/*
Belohnung für einen Übung-Typ
XXX 
*/

drop TABLE IF EXISTS belohnung;

CREATE TABLE `belohnung` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NULL,
  `UebungtypID` tinyint(4) DEFAULT NULL,
  `ts_insert` datetime DEFAULT current_timestamp(),
  `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID`)
) 

