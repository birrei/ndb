

CREATE TABLE IF NOT EXISTS `schwierigkeitsgrad`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 


select * from schwierigkeitsgrad
; 

insert into schwierigkeitsgrad (Name)
select Schwierigkeitsgrad 
from v_tmp_Schwierigkeitsgrad
order by Schwierigkeitsgrad
;
select * from schwierigkeitsgrad
;


ALTER TABLE `satz` ADD `SchwierigkeitsgradID` INT NULL

;
update satz
inner join schwierigkeitsgrad  
on COALESCE(satz.Schwierigkeitsgrad, '') = schwierigkeitsgrad.Name 
set satz.SchwierigkeitsgradID = schwierigkeitsgrad.ID
where COALESCE(satz.Schwierigkeitsgrad, '') <> ''
; 

-- /* Test */ 
select satz.ID as SatzID
    , satz.Schwierigkeitsgrad
    , schwierigkeitsgrad.ID as SchwierigkeitsgradID
    , schwierigkeitsgrad.Name Schwierigkeitsgrad_Name
from satz left join schwierigkeitsgrad
on satz.SchwierigkeitsgradID = schwierigkeitsgrad.ID 
where COALESCE(satz.Schwierigkeitsgrad, '') <> ''
order by satz.ID 
;


ALTER TABLE `satz` CHANGE `SchwierigkeitsgradID` `SchwierigkeitsgradID` INT(11) UNSIGNED NULL DEFAULT NULL
;

ALTER TABLE `satz` 
ADD  FOREIGN KEY (`SchwierigkeitsgradID`) 
REFERENCES `schwierigkeitsgrad`(`ID`) 
ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz` DROP `Schwierigkeitsgrad`;

DROP VIEW v_tmp_Schwierigkeitsgrad



