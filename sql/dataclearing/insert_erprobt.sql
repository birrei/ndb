

--- jedem Satz einer Sammlung soll ein Eintrag "erprobt" = "nein" hinzugefügt werden 

insert into satz_erprobt  (SatzID, ErprobtID) 
select satz.ID as SatzID 
    , 5 as ErprobtID -- XX  5 nein 
from satz 
    inner join musikstueck on musikstueck.ID = satz.MusikstueckID
    inner join sammlung on sammlung.ID = musikstueck.SammlungID 
    left join satz_erprobt  
        on  satz_erprobt.SatzID = satz.ID
        and satz_erprobt.ErprobtID = 5  -- XX nein
where sammlung.ID = 250 -- XX SammlungID 
and satz_erprobt.ID IS NULL


