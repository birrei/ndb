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

    create or REPLACE view v_tmp_Lagen as 
    select distinct 0 as ID, Lagen from satz  
    where Lagen is not null 
    and Lagen <> ''
    order by Lagen 

    ; 
    
    create or REPLACE view v_tmp_Spieldauer as 
    select distinct 0 as ID
            , Spieldauer
            ,  case when Spieldauer >= 20 
                THEN 
                (Spieldauer / 60.00) 
            END as Spieldauer_min
    from satz  
    where Spieldauer is not null 
    order by Spieldauer

    ; 


