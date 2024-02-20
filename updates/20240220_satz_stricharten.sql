/* 
Umwandlung Feld satz.Stricharten zu Unterauswahl 
*/ 

CREATE TABLE IF NOT EXISTS `strichart`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB; 

CREATE TABLE IF NOT EXISTS `satz_strichart` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `StrichartID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB;

ALTER TABLE `satz_strichart` 
ADD CONSTRAINT uc_satz_strichart 
UNIQUE (SatzID, StrichartID);

ALTER TABLE `satz_strichart` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `satz_strichart` 
    ADD  FOREIGN KEY (`StrichartID`) 
    REFERENCES `strichart`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT;


/**********************************************************/

/* Daten übernehmen */ 

-- view distinct stricharten 
create or REPLACE view tmp_Stricharten as 
select distinct Stricharten from satz 
where Stricharten is not null 
and  Stricharten <> ''
order by Stricharten ; 


create or REPLACE view tmp_Stricharten_split as 
SELECT SPLIT_STRING(Stricharten, ',', 1) as Strichart
FROM satz 
WHERE Stricharten is not null and Stricharten <> ''
UNION 
SELECT SPLIT_STRING(Stricharten, ',', 2)
FROM satz 
WHERE Stricharten is not null and Stricharten <> ''
UNION 
SELECT SPLIT_STRING(Stricharten, ',', 3)
FROM satz 
WHERE Stricharten is not null and Stricharten <> ''
UNION 
SELECT SPLIT_STRING(Stricharten, ',', 4)
FROM satz 
WHERE Stricharten is not null and Stricharten <> ''
ORDER BY Strichart

;

insert into strichart (Name)
select * from tmp_Stricharten_split 
where Strichart is not null 
and Strichart <> ''
; 

--- Test + Matrial für asoc-Tabelle 
select s.ID, s.Name satz_name, s.Stricharten, sa.Name 
from satz s
left join strichart sa
on ( 
        SPLIT_STRING(s.Stricharten, ',', 1)=sa.Name 
        or 
        SPLIT_STRING(s.Stricharten, ',', 2)=sa.Name 
        or 
        SPLIT_STRING(s.Stricharten, ',', 3)=sa.Name 
        or 
        SPLIT_STRING(s.Stricharten, ',', 4)=sa.Name 
) 
where s.Stricharten is not null 
and s.Stricharten <> ''
order by s.ID 



-- SELECT distinct 
-- TRIM(SUBSTRING_INDEX(Stricharten, ',',1))  
-- FROM `satz` 
-- WHERE Stricharten is not null 
-- and Stricharten <> '' 

-- SELECT distinct 
-- TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  
-- FROM `satz` 
-- WHERE Stricharten is not null 
-- and Stricharten <> '' 
-- ; 

