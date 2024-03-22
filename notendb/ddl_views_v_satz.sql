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
    , musikstueck.Epoche
    , gattung.Name as Gattung 
/* satz */     
    , satz.Name as Satz 
    , satz.Nr as SatzNr
    , satz.Tonart 
    , satz.Taktart
    , satz.Tempobezeichnung
    , satz.Spieldauer
    , satz.Schwierigkeitsgrad
    , satz.Lagen 
    , GROUP_CONCAT(DISTINCT strichart.Name order by strichart.Name SEPARATOR ', ') Stricharten       
    , satz.Erprobt 
    , satz.Notenwerte
    , satz.ID 
FROM 
    sammlung 
    LEFT join verlag on sammlung.VerlagID = verlag.ID  
    LEFT JOIN standort on sammlung.StandortID = standort.ID 
    LEFT JOIN musikstueck on  musikstueck.SammlungID = sammlung.ID 
    LEFT join v_komponist as komponist on musikstueck.KomponistID = komponist.ID 
    LEFT JOIN gattung on gattung.ID = musikstueck.GattungID 
    LEFT JOIN musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
    left JOIN besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
    left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID 
    left join verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID
    LEFT join satz  on musikstueck.ID = satz.MusikstueckID    
    LEFT JOIN satz_strichart on satz_strichart.SatzID = satz.ID 
    LEFT JOIN strichart on strichart.ID = satz_strichart.StrichartID 
group by satz.ID 
order by sammlung.Name, musikstueck.Nummer, satz.Nr

