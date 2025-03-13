/*
Aufteilung Griffarten-Einträge

Beispiel: 
Griffart 1,2,3 

Ändern in
Griffart 1: 0-1-23-4
Griffart 2: 0-12-3-4
Griffart 3: 0-1-2-34


*/

create or replace view v_tmp_griffarten_l as 
select * 
from (
SELECT ID
	, Name
, fn_SPLIT_STRING(replace(Name, 'Griffart',''), ',', 1) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%,%'
and Name not like '%Finger%'
and Name not like '%tief%' 
union 
SELECT ID
	, Name
, fn_SPLIT_STRING(replace(Name, 'Griffart',''), ',', 2) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%,%'
and Name not like '%Finger%'
and Name not like '%tief%' 
union 
SELECT ID
	, Name
, fn_SPLIT_STRING(replace(Name, 'Griffart',''), ',', 3) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%,%'
and Name not like '%Finger%'
and Name not like '%tief%' 
) as Griffarten 
where length(Griffarten.griffart) > 0 
order by Name, Griffart
;

create or replace view v_tmp_griffarten_r as 
SELECT ID
	, Name
, fn_SPLIT_STRING(replace(Name, 'Griffart',''), ':', 1) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%:%'
and Name not like '%Finger%'
and Name not like '%Ziffern%'
order by Name
; 

select * from v_tmp_griffarten_l

select * from v_tmp_griffarten_r

-- select l.ID as ID_alt 
-- , l.Name as Griffart_alt
-- , r.ID as ID_neu 
-- , r.Name as Griffart_neu
-- from v_tmp_griffarten_l as l
-- inner join v_tmp_griffarten_r as r on l.Griffart = r.Griffart 
-- -- inner join satz_lookup sl_l on sl_l.LookupID = l.ID  
-- order by l.Name


create or replace view v_tmp_satz_lookup_neu as 
select
sl.SatzID
, l.ID as ID_alt 
, l.Name as Griffart_alt
, r.ID as ID_neu 
, r.Name as Griffart_neu
from v_tmp_griffarten_l as l
inner join v_tmp_griffarten_r as r on l.Griffart = r.Griffart 
inner join satz_lookup sl on sl.LookupID = l.ID  
-- where sl.SatzID = 809
-- order by sl.SatzID, l.Name

; 

-- select * from v_tmp_satz_lookup_neu where SatzID = 809

/*
SatzID	ID_alt	Griffart_alt	ID_neu	Griffart_neu
809	    202	    Griffart 1,2,3	163	    Griffart 1: 0-1-23-4
809	    202	    Griffart 1,2,3	198	    Griffart 3: 0-1-2-34
809	    202	    Griffart 1,2,3	191 	Griffart 2: 0-12-3-4
*/

-- neu einfügen
insert into satz_lookup (SatzID, LookupID)
select sl_insert.SatzID
	, sl_insert.ID_neu as LookupID 
from v_tmp_satz_lookup_neu as sl_insert 
left join 
satz_lookup sl
on sl.SatzID = sl_insert.SatzID 
and sl.LookupID  = sl_insert.ID_neu
where sl.ID  is null 
-- and sl_insert.SatzID = 809




-- Satz-Besonderheit-Verknüpfungen löschen 
delete from satz_lookup USING 
-- select *  from 
satz_lookup 
inner join 
(
select distinct ID as LookupID 
from v_tmp_griffarten_l
) as griffarten 
on griffarten.LookupID = satz_lookup.LookupID 


-- Besonderheiten löschen 
delete from lookup USING 
lookup 
inner join 
(
select distinct ID as LookupID 
from v_tmp_griffarten_l
) as griffarten 
on griffarten.LookupID = lookup.ID 


drop view v_tmp_griffarten_l; 

drop view v_tmp_griffarten_r; 

drop view v_tmp_satz_lookup_neu; 

