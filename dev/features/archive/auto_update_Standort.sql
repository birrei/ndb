
/* Standort 24  "VL01"  */

DELETE FROM auto_update WHERE ref_colname='StandortID' AND ref_ID=24; 

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 24, 'BesetzungID', 1); -- 1 Violine und Klavier 

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 24, 'VerwendungszweckID', 34); -- 34	Vorspiel

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 24, 'VerwendungszweckID', 35); -- 35	VL Unterricht



/* Standort 6 "XXX noch erfassen" */

DELETE FROM auto_update WHERE ref_colname='StandortID' AND ref_ID=6; 

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 6, 'BesetzungID', 1); -- 1 Violine und Klavier 

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 6, 'VerwendungszweckID', 34); -- 34	Vorspiel

INSERT INTO auto_update (ref_colname, ref_ID, upd_colname, upd_ID)
VALUES('StandortID', 6, 'VerwendungszweckID', 35); -- 35	VL Unterricht


/*  */
select * from auto_update order by ID DESC;
