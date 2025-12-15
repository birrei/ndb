-- Sammlung: mehrere Standorte erfassen 

-- DROP TABLE IF EXISTS sammlung_standort
-- ; 
-- CREATE TABLE IF NOT EXISTS sammlung_standort (
--     `ID` int NOT NULL AUTO_INCREMENT     
--     , `SammlungID` int(10) unsigned NOT NULL -- :-/ 
--     , `StandortID` int(10) unsigned NOT NULL 
--     , PRIMARY KEY (`ID`)   
-- ) 
-- ;

-- ALTER TABLE sammlung_standort
-- ADD CONSTRAINT uc_sammlung_standort
-- UNIQUE (SammlungID, StandortID) 
-- ;

-- ALTER TABLE sammlung_standort 
--     ADD  FOREIGN KEY (SammlungID) 
--     REFERENCES sammlung(ID) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;

-- ALTER TABLE sammlung_standort 
--     ADD  FOREIGN KEY (StandortID) 
--     REFERENCES standort(ID) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;


-------------------------


insert into sammlung_standort (SammlungID,StandortID)
select sammlung.ID as SammlungID
	  , sammlung.StandortID 
from sammlung inner join standort on standort.ID = sammlung.StandortID 
left join sammlung_standort on sammlung.ID = sammlung_standort.SammlungID 
		  and standort.ID = sammlung_standort.StandortID 
where sammlung_standort.ID IS NULL 

		  




/*
-------------------------











class.uebung.php: 
    - print_table_lookups()
    - add_lookup()
    - delete_lookup()
    - delete_lookups()
    - copy_lookups()
    -> copy() -> Zeile copy_lookups()
    -> delete() -> Zeile delete_lookups()

Anpassung edit_uebung_lookup.php 
Anpassung edit_uebung_lookups.php 

Anpassung edit_uebung.php: iframe > edit_uebung_lookups.php 

class.schueler.php -> print_table_uebungen() (Ergänzung Spalte Besonderheiten)

-------------------------


Funktion "Löschen": Sammlung, Musikstück, Satz: Löschung verweigern, wenn mit Satz verknüpfte Übungen vorhanden sind
class.sammlung.php, class.musikstueck.php, class.satz.php: is_deletable() 

Schüler x Satz: Kombi darf nicht löschbar sein, wenn schon Schüler x Übung x Satz-Verknüpfung vorhanden ist. 
  
*/
















/*

Aufräumarbeiten: 

Feld löschen: sammlung.StandortID 





*/



