CREATE OR REPLACE view v_satz_instrumente as  

select satz_schwierigkeitsgrad.SatzID 
        , GROUP_CONCAT(DISTINCT instrument.Name  order by instrument.Name SEPARATOR ', ') InstrumentList          
from satz_schwierigkeitsgrad 
    left join instrument  
    on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
group by satz_schwierigkeitsgrad.SatzID