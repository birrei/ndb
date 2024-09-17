/* Automatisches Hinzufügen von Attributen  */

DROP TABLE IF EXISTS auto_update; 
CREATE TABLE IF NOT EXISTS auto_update (
    ID INT NOT NULL AUTO_INCREMENT     
    , ref_colname varchar(100) 
    , ref_ID INT 
    , upd_colname varchar(100)  
    , upd_ID INT
    , PRIMARY KEY (ID)   
) 
; 

ALTER TABLE auto_update
ADD CONSTRAINT uc_auto_update
UNIQUE (ref_colname, ref_ID, upd_colname, upd_ID)
; 


/******************************************************/


TRUNCATE TABLE auto_update; 

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 24, 'BesetzungID', 1); -- VL01 -> Violine und Klaver 

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 24, 'VerwendungszweckID', 34);

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 24, 'VerwendungszweckID', 35); 

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('SammlungID', 251, 'ErprobtID', 5); 

-- dev 
INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('SammlungID', 73, 'ErprobtID', 97); 

select * from auto_update order by ID DESC;


/******************************************************/


/*  Standort > Besetzung */
-- > cl_musikstueck.php > autoupdate_insert_besetzungen

-- insert into musikstueck_besetzung (MusikstueckID, BesetzungID) 
-- select musikstueck.ID, auto_update.upd_ID as BesetzungID 
-- from auto_update 
--      inner join sammlung on sammlung.StandortID = auto_update.ref_ID
--      inner join musikstueck on musikstueck.SammlungID = sammlung.ID 
--      left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
--          and musikstueck_besetzung.BesetzungID = auto_update.upd_ID
-- where auto_update.ref_colname='StandortID'
-- and auto_update.upd_colname='BesetzungID'
-- and musikstueck_besetzung.ID IS NULL;

     
/*  Standort > Verwendungszweck */
-- > cl_musikstueck.php > autoupdate_insert_verwendungszwecke


-- insert into musikstueck_verwendungszweck (MusikstueckID, VerwendungszweckID) 
-- select musikstueck.ID, auto_update.upd_ID as VerwendungszweckID 
-- from auto_update 
--      inner join sammlung on sammlung.StandortID = auto_update.ref_ID
--      inner join musikstueck on musikstueck.SammlungID = sammlung.ID 
--      left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID 
--          and musikstueck_verwendungszweck.VerwendungszweckID = auto_update.upd_ID
-- where auto_update.ref_colname='StandortID'
-- and auto_update.upd_colname='VerwendungszweckID'
-- and musikstueck_verwendungszweck.ID IS NULL;



/*  Standort > Verwendungszweck */

    insert into satz_erprobt (SatzID, ErprobtID) 
    select satz.ID as SatzID, auto_update.upd_ID as ErprobtID 
    from auto_update 
        inner join musikstueck on musikstueck.SammlungID = auto_update.ref_ID     
        inner join satz on satz.MusikstueckID = musikstueck.ID
        left join satz_erprobt on satz_erprobt.SatzID = satz.ID 
                              and satz_erprobt.ErprobtID = auto_update.upd_ID 
    where auto_update.ref_colname='SammlungID'
    and auto_update.upd_colname='ErprobtID'
    and musikstueck.SammlungID = 251 -- :ID 
    and satz_erprobt.ID IS NULL 

