/* 
Umwandlung Feld satz.Notenwerte zu Unterauswahl 
*/ 

CREATE TABLE IF NOT EXISTS `notenwert`   
(`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 

CREATE TABLE IF NOT EXISTS `satz_notenwert` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `NotenwertID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

ALTER TABLE `satz_notenwert` 
ADD CONSTRAINT uc_satz_notenwert 
UNIQUE (SatzID, NotenwertID)
;

ALTER TABLE `satz_notenwert` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_notenwert` 
    ADD  FOREIGN KEY (`NotenwertID`) 
    REFERENCES `notenwert`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

select * from notenwert; 
select * from satz_notenwert; 


/**********************************************************/

/* Daten übernehmen */ 

-- view distinct notenwerten 
-- create or REPLACE view tmp_Notenwerte as 
-- select distinct Notenwerte from satz 
-- where Notenwerte is not null 
-- and  Notenwerte <> ''
-- order by Notenwerte ; 


-- Sichtprüfung 
-- select * from tmp_Notenwerte order by Notenwerte 


---- zusätzliches Komma entfernen 
-- Update satz 
-- set Notenwerte ='Détaché, Legato, Martélé breites' 
-- WHERE ID=54 
-- AND Notenwerte='Détaché, Legato, Martélé, breites'


/*prüfen, wie oft ein Kommatrenner vorkommt */ 

SELECT Notenwerte
, CHAR_LENGTH(Notenwerte) - CHAR_LENGTH(REPLACE(Notenwerte, ',', '')) as anzahl 
FROM satz 
WHERE Notenwerte LIKE '%,%'

/* befüllungsview (Anzahl Abfragen entspr. Anzahl Kommas) */

create or REPLACE view tmp_Notenwerte_split as 
SELECT SPLIT_STRING(Notenwerte, ',', 1) as Strichart
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 2)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 3)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 4)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 5)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 6)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 7)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 8)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 9)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT SPLIT_STRING(Notenwerte, ',', 10)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
ORDER BY Strichart


-- ;

/* Tabelle "notenwert" befüllen */ 
insert into notenwert (Name)
select Strichart from tmp_Notenwerte_split 
where coalesce(Strichart,'') <> ''; 

select * from notenwert



create or REPLACE view tmp_satz_Notenwerte_split as 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 1) as Notenwert
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 2)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 3)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 4)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 5)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 6)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 7)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 8)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 9)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
UNION 
SELECT ID, Notenwerte, SPLIT_STRING(Notenwerte, ',', 10)
FROM satz 
WHERE Notenwerte is not null and Notenwerte <> ''
ORDER BY Notenwert

; 

insert into satz_notenwert (SatzID, NotenwertID) 
select distinct tmp.ID, n.ID 
--     tmp.ID
-- , tmp.Notenwerte
-- , tmp.Notenwert 
-- , n.ID as notenwertID 
-- , n.Name as NotenwertName
from tmp_satz_Notenwerte_split as tmp 
inner join 
notenwert n 
on tmp.Notenwert = n.Name
order by tmp.ID
; 

select * from satz_notenwert
; 

select satz.ID
    , satz.Notenwerte
    , notenwert.ID as NotenwertID
    , notenwert.Name 
from satz 
left JOIN satz_notenwert on satz.ID = satz_notenwert.SatzID
left join notenwert on satz_notenwert.NotenwertID = notenwert.ID 





/* altes Feld "notenwerten" entfernen */

-- ALTER TABLE `satz` DROP `Notenwerte`;
