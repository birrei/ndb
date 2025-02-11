
insert into musikstueck_besetzung (MusikstueckID, BesetzungID) 
select 1492 as MusikstueckID, BesetzungID
from musikstueck_besetzung 
where MusikstueckID = 1490 -- copy cat 

