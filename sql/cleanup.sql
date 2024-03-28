
/* nicht verwendete verlage löschen */ 
delete from verlag where ID not in (select distinct VerlagID from sammlung where VerlagID is not NULL)  

/* nicht verwendete sammlungen löschen */
delete from sammlung where ID not in (select distinct SammlungID from musikstueck where SammlungID is not null) 

/* nicht verwendete Gattungen löschen */
delete from gattung where ID not in (select distinct GattungID from musikstueck where GattungID is not null)

/* nicht verwendete Epochen löschen */
delete from epoche where ID not in (select distinct EpocheID from musikstueck where EpocheID is not null)

/* nicht verwendete Notenwerte löschen */
delete from notenwert where ID not in (select distinct NotenwertID from satz_notenwert)



/* Musikstücke ohne Satz löschen  */
-- 1) Besetzungen löschen 
delete from musikstueck_besetzung where MusikstueckID IN (
select ID from musikstueck where ID not in (select distinct MusikstueckID from satz where MusikstueckID is not null))
-- 2) Verwendungszwecke lsöchen 
delete from musikstueck_verwendungszweck where MusikstueckID IN (
select ID from musikstueck where ID not in (select distinct MusikstueckID from satz where MusikstueckID is not null))
-- 3) Musikstücke löschen 
delete from musikstueck where ID not in (select distinct MusikstueckID from satz where MusikstueckID is not null)



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
