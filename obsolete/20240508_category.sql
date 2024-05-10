--- verworfen 

-- drop TABLE IF EXISTS category
-- ; 

-- CREATE TABLE IF NOT EXISTS `category`   
-- (`ID` TINYINT NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , Relation  VARCHAR(20) NOT NULL /* = Zordnungs-Tabelle, z.B. 'musikstueck', 'satz', ... */
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB
-- ; 

-- INSERT INTO category (Name, Relation) VALUES('Verwendungszweck', 'musikstueck') ;
-- INSERT INTO category (Name, Relation) VALUES('Besetzung', 'musikstueck') ;
-- INSERT INTO category (Name, Relation) VALUES('Epoche', 'musikstueck') ;
-- INSERT INTO category (Name, Relation) VALUES('Gattung', 'musikstueck') ;
-- INSERT INTO category (Name, Relation) VALUES('Erprobt', 'satz') ;
-- INSERT INTO category (Name, Relation) VALUES('Notenwert', 'satz') ;
-- INSERT INTO category (Name, Relation) VALUES('Schwierigkeitsgrad', 'satz') ;
-- INSERT INTO category (Name, Relation) VALUES('Strichart', 'satz') ;
-- INSERT INTO category (Name, Relation) VALUES('Übung', 'satz') ;
-- INSERT INTO category (Name, Relation) VALUES('Melodische Besonderheit', 'satz') ;
-- INSERT INTO category (Name, Relation) VALUES('Dynamische Besonderheit', 'satz') ;
-- INSERT INTO category (Name, Relation) VALUES('Rhythmische Besonderheit ', 'satz') ;

-- select * from category; 


/*
-----------------------------
Nicht: 
    verlag
    komponist
    standort
(da diese Tabellen - neben ID und Name - noch weitergehende Attribute besitzen)
*/

