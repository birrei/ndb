/****** Eine Sammlung löschen    *******/
delete from satz_notenwert USING 
satz_notenwert
inner join satz on satz.ID= satz_notenwert.SatzID
inner join musikstueck on musikstueck.ID = satz.MusikstueckID
where musikstueck.SammlungID = 38
; 

delete from 
satz_strichart USING 
satz_strichart
inner join satz 
    on satz.ID= satz_strichart.SatzID
inner join musikstueck 
    on musikstueck.ID = satz.MusikstueckID
where musikstueck.SammlungID = 38
; 

delete from 
satz USING 
satz inner join musikstueck 
    on musikstueck.ID = satz.MusikstueckID
where musikstueck.SammlungID = 38
; 

delete from 
musikstueck_besetzung USING 
musikstueck_besetzung inner join musikstueck 
    on musikstueck.ID = musikstueck_besetzung.MusikstueckID
where musikstueck.SammlungID = 38
;

delete from 
musikstueck_verwendungszweck USING 
musikstueck_verwendungszweck inner join musikstueck 
    on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID
where musikstueck.SammlungID = 38
;

delete from musikstueck where SammlungID = 38
;

delete from sammlung where ID = 38
;

/****** nicht verwendeten Stammdaten-Einträge löschen *******/

/* nicht verwendete verlage löschen */ 
delete from verlag where ID not in (select distinct VerlagID from sammlung where VerlagID is not NULL)
;   
/* nicht verwendete Standorte löschen */ 
delete from standort where ID not in (select distinct StandortID from sammlung where StandortID is not NULL)
;   

/* nicht verwendte Komponisten löschen */
delete from komponist where ID not in (select distinct KomponistID from musikstueck where KomponistID is not null)
;  

/* nicht verwendete Gattungen löschen */
delete from gattung where ID not in (select distinct GattungID from musikstueck where GattungID is not null)
;  

/* nicht verwendete Epochen löschen */
delete from epoche where ID not in (select distinct EpocheID from musikstueck where EpocheID is not null)
;  

/* nicht verwendete Besetzungen löschen */
delete from besetzung where ID not in (select distinct BesetzungID from musikstueck_besetzung )
;  
/* nicht verwendete Verwendungszwecke löschen */
delete from verwendungszweck where ID not in (select distinct VerwendungszweckID from musikstueck_verwendungszweck )
;  

/* nicht verwendete Notenwerte löschen */
delete from notenwert where ID not in (select distinct NotenwertID from satz_notenwert)
;  
/* nicht verwendete Stricharten löschen */
delete from strichart where ID not in (select distinct StrichartID from satz_strichart)
;  











/*******************************/

-- /* Musikstücke ohne Satz löschen  */
-- -- 1) Besetzungen löschen 
-- delete from musikstueck_besetzung where MusikstueckID IN (
-- select ID from musikstueck where ID not in (select distinct MusikstueckID from satz where MusikstueckID is not null))
-- -- 2) Verwendungszwecke lsöchen 
-- delete from musikstueck_verwendungszweck where MusikstueckID IN (
-- select ID from musikstueck where ID not in (select distinct MusikstueckID from satz where MusikstueckID is not null))
-- -- 3) Musikstücke löschen 
-- delete from musikstueck where ID not in (select distinct MusikstueckID from satz where MusikstueckID is not null)






-- DROP VIEW IF EXISTS test_musikstueck_ohne_besetzung_v;
-- DROP VIEW IF EXISTS test_musikstueck_ohne_komponist_v;
-- DROP VIEW IF EXISTS test_musikstueck_ohne_satz_v;
-- DROP VIEW IF EXISTS test_sammlung_ohne_musikstueck_v;
-- DROP VIEW IF EXISTS test_sammlung_ohne_verlag_v;
-- DROP VIEW IF EXISTS test_satz_ohne_musikstueck_v;
-- DROP VIEW IF EXISTS tmp_epochen;
-- DROP VIEW IF EXISTS tmp_gattungen;
-- DROP VIEW IF EXISTS v_musikstuecke;


-- DROP VIEW IF EXISTS musikstuecke_v;
-- DROP VIEW IF EXISTS test_musikstueck_ohne_Besetzung_v;
-- DROP VIEW IF EXISTS tmp_Epochen;
-- DROP VIEW IF EXISTS tmp_Gattungen;
-- DROP VIEW IF EXISTS tmp_Stricharten;
-- DROP VIEW IF EXISTS tmp_Stricharten_split;
-- DROP VIEW IF EXISTS v_musikstuecke;
-- DROP VIEW IF EXISTS v_test_musikstueck_ohne_Besetzung;
-- DROP VIEW IF EXISTS v_test_musikstueck_ohne_komponist;
-- DROP VIEW IF EXISTS v_test_musikstueck_ohne_satz;
-- DROP VIEW IF EXISTS v_test_sammlung_ohne_musikstueck;
-- DROP VIEW IF EXISTS v_test_sammlung_ohne_verlag;
-- DROP VIEW IF EXISTS v_test_satz_ohne_musikstueck;
-- DROP VIEW IF EXISTS v_tmp_Epochen;
-- DROP VIEW IF EXISTS v_tmp_Gattungen;
