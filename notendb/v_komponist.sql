create or replace view v_komponist as 
select ID
    , case 
        when Vorname <> '' and Nachname <> '' 
        then  CONCAT(COALESCE(Nachname, '') , ', ', COALESCE(Vorname, '')) 
    when COALESCE(Vorname, '') = '' and COALESCE(Nachname,'') <> '' 
        then  Nachname 
    when COALESCE(Vorname,'') <> '' and COALESCE(Nachname, '')  =''
        then  Vorname 
    End Name
    , Vorname
    , Nachname
    , Geburtsjahr
    , Sterbejahr
    , Bemerkung  
from komponist
