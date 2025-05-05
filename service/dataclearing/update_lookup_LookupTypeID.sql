/* 
   alle "Besonderheiten" mit Namen *Lagen* unter "Übung sonst" 
   verschieben zu "Besonderheiten-Typ" "Übung Lagen" 
*/ 

    select * from lookup 
    where Name like '%Lagen%'
    and LookupTypeID=1 -- Uebung Sonst
    ;

    update lookup  
    set LookupTypeID = 19 -- Übung Lagen (neu)  
    WHERE Name like '%Lagen%' 
    and LookupTypeID = 1 -- Uebung Sonst
    select * from v_lookup order by LookupTypeID; 



/* 
   alle "Besonderheiten" mit Namen *Griffart* unter "Übung sonst" 
   sollen den neuen "Besonderheiten-Typ" "Übung Griffart" erhalten
*/ 

    update lookup  set LookupTypeID = 17  where Name like '%Griffart%' and LookupTypeID = 1;

    select * from lookup where Name like '%Griffart%';

    select * from v_lookup order by LookupTypeID; 



/* 
   alle "Besonderheiten" mit Namen *Strichart* unter "Übung sonst" 
   sollen den neuen "Besonderheiten-Typ" "Übung Strichart" erhalten 
*/ 

update lookup  set LookupTypeID = 20 where Name like '%Strichart%' and LookupTypeID = 1;
