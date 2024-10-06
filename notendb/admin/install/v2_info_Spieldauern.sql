
CREATE or REPLACE view v2_info_Spieldauern as 
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


