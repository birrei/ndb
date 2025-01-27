show create table lookup;

ALTER TABLE lookup CHANGE `LookupTypeID` `LookupTypeID` tinyint DEFAULT NULL;

ALTER TABLE lookup 
ADD  FOREIGN KEY (LookupTypeID) 
REFERENCES lookup_type(ID) 


