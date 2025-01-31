
create or REPLACE view v2_info_Tempobezeichnungen as 
select  distinct NULL as ID, Tempobezeichnung 
from satz  
where Tempobezeichnung is not null 
and Tempobezeichnung <> ''
order by Tempobezeichnung