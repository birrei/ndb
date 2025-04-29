create or REPLACE view v2_info_Tonarten as 
select distinct NULL as ID, Tonart from satz  
where Tonart is not null 
and Tonart <> ''
order by Tonart
