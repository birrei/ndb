
create or REPLACE view v_tmp_Tempobezeichnung as 
select distinct 0 as ID, Tempobezeichnung from satz  
where Tempobezeichnung is not null 
and Tempobezeichnung <> ''
order by Tempobezeichnung