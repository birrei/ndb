CREATE OR REPLACE view v_satz_erprobte as  
select satz_erprobt.SatzID 
        , GROUP_CONCAT(DISTINCT erprobt.Name  order by erprobt.Name SEPARATOR ', ') ErprobtList          
from satz_erprobt 
    left join erprobt  
    on erprobt.ID = satz_erprobt.ErprobtID 
group by satz_erprobt.SatzID