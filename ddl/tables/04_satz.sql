
CREATE TABLE `satz` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `MusikstueckID` int(10) UNSIGNED DEFAULT NULL,
  `Name` varchar(32) DEFAULT NULL,
  `Nr` int(1) DEFAULT NULL,
  `Tonart` varchar(14) DEFAULT NULL,
  `Taktart` varchar(14) DEFAULT NULL,
  `Tempobezeichnung` varchar(31) DEFAULT NULL,
  `Spieldauer` varchar(3) DEFAULT NULL,
  `Schwierigkeitsgrad` varchar(5) DEFAULT NULL,
  `Lagen` varchar(7) DEFAULT NULL,
  `Stricharten` varchar(64) DEFAULT NULL,
  `Erprobt` varchar(12) DEFAULT NULL,
  `Bemerkung` varchar(162) DEFAULT NULL,
  `Notenwerte` varchar(129) DEFAULT NULL,
   PRIMARY KEY (`ID`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `satz` ADD FOREIGN KEY (`MusikstueckID`) REFERENCES `musikstueck`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

