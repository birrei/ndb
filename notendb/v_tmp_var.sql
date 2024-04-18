/* tmp. distinct views  */ 

    create or REPLACE view v_tmp_Tonart as 
    select distinct 0 as ID, Tonart from satz  
    where Tonart is not null 
    and Tonart <> ''
    order by Tonart
    ; 

    create or REPLACE view v_tmp_Taktart as 
    select distinct 0 as ID, Taktart from satz  
    where Taktart is not null 
    and Taktart <> ''
    order by Taktart
    ; 

    create or REPLACE view v_tmp_Tempobezeichnung as 
    select distinct 0 as ID, Tempobezeichnung from satz  
    where Tempobezeichnung is not null 
    and Tempobezeichnung <> ''
    order by Tempobezeichnung
    ; 
  
    create or REPLACE view v_tmp_Schwierigkeitsgrad as 
    select distinct 0 as ID, Schwierigkeitsgrad from satz  
    where Schwierigkeitsgrad is not null 
    and Schwierigkeitsgrad <> ''
    order by Schwierigkeitsgrad
    ; 
   
    create or REPLACE view v_tmp_Lagen as 
    select distinct 0 as ID, Lagen from satz  
    where Lagen is not null 
    and Lagen <> ''
    order by Lagen 


