/* tmp. distinct views  */ 

    create or REPLACE view v_tmp_Tonart as 
    select distinct 0 as ID, Tonart from satz  
    where Tonart is not null 
    and Tonart <> ''
    order by Tonart
