
/*
Ein Musikstück (inklusive Sätze) inneralb einer Sammlung duplizieren 
*/ 

-- SELECT * 
-- from musikstueck 
-- where SammlungID = 113; 


insert into sammlung (Name, VerlagID, StandortID, Bemerkung)
SELECT Name, VerlagID, StandortID, Bemerkung
from sammlung 
where ID= 162




insert into musikstueck (
    Name
    , Opus
    , SammlungID
    , Nummer
    , KomponistID
    , Bearbeiter
    , GattungID
    , EpocheID
)
   
select 
Name
, Opus
, 170 as SammlungID
, Nummer
, KomponistID
, Bearbeiter
, GattungID
, EpocheID
from musikstueck 
where SammlungID=162
; 



/****************************/

insert into satz 
(
    MusikstueckID
, Name
, Tonart
, Taktart
, Tempobezeichnung
, Spieldauer
, Bemerkung
, Nr
, Notenwerte
, ErprobtID
, SchwierigkeitsgradID
, BesonderheitID

)
select 
     318 as MusikstueckID
    , Name
    , Tonart
    , Taktart
    , Tempobezeichnung
    , Spieldauer
    , Bemerkung
    , Nr
    , Notenwerte
    , ErprobtID
    , SchwierigkeitsgradID
    , BesonderheitID
from satz 
where MusikstueckID =296




/* 
Achtung FElder mit Mehrfach-Zuordnung müssen - sofern sie befüllt sind - extra kopiert werden! 

*/

