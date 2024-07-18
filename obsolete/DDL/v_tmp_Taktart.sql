create or REPLACE view v_tmp_Taktart as 
select distinct Taktart from satz  
where Taktart is not null 
and Taktart <> ''
order by Taktart