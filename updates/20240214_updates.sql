

-- ALTER TABLE `komponist` ADD `Bemerkung` VARCHAR(100) NULL ; -- ok 

-- ALTER TABLE `musikstueck` CHANGE `Opus` `Opus` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- ALTER TABLE `musikstueck` CHANGE `Name` `Name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- ALTER TABLE `musikstueck` CHANGE `Verwendungszweck` `Verwendungszweck` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- ALTER TABLE `musikstueck` CHANGE `Gattung` `Gattung` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- ALTER TABLE `musikstueck` CHANGE `Name` `Name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- ALTER TABLE `sammlung` CHANGE `Standort` `Standort` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- ALTER TABLE `sammlung` CHANGE `Name` `Name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

A-- LTER TABLE `sammlung` CHANGE `Bestellnummer` `Bestellnummer` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;



-- CREATE OR REPLACE VIEW musikstuecke_v_sammlung11 AS 
-- select 
-- /* musikstueck */
-- 	m.Name AS Name
-- 	,m.Nummer AS Nr
--     , m.Opus 
-- 	, CONCAT(COALESCE(k.Vorname, '') , ' ', COALESCE(k.Nachname, '')) as Komponist /* komponist */
-- 	, sa.Name AS Sammlung /* sammlung */ 
-- 	, v.Name AS Verlag /* verlag */
--     , m.Bearbeiter
--     , m.Epoche
--     , m.Verwendungszweck
--     , m.Gattung
--     , b.Name as Besetzung /* besetzung */

--  /* satz */     
--     , s.Name as Satz 
--     , s.Nr as SatzNr
--     , s.Tonart 
--     , s.Taktart
--     , s.Tempobezeichnung
--     , s.Spieldauer
--     , s.Schwierigkeitsgrad
--     , s.Lagen 
--     , s.Stricharten 
--     , s.Erprobt 
--     , s.Notenwerte

-- /* ids */
--     , sa.ID AS SammlungID 
--     , k.ID AS KomponistID
--     , b.ID as BesetzungID
--     , v.ID as VerlagID 
-- 	, m.ID as MusikstueckID
--     , s.ID as SatzID 
--     , m.ID 
--    FROM 
--     musikstueck  AS m 
--     LEFT join  satz  AS s on m.ID = s.MusikstueckID    
--     LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
--     LEFT join  komponist  AS k on m.KomponistID = k.ID 
--     LEFT join  verlag  AS v on sa.VerlagID = v.ID 
--     left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
--     left join besetzung b on mb.BesetzungID = b.ID
-- where m.SammlungID = 11
-- order by m.Nummer ; 

drop view musikstuecke_v_sammlung11 
