

/* A: Metadaten übernehmen */

/* A1) lookup_type */
insert into lookup_type (Name, Relation,type_key) 
values('Stricharten', 'satz', 'besstrich');  

insert into lookup_type (Name, Relation,type_key) 
values('Notenwerte', 'satz', 'besnot');  

insert into lookup_type (Name, Relation,type_key) 
values('Uebung', 'satz', 'besueb');  

insert into lookup_type (Name, Relation,type_key) 
values('Lagen', 'satz', 'beslag');  


--------------------

/* A2) lookup */

--- Stricharten 

select * from lookup_type; 
-- LookupTypeID= 5 


insert into lookup (Name, LookupTypeID)
select Name, 5 as LookupTypeID from strichart --- LookupTypeID vor prod anpassen! 
; 
select * from strichart order by Name;
select * from lookup where LookupTypeID=5 order by Name; 


--- Notenwerte  

select * from lookup_type; 
-- LookupTypeID= 9 

insert into lookup (Name, LookupTypeID)
select Name, 9 as LookupTypeID from notenwert 

select * from notenwert order by Name;
select * from lookup where LookupTypeID=9 order by Name; 


--- Übung  

select * from lookup_type; 
-- LookupTypeID= 10 

insert into lookup (Name, LookupTypeID)
select Name, 10 as LookupTypeID from uebung 
; 

select * from uebung order by Name;
select * from lookup where LookupTypeID=10 order by Name; 



/* B: Migrations-Sichten erstellen */

create or replace View v_tmp_satz_strichart_lookup as 
select satz.ID 
    , satz.Name as Satz
    , strichart.Name as Strichart_Name
    , lookup.Name as Lookup_Name
    , lookup.LookupTypeID
from satz 
inner join satz_strichart 
    on satz_strichart.SatzID = satz.ID 
inner join strichart 
    on strichart.ID = satz_strichart.StrichartID
left join lookup   
    on strichart.Name = lookup.Name
    and lookup.LookupTypeID = 
 where lookup.ID is not null 





/*******************************************/





-- select * from lookup_type;
-- select * from lookup;
-- select * from strichart;
-- select * from notenwert;
-- select * from uebung;
-- -- XXX Lagen ... 






-- select satz.ID 
-- , satz.Name as Satz
-- , strichart.Name  
-- from satz 
-- inner join satz_strichart 
-- on satz_strichart.SatzID = satz.ID 
-- inner join strichart 
-- on strichart.ID = satz_strichart.StrichartID;


;



