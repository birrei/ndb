CREATE OR REPLACE VIEW v_satz AS 
select 
/* Sammlung */ 
    sammlung.Name as Sammlung 
    -- , verlag.Name as Verlag 
    -- , standort.Name as Standort
    -- , sammlung.Bestellnummer
    , sammlung.Bemerkung as `Sammlung Bemerkung` 
/* musikstueck */
  --  , musikstueck.Nummer AS Musikstueck_Nr
    , musikstueck.Name AS Musikstueck
   -- , musikstueck.Opus 
    , komponist.Name as Komponist 
    -- , musikstueck.Bearbeiter
    -- , epoche.Name as Epoche
    -- , gattung.Name as Gattung 
/* satz */     
    , satz.Nr 
    , satz.Name 
    , satz.Taktart
    , satz.Tempobezeichnung
    -- , satz.Spieldauer
    , concat(
        satz.Spieldauer DIV 60
        ,''''
        , 
        satz.Spieldauer MOD 60
        , ''''''
        ) as Spieldauer
    , erprobt.Name as Erprobt
    , v_satz_lookuptypes.LookupList as Besonderheiten
    , GROUP_CONCAT(DISTINCT concat(schwierigkeitsgrad.Name, ' - ', instrument.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') as Schwierigkeitsgrade 
    , satz.Orchesterbesetzung
    , satz.Bemerkung
    , satz.Lagen     
    , satz.ID
    , sammlung.ID as SammlungID 
    , musikstueck.ID as MusikstueckID  
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
  
    LEFT JOIN erprobt on erprobt.ID = satz.ErprobtID
    left JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
    LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
    LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 

    left join satz_lookup on satz_lookup.SatzID = satz.ID 
    -- left join lookup on lookup.ID = satz_lookup.LookupID 
    -- left join lookup_type on lookup_type.ID = lookup.LookupTypeID

    left join v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 

group by satz.ID 
order by sammlung.Name, musikstueck.Nummer, satz.Nr

