/*
Bisherige Einfachzuordnung "Erprobt" soll in eine Mehrfachzuordnung umgewandelt werden. 
Die Verknüpfungstabelle erhält eine Spalte "Jahr", die Angaben werden aus Spalte Aufführungsjahr übernommen. 
Die Spalte musikstueck.Auffuehrungsjahr wird abschließend entfernt. 
*/


/*---------- Vorbreitung ------------------------------------------------*/

ALTER TABLE `satz` DROP FOREIGN KEY `satz_ibfk_2`; -- fkey satz.ErprobtID->erprobt.ID löschen 

ALTER TABLE erprobt CHANGE `ID` `ID` INT; -- "int unsigned" zu "int"  ändern 

/*---------- DDL neue Objekte ------------------------------------------------*/

drop table if Exists satz_erprobt; 

CREATE TABLE IF NOT EXISTS satz_erprobt 
(
    ID INT NOT NULL AUTO_INCREMENT     
    , SatzID 	int(10) unsigned Not NULL 
    , ErprobtID INT NULL
    , Jahr YEAR
    , Bemerkung VARCHAR(100)
    , PRIMARY KEY (ID)   
) 
; 

/*

-- ALTER TABLE satz_erprobt
-- ADD CONSTRAINT uc_satz_erprobt 
-- UNIQUE (SatzID, ErprobtID, Jahr)

-- -> nicht sinnvoll 
--- (mehrfache Zuordnung einer gleichen ErprobtID muss ja theoretisch möglich sein!, + Jahr kann oft leer sein) 
*/


ALTER TABLE satz_erprobt 
    ADD  FOREIGN KEY (SatzID) 
    REFERENCES satz(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE satz_erprobt 
    ADD  FOREIGN KEY (ErprobtID) 
    REFERENCES erprobt(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;


/*--------- Daten migrieren -------------------------------------------------*/
-- Inhalt aus Auffuehrungsjahr übernehmen:  
  --  falls 4 stellige Ziffer: zu satz_erprobt.Jahr 
  -- falls nicht: zu satz_erprobt.Bemerkung 


delete from satz_erprobt; 
INSERT INTO satz_erprobt (SatzID, ErprobtID, Jahr, Bemerkung) 
select SatzID as ID 
  -- , ErprobtID
  -- , JahrAuffuehrung
  -- , COALESCE(ErprobtID, 19) as ErprobtID -- prod 
  , COALESCE(ErprobtID, 5) as ErprobtID -- dev 
  , case when length(JahrAuffuehrung) = 4
    and JahrAuffuehrung regexp '^[0-9]' 
    then JahrAuffuehrung
    end 
    as Jahr 
  , case when length(JahrAuffuehrung) <> 4
    then JahrAuffuehrung
    end as Bemerkung 
from 
(
    select satz.ID as SatzID
    , JahrAuffuehrung
    , satz.ErprobtID
    , erprobt.Name as Erprobt 
    from musikstueck
    inner join satz on musikstueck.ID = satz.MusikstueckID 
    left join erprobt on erprobt.ID = satz.ErprobtID
    where coalesce(JahrAuffuehrung,'') <> '' 
    or satz.ErprobtID is not null
) ref
order by SatzID

; 


select * from satz_erprobt; 


/*--------- */


    ALTER TABLE satz_erprobt CHANGE `ErprobtID` `ErprobtID` INT NULL ; 
