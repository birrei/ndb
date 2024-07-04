/*

Aufgaben: 

- Produktivnahme: 20240701_instrument.sql


--------- erledigt -------------------

- Neue Tabelle instrument: sql\features\20240701_instrument.sql
- cl_instrument.php
- insert_instrument.php
- edit_instrument.php 
- delete_instrument.php 


*/

CREATE TABLE IF NOT EXISTS instrument   (
    ID INT NOT NULL AUTO_INCREMENT 
    , Name VARCHAR(100) NOT NULL 
    , PRIMARY KEY (ID)
)
; 

