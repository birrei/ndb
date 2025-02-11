
insert into musikstueck_verwendungszweck (MusikstueckID, VerwendungszweckID) 
select 1492 as MusikstueckID, VerwendungszweckID
from musikstueck_verwendungszweck 
where MusikstueckID = 1490 -- copy cat 

