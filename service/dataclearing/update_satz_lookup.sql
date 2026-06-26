

/* Korrekturen 20.06.2026, 26.06.2026 */

-- update satz_lookup 
-- SET LookupID = 246 
-- WHERE LookupID=226

-- anschließend wurde LookupID 226 gelöscht. 
----------------------------------------------

-- Korrektur der Korrektur: Aufgrund eines Missverständnisses (Missverständnis Dublette) wurden 2 Lookups verschmolzen, 
-- die getrennt hätten bleiben müssen

-- Die Korrektur kommt ohne Hinzuzug eines Backups aus. 
-- Es erweist sich (wieder einmal) die Wichitgkeit der Spalten "ts_insert" und "ts_update" wichtig ist   

select * 
from satz_lookup 
WHERE LookupID=246  -- D.S. al Fine
order by ts_update DESC

-- Ergebnis: 2 Gruppen: 1. Ohne ts_update 20.06., 2. Mit ts_update am 20.06. 
-- Korrektur Gruppe 2: erneutes Update auf LookupID = 1016 (neues Lookup "D.C. al Fine") durchführen  

UPDATE satz_lookup 
SET LookupID = 1016 
WHERE LookupID = 246 
AND ts_update='2026-06-20 21:31:27' -- Zeitpunkt der ersten Korrektur 

-- Test: 
select  satz_lookup.*, lookup.Name
from satz_lookup
inner join lookup on satz_lookup.LookupID = lookup.ID  
where LookupID IN (246, 1016)
order by LookupID DESC, ts_insert DESC, ts_update DESC


