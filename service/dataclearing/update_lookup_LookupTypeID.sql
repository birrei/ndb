
/* 
   alle "Besonderheiten" mit Namen *Griffart* unter "Übung sonst" 
   sollen den neuen "Besonderheiten-Typ" "Übung Griffart erhalten "
*/ 

    update lookup  set LookupTypeID = 17  where Name like '%Griffart%' and LookupTypeID = 1;

    select * from lookup where Name like '%Griffart%';

    select * from v_lookup order by LookupTypeID; 


