-- -- schueler initial-befüllung 

insert into schueler (Name)
select replace(Name, 'Planung Unterricht: ','') as NameInsert
	-- , Name
from verwendungszweck 
where 1=1 
and Name LIKE '%Planung Unterricht%'
and Name not like '%besonders%'; 

select * from schueler;


