SELECT concat('SELECT \'', TABLE_NAME,'\' as tab,  MAX(ts_insert) max_ts_insert FROM ', TABLE_NAME, ' UNION ALL ') as query
-- SELECT concat('SELECT \'', TABLE_NAME,'\' as tab,  MAX(ts_insert) max_ts_insert FROM ', TABLE_NAME, ';') as query
FROM information_schema.TABLES 
where TABLE_SCHEMA ='test'
and TABLE_TYPE ='BASE TABLE'

SELECT 'abfrage' as tab,  MAX(ts_insert) max_ts_insert FROM abfrage UNION ALL 
SELECT 'abfragetyp' as tab,  MAX(ts_insert) max_ts_insert FROM abfragetyp UNION ALL 
SELECT 'besetzung' as tab,  MAX(ts_insert) max_ts_insert FROM besetzung UNION ALL 
SELECT 'epoche' as tab,  MAX(ts_insert) max_ts_insert FROM epoche UNION ALL 
SELECT 'erprobt' as tab,  MAX(ts_insert) max_ts_insert FROM erprobt UNION ALL 
SELECT 'gattung' as tab,  MAX(ts_insert) max_ts_insert FROM gattung UNION ALL 
SELECT 'instrument' as tab,  MAX(ts_insert) max_ts_insert FROM instrument UNION ALL 
SELECT 'instrument_schwierigkeitsgrad' as tab,  MAX(ts_insert) max_ts_insert FROM instrument_schwierigkeitsgrad UNION ALL 
SELECT 'komponist' as tab,  MAX(ts_insert) max_ts_insert FROM komponist UNION ALL 
SELECT 'link' as tab,  MAX(ts_insert) max_ts_insert FROM link UNION ALL 
SELECT 'linktype' as tab,  MAX(ts_insert) max_ts_insert FROM linktype UNION ALL 
SELECT 'link_tmp' as tab,  MAX(ts_insert) max_ts_insert FROM link_tmp UNION ALL 
SELECT 'lookup' as tab,  MAX(ts_insert) max_ts_insert FROM lookup UNION ALL 
SELECT 'lookup_type' as tab,  MAX(ts_insert) max_ts_insert FROM lookup_type UNION ALL 
SELECT 'material' as tab,  MAX(ts_insert) max_ts_insert FROM material UNION ALL 
SELECT 'materialtyp' as tab,  MAX(ts_insert) max_ts_insert FROM materialtyp UNION ALL 
SELECT 'musikstueck' as tab,  MAX(ts_insert) max_ts_insert FROM musikstueck UNION ALL 
SELECT 'musikstueck_besetzung' as tab,  MAX(ts_insert) max_ts_insert FROM musikstueck_besetzung UNION ALL 
SELECT 'musikstueck_verwendungszweck' as tab,  MAX(ts_insert) max_ts_insert FROM musikstueck_verwendungszweck UNION ALL 
SELECT 'sammlung' as tab,  MAX(ts_insert) max_ts_insert FROM sammlung UNION ALL 
SELECT 'sammlung_lookup' as tab,  MAX(ts_insert) max_ts_insert FROM sammlung_lookup UNION ALL 
SELECT 'satz' as tab,  MAX(ts_insert) max_ts_insert FROM satz UNION ALL 
SELECT 'satz_erprobt' as tab,  MAX(ts_insert) max_ts_insert FROM satz_erprobt UNION ALL 
SELECT 'satz_lookup' as tab,  MAX(ts_insert) max_ts_insert FROM satz_lookup UNION ALL 
SELECT 'satz_schwierigkeitsgrad' as tab,  MAX(ts_insert) max_ts_insert FROM satz_schwierigkeitsgrad UNION ALL 
SELECT 'schueler' as tab,  MAX(ts_insert) max_ts_insert FROM schueler UNION ALL 
SELECT 'schueler_material' as tab,  MAX(ts_insert) max_ts_insert FROM schueler_material UNION ALL 
SELECT 'schueler_satz' as tab,  MAX(ts_insert) max_ts_insert FROM schueler_satz UNION ALL 
SELECT 'schueler_schwierigkeitsgrad' as tab,  MAX(ts_insert) max_ts_insert FROM schueler_schwierigkeitsgrad UNION ALL 
SELECT 'schwierigkeitsgrad' as tab,  MAX(ts_insert) max_ts_insert FROM schwierigkeitsgrad UNION ALL 
SELECT 'standort' as tab,  MAX(ts_insert) max_ts_insert FROM standort UNION ALL 
SELECT 'status' as tab,  MAX(ts_insert) max_ts_insert FROM status UNION ALL 
SELECT 'verlag' as tab,  MAX(ts_insert) max_ts_insert FROM verlag UNION ALL 
SELECT 'verwendungszweck' as tab,  MAX(ts_insert) max_ts_insert FROM verwendungszweck 
order by max_ts_insert desc 