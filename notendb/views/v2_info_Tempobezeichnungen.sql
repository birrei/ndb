
create or REPLACE view v2_info_Tempobezeichnungen as 
select distinct Tempobezeichnung from satz  
where Tempobezeichnung is not null 
and Tempobezeichnung <> ''
order by Tempobezeichnung