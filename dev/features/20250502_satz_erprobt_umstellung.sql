/*

Satz Zordnung "Erprobt" soll nur optional sein.

Aufgaben: 
* Test-View "v3_test_satz_ohne_erprobt.sql" löschen, aus tests.php entfernen  
* Satz-Erprobt-Zuordnungen "Nein" löschen 
* Unklare Satz-Erprobt-Zuorndungen: Update auf "Unklar"
* Stammdaten-Tabelle: Eintrag "nein" löschen 

*/ 

-- drop view v3_test_satz_ohne_erprobt


select * from erprobt; 

select * from satz_erprobt


-- SELECT * 
delete 
from satz_erprobt 
where ErprobtID=5
and Jahr IS NULL
and COALESCE(Bemerkung, '') =''
-- 802 Zeilen betroffen

-- zu: 
-- 19	unklar

-- select * 
-- from satz_erprobt 
-- where ErprobtID=5
-- and Jahr IS NOT NULL


update satz_erprobt 
set ErprobtID = 19 -- unklar
where ErprobtID=5
and Jahr IS NOT NULL
-- 14 Zeilen betroffen

-- select * 
-- from satz_erprobt 
-- where ErprobtID=5
-- and COALESCE(Bemerkung, '')<>''

update satz_erprobt 
set ErprobtID = 19 -- unklar
where ErprobtID=5
and COALESCE(Bemerkung, '')<>''
-- 54 Zeilen betroffen


-- select erprobt.ID, erprobt.Name, count(*) Anzahl 
-- from erprobt inner join 
-- satz_erprobt on satz_erprobt.ErprobtID=erprobt.ID 
-- group by erprobt.ID
-- order by Anzahl DESC

