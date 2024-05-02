CREATE OR REPLACE VIEW v_satz AS 
select 
/* Sammlung */ 
    sammlung.Name as Sammlung 
    , verlag.Name as Verlag 
    , standort.Name as Standort
    , sammlung.Bestellnummer
    , sammlung.Bemerkung as Sammlung_Bemerkung 
/* musikstueck */
    , musikstueck.Nummer AS Musikstueck_Nr
    , musikstueck.Name AS Musikstueck
    , musikstueck.Opus 
    , komponist.Name as Komponist 
    , musikstueck.Bearbeiter
    , epoche.Name as Epoche
    , gattung.Name as Gattung 
/* satz */     
    , satz.Name 
    , satz.Nr as SatzNr
    , satz.Name as SatzName
    , satz.Taktart
    , satz.Tempobezeichnung
    , satz.Spieldauer
    , satz.Lagen 
    , erprobt.Name as Erprobt 
    , schwierigkeitsgrad.Name as Schwierigkeitsgrad
    , GROUP_CONCAT(DISTINCT uebung.Name order by uebung.Name SEPARATOR ', ') Uebung 
    , GROUP_CONCAT(DISTINCT strichart.Name order by strichart.Name SEPARATOR ', ') Stricharten       
    , GROUP_CONCAT(DISTINCT notenwert.Name order by notenwert.Name SEPARATOR ', ') Notenwerte      
    , satz.Bemerkung
    , satz.ID 
FROM 
    satz 
    LEFT join musikstueck  on musikstueck.ID = satz.MusikstueckID  
    LEFT JOIN sammlung on musikstueck.SammlungID = sammlung.ID 

    LEFT join verlag on sammlung.VerlagID = verlag.ID  
    LEFT JOIN standort on sammlung.StandortID = standort.ID 

    LEFT join v_komponist as komponist on musikstueck.KomponistID = komponist.ID 
    LEFT JOIN gattung on gattung.ID = musikstueck.GattungID 
    LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID         
    LEFT JOIN musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
    left JOIN besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
    left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID 
    left join verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID
  
    LEFT JOIN satz_strichart on satz_strichart.SatzID = satz.ID 
    LEFT JOIN strichart on strichart.ID = satz_strichart.StrichartID 
    LEFT JOIN satz_notenwert on satz_notenwert.SatzID = satz.ID 
    LEFT JOIN notenwert on notenwert.ID = satz_notenwert.NotenwertID 
    LEFT JOIN erprobt on erprobt.ID = satz.ErprobtID
    LEFT JOIN schwierigkeitsgrad on  schwierigkeitsgrad.ID=satz.SchwierigkeitsgradID

    LEFT JOIN satz_uebung on satz_uebung.SatzID = satz.ID 
    LEFT JOIN uebung on uebung.ID = satz_uebung.UebungID

group by satz.ID 
order by sammlung.Name, musikstueck.Nummer, satz.Nr

