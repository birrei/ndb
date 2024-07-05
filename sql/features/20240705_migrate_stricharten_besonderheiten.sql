select * from stricharten 

insert into lookup_type (Name, Relation,type_key) 
values('Stricharten', 'satz', 'besstrich');  

insert into lookup_type (Name, Relation,type_key) 
values('Notenwerte', 'satz', 'besnot');  

insert into lookup_type (Name, Relation,type_key) 
values('Uebung', 'satz', 'besueb');  

insert into lookup_type (Name, Relation,type_key) 
values('Lagen', 'satz', 'beslag');  

--------------------
--- Stricharten 


insert into lookup (Name, LookupTypeID)
select Name, 5 as LookupTypeID from strichart; 

select * from lookup_type;
select * from lookup;
select * from strichart;



-- select * from satz_lookup; 

select satz.ID 
, satz.Name as Satz
, strichart.Name  
from satz 
inner join satz_strichart 
on satz_strichart.SatzID = satz.ID 
inner join strichart 
on strichart.ID = satz_strichart.StrichartID;



