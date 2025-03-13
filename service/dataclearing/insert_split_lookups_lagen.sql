/*
Aufteilung Lagen-Einträge






*/
create or replace view v_tmp_lagen_l as 
select * 
from (
SELECT ID
       , Name
      , fn_SPLIT_STRING(replace(Name, 'Lagen ',''), ',', 1) as Lage
FROM lookup
WHERE Name like '%Lagen%'
and Name like '%,%'
and Name not like '%XXX%'
and Name not like '%Lagenwechsel%'
union 
SELECT ID
       , Name
      , fn_SPLIT_STRING(replace(Name, 'Lagen ',''), ',', 2) as Lage
FROM lookup
WHERE Name like '%Lagen%'
and Name like '%,%'
and Name not like '%XXX%'
and Name not like '%Lagenwechsel%'
) as Lagen 
where length(Lagen.Lage) > 0 
order by Name, Lage
;

select * from v_tmp_lagen_l



create or replace view v_tmp_lagen_r as 
SELECT ID
	, Name
	, fn_SPLIT_STRING(replace(Name, 'Lage',''), ':', 1) as Lage
FROM lookup
WHERE Name like 'Lage %'
order by Name
;

select * from v_tmp_lagen_r


create or replace view v_tmp_satz_lookup_neu as 
select
sl.SatzID
, l.ID as ID_alt 
, l.Name as Lage_alt
, r.ID as ID_neu 
, r.Name as Lage_neu
from v_tmp_lagen_l as l
inner join v_tmp_lagen_r as r on l.Lage = r.Lage 
inner join satz_lookup sl on sl.LookupID = l.ID
order by sl.SatzID, Lage_alt, Lage_neu;

select * from v_tmp_satz_lookup_neu;

-- select * from v_tmp_satz_lookup_neu where SatzID = 809

/*
SatzID	ID_alt	Lage_alt	ID_neu	Lage_neu
5	      187	Lagen 1,3	231	Lage 3
5	      187	Lagen 1,3	218	Lage 1
... 
1769	      187	Lagen 1,3	231	Lage 3
1769	      187	Lagen 1,3	218	Lage 1
38 Zeilen betroffen
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



-- Satz-Besonderheit-Verknüpfungen löschen 
delete from satz_lookup USING 
-- select *  from 
satz_lookup 
inner join 
(
select distinct ID as LookupID 
from v_tmp_lagen_l
) as lagen 
on lagen.LookupID = satz_lookup.LookupID 


-- Besonderheiten löschen 
-- delete from lookup USING 
select *  from 
lookup 
inner join 
(
select distinct ID as LookupID 
from v_tmp_lagen_l
) as lagen 
on lagen.LookupID = lookup.ID