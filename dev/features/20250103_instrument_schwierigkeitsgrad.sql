

-- DROP table instrument_schwierigkeitsgrad;

CREATE TABLE IF NOT EXISTS instrument_schwierigkeitsgrad
(
    ID INT NOT NULL AUTO_INCREMENT     
    , InstrumentID INT NOT NULL 
    , SchwierigkeitsgradID 	 INT NOT NULL 
    , PRIMARY KEY (ID)   
) 
; 

ALTER TABLE instrument_schwierigkeitsgrad  
ADD ts_insert datetime DEFAULT CURRENT_TIMESTAMP
; 

ALTER TABLE instrument_schwierigkeitsgrad
ADD CONSTRAINT uc_instrument_schwierigkeitsgrad 
UNIQUE (InstrumentID, SchwierigkeitsgradID) 
; 

ALTER TABLE instrument_schwierigkeitsgrad 
    ADD  FOREIGN KEY (InstrumentID) 
    REFERENCES instrument(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE instrument_schwierigkeitsgrad 
    ADD  FOREIGN KEY (InstrumentID) 
    REFERENCES instrument(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;


insert into instrument_schwierigkeitsgrad 
  (InstrumentID, SchwierigkeitsgradID)
select distinct InstrumentID, SchwierigkeitsgradID
from satz_schwierigkeitsgrad; 


select * from instrument_schwierigkeitsgrad order by ID desc ; 


select ss.ID, concat(i.Name, ' - ', s.Name) as NameConcat
from instrument_schwierigkeitsgrad ss 
	 inner join 
	 schwierigkeitsgrad s  on ss.SchwierigkeitsgradID  = s.ID 
	 inner  join 
	 instrument i on ss.InstrumentID  = i.ID 	 
order by i.Name, s.Name 


/*
 *
 * 
-- cl_satz.php - insert_ instrument_schwierigkeitsgrad

insert into instrument_schwierigkeitsgrad (InstrumentID, SchwierigkeitsgradID)
select t_ins.InstrumentID, t_ins.SchwierigkeitsgradID 
from (select 7 as InstrumentID, 99 as SchwierigkeitsgradID) t_ins
	left join instrument_schwierigkeitsgrad as t_ref
	on t_ref.InstrumentID = t_ins.InstrumentID 
	and t_ref.SchwierigkeitsgradID  = t_ins.SchwierigkeitsgradID
where t_ref.InstrumentID  is null 
; 


	; 

 * */
	

-- SHOW CREATE TABLE instrument_schwierigkeitsgrad; 

