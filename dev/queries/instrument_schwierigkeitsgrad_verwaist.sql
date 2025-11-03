-- verwaiste eintraege in instrument_schwierigkeitsgrad

delete from instrument_schwierigkeitsgrad WHERE ID IN (

	select instrument_schwierigkeitsgrad.ID
		-- , instrument.Name as Instrument 
		-- , schwierigkeitsgrad.Name as Schwierigkeitsgrad
	from instrument_schwierigkeitsgrad 
	inner join instrument on instrument_schwierigkeitsgrad.InstrumentID = instrument.ID
	inner join schwierigkeitsgrad on schwierigkeitsgrad.ID = instrument_schwierigkeitsgrad.SchwierigkeitsgradID 
	left join satz_schwierigkeitsgrad 
	on instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
	and instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
	where satz_schwierigkeitsgrad.ID is null 

	)

select * from instrument_schwierigkeitsgrad

select * from satz_schwierigkeitsgrad 

select * from schwierigkeitsgrad 


delete instrument_schwierigkeitsgrad
  from instrument_schwierigkeitsgrad 
  left join satz_schwierigkeitsgrad 
  on instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
  and instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
  where satz_schwierigkeitsgrad.ID IS NULL 
  
/*

geht bei MariaDB, wohl nicht bei MySQL 5.7. ...
------------------

DELETE from instrument_schwierigkeitsgrad WHERE ID IN (
          SELECT instrument_schwierigkeitsgrad.ID
          from instrument_schwierigkeitsgrad 
          left join satz_schwierigkeitsgrad 
          on instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
          and instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
          where satz_schwierigkeitsgrad.ID IS NULL 
        )
Ein Fehler ist aufgetreten.

SQLSTATE[HY000]: General error: 1093 You can't specify target table 'instrument_schwierigkeitsgrad' for update in FROM clause


*/