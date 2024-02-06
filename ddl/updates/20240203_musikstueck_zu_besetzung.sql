/* 
Erstellung Tabelle "besetzung"
Erstellung Tabelle "musikstueck_besetzung"
Befüllung Tabelle "besetzung" aus Feld Inhalt von "musikstueck.Besetzung"
Befüllung Tabelle "musikstueck_besetzung"
Entfernung Spalte "musikstueck.Besetzung" (auf Prod erst nach  Absprache mit AG)
*/

/* Tabelle "besetzung" */

    CREATE TABLE besetzung  
        (`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT 
        , Name VARCHAR(100) NOT NULL 
        , PRIMARY KEY (`ID`)
        )
        ENGINE = InnoDB; 


/* Verknüpfungstabelle "musikstueck_besetzung" */ 

    CREATE TABLE `musikstueck_besetzung` 
    (
    `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
    , `MusikstueckID` int(11) UNSIGNED  NOT NULL 
    , `BesetzungID` int(11) UNSIGNED  NOT NULL 
        , PRIMARY KEY (`ID`)   
    ) 
    ENGINE = InnoDB;

    ALTER TABLE `musikstueck_besetzung` 
    ADD CONSTRAINT uc_musikstueck_besetzung 
    UNIQUE (MusikstueckID,BesetzungID);


    /* fkeys */ 
    ALTER TABLE `musikstueck_besetzung` 
        ADD  FOREIGN KEY (`MusikstueckID`) 
        REFERENCES `musikstueck`(`ID`) 
        ON DELETE RESTRICT ON UPDATE RESTRICT;

    ALTER TABLE `musikstueck_besetzung` 
        ADD  FOREIGN KEY (`BesetzungID`) 
        REFERENCES `besetzung`(`ID`) 
        ON DELETE RESTRICT ON UPDATE RESTRICT;

/* 
Befüllung der Tabelle Besetzung 
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
and besetzung <> '' 
and TRIM(SUBSTRING_INDEX(Besetzung, ';',1)) not in (select Name from besetzung )


/*
2. 
Teil nach dem letzten Semikolon
*/
INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung 
TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and besetzung <> '' 
and TRIM(SUBSTRING_INDEX(Besetzung, ';',-1))  not in (
select Name from besetzung 
)



/*
3. 
 Teil nach dem 1. und vor dem 2. Semikolon 

*/
INSERT INTO besetzung (Name) 
SELECT distinct 
-- Besetzung,  
TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))  
FROM `musikstueck` 
WHERE Besetzung is not null 
and besetzung <> '' 
and TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(Besetzung, ';',-2))  , ';',1))    not in (select Name from besetzung )


/* test match, insert musikstueck_besetzung */ 

insert into musikstueck_besetzung (MusikstueckID, BesetzungID) 
SELECT DISTINCT m.ID as MusikstueckID, b.ID as BesetzungID
-- , m.Besetzung, b.Name 
FROM musikstueck m left join `besetzung` b 
-- on m.Besetzung like concat('%', b.Name, '%')  
on 
( 
    TRIM(SUBSTRING_INDEX(m.Besetzung, ';',-1)) = b.Name
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


*/


