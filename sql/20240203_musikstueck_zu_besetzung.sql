/* 
Erstellung Tabelle "besetzung"
    --> ddl\tables\01_besetzung.sql
Erstellung Tabelle "musikstueck_besetzung"
    --> 10_musikstueck_besetzung.sql
Befüllung Tabelle "besetzung" aus Feld Inhalt von "musikstueck.Besetzung"
Befüllung Tabelle "musikstueck_besetzung"

*/




/* 
Befüllung  Tabelle Besetzung 
Quelle: Inhalt Spalte musikstueck.Besetzung, dort sind mehrere Besetzungen durch Semikolons geteilt eingetragen.
Pro Feld gibt es max. 3 separate Einträge 
*/ 

/*
1. 
Teil vor dem 1. Komma 
*/

INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung 
TRIM(SUBSTRING_INDEX(Besetzung, ';',1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and Besetzung <> '' 
and TRIM(SUBSTRING_INDEX(Besetzung, ';',1)) not in (select Name from besetzung ); 

-- demo: 9 Zeilen 


/*
2.: Teil nach dem letzten Semikolon
*/
INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung 
TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and Besetzung <> '' 
and TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  not in (
select Name from besetzung 
)
; 
-- demo: 4 Zeilen 



/*
3.: Teil nach dem 1. und vor dem 2. Semikolon 

*/
INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung,  
TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and Besetzung <> '' 
and TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))    not in (select Name from besetzung )
; 
-- demo: 1 Zeile 



/* test match, insert musikstueck_besetzung */ 
delete from musikstueck_besetzung; 

insert into musikstueck_besetzung (MusikstueckID, BesetzungID) 
SELECT DISTINCT m.ID as MusikstueckID, b.ID as BesetzungID
-- , m.Besetzung, b.Name 
FROM musikstueck m left join `besetzung` b 
on 
( 
    TRIM(SUBSTRING_INDEX(m.Besetzung, ';',1)) = b.Name
    or 
    TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  = b.Name
    or 
    TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))  = b.Name
    )
where 
m.Besetzung is not null 
and m.Besetzung <> ''
; 
-- and b.Name is nULL -- Test fehlende Zuordnung   



/* 
Spalte musikstueck.Besetzung löschen 

ALTER TABLE `musikstueck` DROP `Besetzung`;"


select m.* 
from musikstueck m left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID 
where mb.ID is null 


*/


