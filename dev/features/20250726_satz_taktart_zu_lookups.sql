/* *
Aufgabe: Feld Satz "Taktart" (Einzelnes Textfeld mit kommaspearierten Auflistungen) soll aufgelöst werden. 
Die Inhalte sollen als Mehrfacheinträge in den Lookups ("Besonderheiten") abgebildet werden. 

 * */


-- 1) Maximale Anzahl von Kommas ermittelen 
SELECT
    LENGTH(Taktart) - LENGTH(REPLACE(Taktart, ',', '')) AS anzahl_Komma
FROM satz
WHERE Taktart  like '%,%'
ORDER by anzahl_komma desc 
--  4 Kommas, -> 5 x splitstring 


-- 2) View erstellen 

drop view IF exists v_tmp_Taktarten; 

create or replace view v_tmp_Taktarten as 
/* Temp fuer Aufgabe 20250726_satz_taktart_zu_lookups.sql */
select * 
from (
SELECT ID  
	, Taktart
    , fn_SPLIT_STRING(replace(Taktart, 'Taktart',''), ',', 1) as Taktart_Neu -- bis 1. Komma
  , 1 Position    
FROM satz 
where Taktart LIKE '%,%'
UNION  
SELECT ID
	, Taktart 
    , fn_SPLIT_STRING(replace(Taktart, 'Taktart',''), ',', 2) as Taktart_Neu -- zwischen 1. und 2. Komma
    , 2 Position
FROM satz 
where Taktart LIKE '%,%'
UNION  
SELECT ID
	, Taktart 
    , fn_SPLIT_STRING(replace(Taktart, 'Taktart',''), ',', 3) as Taktart_Neu -- zwischen 2. und 3. Komma
    , 3 Position    
FROM satz 
where Taktart LIKE '%,%'
UNION  
SELECT ID
	, Taktart 
    , fn_SPLIT_STRING(replace(Taktart, 'Taktart',''), ',', 4) as Taktart_Neu -- zwischen 3. und 4. Komma
    , 4 Position       
FROM satz 
where Taktart LIKE '%,%'
UNION  
SELECT ID
	, Taktart 
    , fn_SPLIT_STRING(replace(Taktart, 'Taktart',''), ',', 5) as Taktart_Neu -- nach 4. Komma
    , 5 Position          
FROM satz 
where Taktart LIKE '%,%'
) as Taktarten  
where length(Taktarten.Taktart_Neu) > 0 
UNION ALL 
SELECT ID
	, Taktart 
    , Taktart as Taktart_Neu
    , 0 as Position
FROM satz 
where Taktart NOT LIKE '%,%'
and length(Taktart) > 0 
order by ID, Taktart 
;

SELECT  * from v_tmp_Taktarten Order by ID, Taktart;  

SELECT  * from v_tmp_Taktarten where Position=5  Order by ID, Taktart;
-- ID 168, 171 

SELECT  * from v_tmp_Taktarten where ID in (168, 171)  Order by ID, Taktart, Position;

-- 3) view testen 
select * 
from v_tmp_Taktarten v
LEFT join satz t on v.ID = t.ID 
and v.Taktart  = t.Taktart
where t.ID  is null 

-- 4) Neuen Lookup-Type anlegen 
-- (Über Anwendung), neue ID hierher kopieren -- ID dev: 23 


-- 5) Tabelle Lookup befüllen 

insert into lookup (LookupTypeID, Name)
select distinct 23 as LookupTypeID 
	, Taktart_Neu  as Name 
from v_tmp_Taktarten
order by Taktart_Neu 

select * from lookup where LookupTypeID =23 


-- 6) Tabelle satz_lookup befüllen 


insert into satz_lookup (SatzID, LookupID)
select tmp.ID as SatzID 
	, lookup.ID as LookupID 
	-- , lookup.Name
	-- , tmp.Taktart
from lookup 
	inner join v_tmp_Taktarten as tmp  
		on lookup.Name= tmp.Taktart_Neu
-- where tmp.ID in (168, 171) 
order by SatzID, tmp.Position  		





-------------------

-- 7) Demo für AG 
-- Sätze mit mehreren Taktarten 

select * from satz where ID in (168, 171) 

select * from musikstueck where ID=152

select * from sammlung where ID=61 -- jurassic park 


select satz_lookup.SatzID
	, count(LookupID ) Anzahl_Taktarten 
from satz_lookup
	inner join lookup on satz_lookup.LookupID = lookup.ID 
	inner join satz on satz_lookup.SatzID  = satz.ID
where lookup.LookupTypeID =23
group by satz_lookup.SatzID 
order by Anzahl_Taktarten DESC 

/*
 * 
168	5
171	5
210	4
2042	4
129	3
263	3
166	3
1152	3
169	3
174	3

 * */


/*
http://www.susannereiner.de/notendb/edit_satz.php?ID=168&option=edit

http://www.susannereiner.de/notendb/edit_satz.php?ID=171&option=edit

http://www.susannereiner.de/notendb/edit_satz.php?ID=210&option=edit


*/



-- 8) temp. View wieder löschen 
drop view IF exists v_tmp_Taktarten; 


-- allerlei 

SELECT  * from v_tmp_Taktarten where ID in (168, 171)  Order by ID, Taktart, Position;

select * from lookup_type order by ID desc; 

select * from lookup; 

select * from satz_lookup;




