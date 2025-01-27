
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
    

