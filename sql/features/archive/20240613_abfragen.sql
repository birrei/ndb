
drop table if exists  abfrage
; 

CREATE TABLE IF NOT EXISTS `abfrage`   
(`ID` int not null AUTO_INCREMENT
, Name VARCHAR(100) NOT NULL 
, Beschreibung VARCHAR(255) NOT NULL 
, Abfrage VARCHAR(10000) NOT NULL 
, Tabelle VARCHAR(100) NOT NULL -- Tabelle, die ueber Bearbeiten-Link geöffnet werden kann  
, PRIMARY KEY (`ID`)
)
;

insert into abfrage (Name, Abfrage, Tabelle)
values ('Test: Sammlungen ohne Musikstueck', 'SELECT * FROM v_test_sammlung_ohne_musikstueck', 'sammlung')
; 

insert into abfrage (Name, Abfrage, Tabelle)
values ('Test: Musikstücke ohne Satz', 'SELECT * FROM v_test_musikstueck_ohne_satz', 'musikstueck')
; 

insert into abfrage (Name, Abfrage, Tabelle)
values ('Test: Musikstücke ohne Besetzung', 'SELECT * FROM v_test_musikstueck_ohne_besetzung', 'musikstueck')
; 

insert into abfrage (Name, Abfrage, Tabelle)
values ('Test: Satz ohne Spieldauer', 'SELECT * FROM v_test_satz_ohne_spieldauer', 'satz')
; 

insert into abfrage (Name, Abfrage, Tabelle)
values ('Test: Satz ohne Erprobt-Angabe', 'SELECT * FROM v_test_satz_ohne_erprobt', 'satz')
; 

insert into abfrage (Name, Abfrage, Tabelle)
values ('Test: Satz ohne Schwierigkeitsgrad', 'SELECT * FROM v_test_satz_ohne_schwierigkeitsgrad', 'satz')
; 

select * from abfrage; 


/*********************/

-- ALTER TABLE `abfrage` CHANGE `Abfrage` `Abfrage` varchar(10000); 

-- show columns from abfrage; 

