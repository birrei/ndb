
-- show columns from schwierigkeitsgrad;
-- show columns from satz;
-- 

DROP table satz_schwierigkeitsgrad
; 
CREATE TABLE IF NOT EXISTS satz_schwierigkeitsgrad
(
    ID INT NOT NULL AUTO_INCREMENT     
    , SatzID 	int(10) unsigned Not NULL 
    , SchwierigkeitsgradID 	int(10) unsigned  NOT NULL 
    , InstrumentID INT NOT NULL 
    , PRIMARY KEY (ID)   
) 
; 

ALTER TABLE satz_schwierigkeitsgrad
ADD CONSTRAINT uc_satz_schwierigkeitsgrad 
UNIQUE (SatzID, SchwierigkeitsgradID, InstrumentID)
;

-- ALTER TABLE satz DROP CONSTRAINT satz_ibfk_4
-- (satz.SchwierigkeitsgradID > schwierigkeitsgrad.ID ist obsolete)
;

ALTER TABLE satz_schwierigkeitsgrad 
    ADD  FOREIGN KEY (SatzID) 
    REFERENCES satz(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE satz_schwierigkeitsgrad 
    ADD  FOREIGN KEY (SchwierigkeitsgradID) 
    REFERENCES schwierigkeitsgrad(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE satz_schwierigkeitsgrad 
    ADD  FOREIGN KEY (InstrumentID) 
    REFERENCES instrument(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;



-- select * from satz_schwierigkeitsgrad;
-- select * from instrument;
-- select * from schwierigkeitsgrad; 
-- select * from satz where name like '%test%';



-- alle  Schwierigkeitsgrade mit "Orchester" kombinieren. 
insert into satz_schwierigkeitsgrad (SatzID, SchwierigkeitsgradID, InstrumentID) 
select satz.ID as SatzID 
    , satz.SchwierigkeitsgradID
    , 1 as InstrumentID_default -- Orchester 
   -- , satz_schwierigkeitsgrad.InstrumentID
from satz 
left join satz_schwierigkeitsgrad
    on satz_schwierigkeitsgrad.SatzID = satz.ID 
    and satz_schwierigkeitsgrad.SchwierigkeitsgradID = satz.SchwierigkeitsgradID
    and satz_schwierigkeitsgrad.InstrumentID = 1 
  where satz.SchwierigkeitsgradID is not null 
  and satz_schwierigkeitsgrad.ID IS NULL
order by satz.ID


--- Test 
select satz.ID 
    , satz.SchwierigkeitsgradID
    , schwierigkeitsgrad_alt.Name as Schwierigkeitsgrad_alt 
    , schwierigkeitsgrad.Name as Schwierigkeitsgrad_neu 
    , instrument.Name as Instrument 
from satz 
left join schwierigkeitsgrad as schwierigkeitsgrad_alt 
    on satz.SchwierigkeitsgradID = schwierigkeitsgrad_alt.ID
left JOIN satz_schwierigkeitsgrad 
    on satz_schwierigkeitsgrad.SatzID = satz.ID  
left join schwierigkeitsgrad 
    on  schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
left join instrument
    on instrument.ID = satz_schwierigkeitsgrad.InstrumentID
where schwierigkeitsgrad_alt.ID 



/*****************************

offene Aufgaben: 








- Entfernung Feld satz.SchwierigkeitsgradID 


-----------------------------------
Notizen: 
* Tabelle "Instrumente" könnte theoretisch auch zu  "Besetzung" zugeordnet werden. 
Programm "SoftNote" ermöglicht dies (Instrument, Stückzahl)


-----------------------------------
erledigt: 

- Neue Tabelle satz_schwierigkeitsgrad: sql\features\20240701_instrument.sql
- X Testdaten in satz_schwierigkeitsgrad einfügen 
- edit_satz.php -> iframe + datei edit_satz_list_schwierigkeitsgrade.php
- cl_satz.php -> add_schwierigkeitsgrad
- edit_satz_add_schwierigkeitsgrad.php 
- cl_satz.php: delete_schwierigkeitsgrade
- cl_satz.php: bei "delete": delete_schwierigkeitsgrade

- edit_satz.php -> bisheriges Feld "Schwierigkeitsgrad" entfernen 
- cl_satz.php -> bisheriges Feld "Schwierigkeitsgrad" entfernen 

- edit_musikstueck.php > edit_musikstueck_list_saetze -> Abfrage anpassen 
- suche.php - anpassen 
- View v_satz anpassen 



*******************************/



