/*
Bei Sammlungen, die zu einem bestimmen Standort gehören, 
soll bei allen Musikstücke ein definierter Verwendungszweck zugeordnet werden  


-----------------------------------------------

09.08.2024 

Gegebener Standort:
24	VL 01

zu ergänzende Verwendungszwecke: 
34	Vorspiel	
35	VL Unterricht	




*/


insert into musikstueck_verwendungszweck (MusikstueckID, VerwendungszweckID)
select musikstueck.ID
      , 34 as VerwendungszweckID -- XXX ID des zu ergänzenden Verwendungszwecks 
from sammlung 
inner join musikstueck on sammlung.ID = musikstueck.SammlungID
left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID
and musikstueck_verwendungszweck.VerwendungszweckID =34  -- -- XXX ID des zu ergänzenden Verwendungszwecks  
left join verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID 
where 1=1 
-- and sammlung.StandortID =24 -- XX! 
and sammlung.ID = 276-- XX! --  
and musikstueck_verwendungszweck.VerwendungszweckID IS NULL; 


insert into musikstueck_verwendungszweck (MusikstueckID, VerwendungszweckID)
select musikstueck.ID
      , 35 as VerwendungszweckID
from sammlung 
inner join musikstueck on sammlung.ID = musikstueck.SammlungID
left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID
and musikstueck_verwendungszweck.VerwendungszweckID =35  -- XX! 
left join verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID 
where sammlung.StandortID =24 -- XX! 
-- and sammlung.ID = 272-- XX! -- TEST 
and musikstueck_verwendungszweck.VerwendungszweckID IS NULL


