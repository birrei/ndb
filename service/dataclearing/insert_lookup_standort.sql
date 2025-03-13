/* 

Scriptbeschreibung allgemein: 
Allen Sätzen innerhalb eines Standorts soll eine bestimmte Besonderheit zugeordnet werden 

------------
Besonderheit: "Lage 1" - ID 218

Standorte: 

24	VL 01	
26	VL 02	
31	VL 03	
32	VL 04	
25	VLA 01	
28	W 01 - Weihnachten	

*/



insert into satz_lookup (SatzID, LookupID)
select satz.ID SatzID 
	, 218 as LookupID
from satz inner join 
	 musikstueck on musikstueck.ID = satz.MusikstueckID inner join 
	 sammlung on sammlung.ID= musikstueck.SammlungID left join 
	 satz_lookup on satz.ID  = satz_lookup.SatzID 
	 	and satz_lookup.LookupID = 218 -- Lage 1 
-- where sammlung.StandortID = 24 -- VL 01 
-- where sammlung.StandortID = 26 -- VL 02
-- where sammlung.StandortID = 31 -- VL 03
-- where sammlung.StandortID = 32 -- VL 04
-- where sammlung.StandortID = 25 -- VLA 01 
where sammlung.StandortID = 28 -- W 01 - Weihnachten
and satz_lookup.ID is null 
	 