create or REPLACE view v2_info_Taktarten as 
select distinct Taktart from satz  
where Taktart is not null 
and Taktart <> ''
order by Taktart