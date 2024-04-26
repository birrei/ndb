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

    CREATE or REPLACE view v_tmp_Spieldauer as 
        select distinct NULL as ID
        , Spieldauer
        , concat(
            case when length( Spieldauer DIV 60)=1 
            then concat('0', (Spieldauer DIV 60)) 
            else Spieldauer DIV 60
            end
            ,':'
            , 
            case when length( Spieldauer MOD 60)=1 
            then concat('0', (Spieldauer MOD 60)) 
            else Spieldauer MOD 60
            end 
            ) as Spieldauer_1

        , concat(
            Spieldauer DIV 60
            ,''''
            , 
            Spieldauer MOD 60
            , ''''''
            ) as Spieldauer_2

        from satz  
        where Spieldauer is not null 
        order by Spieldauer


