


/*
Ein Musikstück (inklusive Sätze) inneralb einer Sammlung duplizieren 
*/ 

-- SELECT * 
-- from musikstueck 
-- where SammlungID = 113; 



insert into musikstueck (
    Name
    , Opus
    , SammlungID
    , Nummer
    , KomponistID
    , Bearbeiter
    , JahrAuffuehrung
    , GattungID
    , EpocheID
)
   
select 
Name
, Opus
, SammlungID
, Nummer
, KomponistID
, Bearbeiter
, JahrAuffuehrung
, GattungID
, EpocheID
from musikstueck 
where ID=207
; 


select * from musikstueck where SammlungiD=113; 


/****************************/


show colums from satz 


insert into satz 
(
    MusikstueckID
, Name
, Tonart
, Taktart
, Tempobezeichnung
, Spieldauer
, Lagen
, Bemerkung
, Nr
, Notenwerte
, ErprobtID
, SchwierigkeitsgradID
, BesonderheitID

)
select 
     MusikstueckID
    , Name
    , Tonart
    , Taktart
    , Tempobezeichnung
    , Spieldauer
    , Lagen
    , Bemerkung
    , Nr
    , Notenwerte
    , ErprobtID
    , SchwierigkeitsgradID
    , BesonderheitID
from satz 
where ID =386





    MusikstueckID=207


/* 

Achtung FElder mit Mehrfach-Zuordnung müssen - sofern sie befüllt sind extra kopiert werden! 


*/

