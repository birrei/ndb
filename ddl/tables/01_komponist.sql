CREATE TABLE `komponist` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Nachname` varchar(14) DEFAULT NULL,
  `Vorname` varchar(23) DEFAULT NULL,
  `Geburtsdatum` varchar(10) DEFAULT NULL,
  `Sterbedatum` varchar(10) DEFAULT NULL,
  `Geburtsjahr` varchar(6) DEFAULT NULL,
  `Sterbejahr` varchar(4) DEFAULT NULL,
   PRIMARY KEY (`ID`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
