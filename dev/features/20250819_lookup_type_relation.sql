drop TABLE IF EXISTS lookuptype_relation;

drop TABLE IF EXISTS relation;

CREATE TABLE `relation` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NULL,
  `ts_insert` datetime DEFAULT current_timestamp(),
  `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID`)
); 


drop TABLE IF EXISTS lookuptype_relation;
CREATE TABLE `lookuptype_relation` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `LookuptypeID` tinyint(4) DEFAULT NULL,
  `RelationID` tinyint(4) DEFAULT NULL,  
  `ts_insert` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ; 


ALTER TABLE lookuptype_relation
ADD CONSTRAINT uc_lookuptype_relation
UNIQUE (LookuptypeID, RelationID) 
;


ALTER TABLE lookuptype_relation 
    ADD  FOREIGN KEY (LookuptypeID) 
    REFERENCES lookup_type(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE lookuptype_relation 
    ADD  FOREIGN KEY (RelationID) 
    REFERENCES relation(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;	

insert into relation (Name) values('satz'); 
insert into relation (Name) values('sammlung'); 
insert into relation (Name) values('musikstueck'); 
insert into relation (Name) values('material'); 

-- select * from relation;
-- select * from lookup_type lt ; 
-- select * from lookuptype_relation;

insert into lookuptype_relation (LookuptypeID, RelationID)
select lt.ID , r.ID 
from relation r 
inner join lookup_type lt 
	on lt.Relation = r.Name; 



