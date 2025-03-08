/*
Griffarten-Einträge aufteilen 
 
*/

create or replace view v_tmp_griffarten_l as 
select * 
from (
SELECT ID
	, Name
-- , SPLIT_STRING(Name, ',', 1) as Griffart
, SPLIT_STRING(replace(Name, 'Griffart',''), ',', 1) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%,%'
and Name not like '%Finger%'
and Name not like '%tief%' 
union 
SELECT ID
	, Name
-- , SPLIT_STRING(Name, ',', 1) as Griffart
, SPLIT_STRING(replace(Name, 'Griffart',''), ',', 2) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%,%'
and Name not like '%Finger%'
and Name not like '%tief%' 
union 
SELECT ID
	, Name
-- , SPLIT_STRING(Name, ',', 1) as Griffart
, SPLIT_STRING(replace(Name, 'Griffart',''), ',', 3) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%,%'
and Name not like '%Finger%'
and Name not like '%tief%' 
) as Griffarten 
where length(Griffarten.griffart) > 0 
order by Name, Griffart


create or replace view v_tmp_griffarten_r as 
SELECT ID
	, Name
, SPLIT_STRING(replace(Name, 'Griffart',''), ':', 1) as Griffart
FROM lookup
WHERE Name like '%griffart%'
and Name like '%:%'
and Name not like '%Finger%'
and Name not like '%Ziffern%'
order by Name

select * from v_tmp_griffarten_l

select * from v_tmp_griffarten_r
