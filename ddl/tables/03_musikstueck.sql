CREATE TABLE `musikstueck` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) DEFAULT NULL,
  `Opus` varchar(50) DEFAULT NULL,
  `SammlungID` int(10) UNSIGNED DEFAULT NULL,
  `Nummer` smallint(2) DEFAULT NULL,
  `KomponistID` int(10) UNSIGNED DEFAULT NULL,
  `Bearbeiter` varchar(26) DEFAULT NULL,
  `Epoche` varchar(18) DEFAULT NULL,
  `Verwendungszweck` varchar(100) DEFAULT NULL,
  `Gattung` varchar(29) DEFAULT NULL,
  `Besetzung` varchar(58) DEFAULT NULL,
  `JahrAuffuehrung` varchar(25) NOT NULL,
   PRIMARY KEY (`ID`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `musikstueck` ADD  FOREIGN KEY (`KomponistID`) REFERENCES `komponist`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

