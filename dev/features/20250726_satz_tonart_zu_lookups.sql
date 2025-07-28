/**

Aufgabe: Feld Satz "Tonart" (Einzelnes Textfeld mit kommaspearierten Auflistungen) soll aufgelöst werden. 
Die Inhalte sollen als Mehrfacheinträge in den Lookups ("Besonderheiten") abgebildet werden. 

 * */


-- 1) Maximale Anzahl von Kommas ermittelen 
SELECT
    LENGTH(Tonart) - LENGTH(REPLACE(Tonart, ',', '')) AS anzahl_Komma
FROM satz
WHERE Tonart  like '%,%'
ORDER by anzahl_komma desc 
--  5 Kommas, -> 6 x splitstring 


-- 2) View erstellen 

drop view IF exists v_tmp_Tonarten; 

create or replace view v_tmp_Tonarten as 
/* Temp fuer Aufgabe 20250726_satz_taktart_zu_lookups.sql */
select * 
from (
SELECT ID  
	, Tonart
    , fn_SPLIT_STRING(replace(Tonart, 'Tonart',''), ',', 1) as Tonart_Neu -- bis 1. Komma
  , 1 Position    
FROM satz 
where Tonart LIKE '%,%'
UNION  
SELECT ID
	, Tonart 
    , fn_SPLIT_STRING(replace(Tonart, 'Tonart',''), ',', 2) as Tonart_Neu -- zwischen 1. und 2. Komma
    , 2 Position
FROM satz 
where Tonart LIKE '%,%'
UNION  
SELECT ID
	, Tonart 
    , fn_SPLIT_STRING(replace(Tonart, 'Tonart',''), ',', 3) as Tonart_Neu -- zwischen 2. und 3. Komma
    , 3 Position    
FROM satz 
where Tonart LIKE '%,%'
UNION  
SELECT ID
	, Tonart 
    , fn_SPLIT_STRING(replace(Tonart, 'Tonart',''), ',', 4) as Tonart_Neu -- zwischen 3. und 4. Komma
    , 4 Position       
FROM satz 
where Tonart LIKE '%,%'
UNION  
SELECT ID
	, Tonart 
    , fn_SPLIT_STRING(replace(Tonart, 'Tonart',''), ',', 5) as Tonart_Neu -- nach 4. Komma
    , 5 Position          
FROM satz 
where Tonart LIKE '%,%'
UNION  
SELECT ID
	, Tonart 
    , fn_SPLIT_STRING(replace(Tonart, 'Tonart',''), ',', 6) as Tonart_Neu -- nach 4. Komma
    , 6 Position          
FROM satz 
where Tonart LIKE '%,%'
) as Tonarten  
where length(Tonarten.Tonart_Neu) > 0 
UNION ALL 
SELECT ID
	, Tonart 
    , Tonart as Tonart_Neu
    , 0 as Position
FROM satz 
where Tonart NOT LIKE '%,%'
and length(Tonart) > 0 
order by ID, Tonart 
;

SELECT  * from v_tmp_Tonarten Order by ID, Tonart;  

SELECT  * from v_tmp_Tonarten where Position=5  Order by ID, Tonart;
-- ID 168, 171 

SELECT  * from v_tmp_Tonarten where ID in (168, 171)  Order by ID, Tonart, Position;

-- 3) view testen 
select * 
from v_tmp_Tonarten v
LEFT join satz t on v.ID = t.ID 
and v.Tonart  = t.Tonart
where t.ID  is null 

-- 4) Neuen Lookup-Type anlegen 
-- (Über Anwendung), neue ID hierher kopieren -- ID dev: 24


-- 5) Tabelle Lookup befüllen 

insert into lookup (LookupTypeID, Name)
select distinct 24 as LookupTypeID 
	, Tonart_Neu  as Name 
from v_tmp_Tonarten
where Tonart not like '%(%'
and Tonart not like '%kein%'
and Tonart not like '%ohne%'
and Tonart not like '%unbestimmt%'
and Tonart <> '?'
order by Tonart_Neu 

select * from lookup where LookupTypeID =24


-- 6) Tabelle satz_lookup befüllen 

insert into satz_lookup (SatzID, LookupID)
select tmp.ID as SatzID 
	, lookup.ID as LookupID 
	-- , lookup.Name
	-- , tmp.Tonart
	-- , satz_lookup.SatzID 
from lookup 
	inner join v_tmp_Tonarten as tmp  
		on lookup.Name= tmp.Tonart_Neu
	left join satz_lookup  on satz_lookup.SatzID=tmp.ID 
					and satz_lookup.LookupID = lookup.ID 
where 1=1
and satz_lookup.ID is null 
-- and tmp.ID in (158) 
order by tmp.ID, tmp.Position  		


select * from satz where id=158 



-------------------

-- 7) Demo für AG 
-- Sätze mit mehreren Tonarten 





select satz_lookup.SatzID
	, count(LookupID ) Anzahl_Tonarten 
from satz_lookup
	inner join lookup on satz_lookup.LookupID = lookup.ID 
	inner join satz on satz_lookup.SatzID  = satz.ID
where lookup.LookupTypeID =23
group by satz_lookup.SatzID 
order by Anzahl_Tonarten DESC 

select * from satz where ID in (158) 




/*
181	6
691	5
540	5
210	5
262	4
438	4
538	4 --> gut, weil auch mehrere Taktarten 
168	4
158	4
166	4
 * */


/*

http://www.susannereiner.de/notendb/edit_satz.php?ID=538&option=edit




*/



-- 8) temp. View wieder löschen 
drop view IF exists v_tmp_Tonarten; 


-- allerlei 

SELECT  * from v_tmp_Tonarten where ID in (168, 171)  Order by ID, Tonart, Position;

select * from lookup_type order by ID desc; 

select * from lookup; 

select * from satz_lookup;




