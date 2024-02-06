
CREATE TABLE `sammlung` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` varchar(56) DEFAULT NULL,
  `Standort` varchar(50) DEFAULT NULL,
  `VerlagID` int(10) UNSIGNED DEFAULT NULL,
  `Bestellnummer` varchar(13) DEFAULT NULL,
  `Bemerkung` varchar(80) DEFAULT NULL, 
   PRIMARY KEY (`ID`)     
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `sammlung` ADD  FOREIGN KEY (`VerlagID`) REFERENCES `verlag`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;#

