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