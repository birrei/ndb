ALTER TABLE `sammlung` CHANGE `Bemerkung` `Bemerkung` varchar(1000); 
show columns from sammlung; 

ALTER TABLE `satz` CHANGE `Bemerkung` `Bemerkung` varchar(500); 
show columns from satz;

ALTER TABLE `sammlung` CHANGE `Name` `Name` varchar(100); 
show columns from sammlung; 

ALTER TABLE `satz` CHANGE  `Name` `Name` varchar(100); 
show columns from satz;



