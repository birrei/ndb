UPDATE schueler_satz 
SET StatusID = 1  -- 01 Idee 
WHERE StatusID IS NULL 


--- Update StatusID für einen Satz 
update schueler_satz set StatusID=1 where SatzID=2843; 
select * from status order by Name; 
select * from schueler_satz where SatzID=2843;