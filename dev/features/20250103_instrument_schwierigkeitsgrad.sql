DROP table instrument_schwierigkeitsgrad
; 
CREATE TABLE IF NOT EXISTS instrument_schwierigkeitsgrad
(
    ID INT NOT NULL AUTO_INCREMENT     
    , InstrumentID INT NOT NULL 
    , SchwierigkeitsgradID 	 INT NOT NULL 
    , PRIMARY KEY (ID)   
) 
; 

select * from instrument_schwierigkeitsgrad; 

select distinct InstrumentID, SchwierigkeitsgradID
from satz_schwierigkeitsgrad



select distinct  concat(i.Name, ' - ', s.Name) as Name 
from instrument_schwierigkeitsgrad ss 
	 inner join 
	 schwierigkeitsgrad s  on ss.SchwierigkeitsgradID  = s.ID 
	 inner  join 
	 instrument i on ss.InstrumentID  = i.ID 	 
order by i.Name, s.Name 
	 





-- select distinct  concat(i.Name, ' - ', s.Name) 
-- from satz_schwierigkeitsgrad ss 
-- 	 inner join 
-- 	 schwierigkeitsgrad s  on ss.SchwierigkeitsgradID  = s.ID 
-- 	 inner  join 
-- 	 instrument i on ss.InstrumentID  = i.ID 	 
-- order by i.Name, s.Name 
	 


