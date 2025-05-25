        
--  Material muss einer Sammlung zugeordnet werden  

update material set SammlungID=460 where ID=2; 
update material set SammlungID=461 where ID=1; 
select * from material where SammlungID IS NULL;


