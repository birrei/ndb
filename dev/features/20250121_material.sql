
-- erster Testeintrag 


delete from material; 
delete from materialtyp; 

insert into materialtyp (Name) VALUES('Testtyp') ; 
select * from materialtyp ; 

insert into material (Name, MaterialtypID) values ('Testmaterial', 1); 
select * from material ; 

---------------------------

select * from materialtyp ; 
select * from material ; 



----------------- 27.12.2025: MaterialtypID ändern zu TINYINT 


show create table material;

ALTER TABLE material DROP FOREIGN KEY `material_ibfk_1`;

ALTER TABLE material CHANGE `MaterialtypID` `MaterialtypID` TINYINT DEFAULT NULL;

ALTER TABLE material 
ADD  FOREIGN KEY (MaterialtypID) 
REFERENCES materialtyp(ID) 


ALTER TABLE materialtyp CHANGE `ID` `ID` TINYINT AUTO_INCREMENT;

show create table materialtyp;
    

----------------- 03.02.2025: Material soll mit Sammlung verknüpft werden können 

alter table material 
add SammlungID int(10) unsigned null
; 

ALTER TABLE material 
ADD  FOREIGN KEY (SammlungID) 
REFERENCES sammlung(ID) 
ON DELETE RESTRICT ON UPDATE RESTRICT
;

-- show create table material 
-- siehe dann so aus:  
           
-- CREATE TABLE `material` (
--   `ID` int(11) NOT NULL AUTO_INCREMENT,
--   `Name` varchar(100) NOT NULL,
--   `Bemerkung` varchar(255) DEFAULT NULL,
--   `MaterialtypID` int(11) DEFAULT NULL,
--   `ts_insert` datetime DEFAULT current_timestamp(),
--   `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
--   `SammlungID` int(10) unsigned DEFAULT NULL,
--   PRIMARY KEY (`ID`),
--   KEY `MaterialtypID` (`MaterialtypID`),
--   KEY `SammlungID` (`SammlungID`),
--   CONSTRAINT `material_ibfk_1` FOREIGN KEY (`MaterialtypID`) REFERENCES `materialtyp` (`ID`),
--   CONSTRAINT `material_ibfk_2` FOREIGN KEY (`SammlungID`) REFERENCES `sammlung` (`ID`)
-- ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci