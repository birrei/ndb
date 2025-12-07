-- Übung, Auswahl Besonderheiten 

DROP TABLE IF EXISTS uebung_lookup
; 
CREATE TABLE IF NOT EXISTS uebung_lookup (
    `ID` int NOT NULL AUTO_INCREMENT     
    , `UebungID` INT NOT NULL     
    , `LookupID` INT NOT NULL 
    , PRIMARY KEY (`ID`)   
) 
;

ALTER TABLE uebung_lookup
ADD CONSTRAINT uc_uebung_lookup
UNIQUE (UebungID, LookupID) 
;

ALTER TABLE uebung_lookup 
    ADD  FOREIGN KEY (UebungID) 
    REFERENCES uebung(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE uebung_lookup 
    ADD  FOREIGN KEY (LookupID) 
    REFERENCES lookup(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

insert into relation (Name) values('uebung');

select * from relation

/*

#Doku: Welche Besonderheiten können ausgewählt werden? 

Zuordnung von Besonderheiten über Checkliste 
- Variante 1: Freie Auswahl 
- Variante 2: mit Vorlag: Besonderheiten aus dem Satz, welcher der Übung bereits zugeordet wurde 

Filter: Variante (Optionen radio )

Besonderheiten aus Noten(Material) und solche aus Übungen  (konkret geübt)

--------------
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