create or REPLACE view v_tmp_Taktart as 
select distinct 0 as ID, Taktart from satz  
where Taktart is not null 
and Taktart <> ''
order by Taktart