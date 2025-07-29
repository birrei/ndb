CREATE OR REPLACE VIEW v_satz AS 
select 
    sammlung.Name as Sammlung 
    , musikstueck.Name AS Musikstueck
    , komponist.Name as Komponist 
    , satz.Nr 
    , satz.Name 
    , satz.Tempobezeichnung
    , concat(
        satz.Spieldauer DIV 60
        ,''''
        , 
        satz.Spieldauer MOD 60
        , ''''''
        ) as Spieldauer
    , GROUP_CONCAT(DISTINCT  
                CASE 
	                when satz_erprobt.Jahr is null 
  		            then erprobt.Name 
  		            else concat(satz_erprobt.Jahr, ': ', erprobt.Name)
  	            end 
                order by satz_erprobt.Jahr 
                DESC SEPARATOR ', ') as Erprobt     
    , v_satz_lookuptypes.LookupList as Besonderheiten
    , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') as Schwierigkeitsgrade 
    , satz.Orchesterbesetzung
    , satz.Bemerkung   
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
    LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
    LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID
    left JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
    LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
    LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
    left join satz_lookup on satz_lookup.SatzID = satz.ID 
    left join v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
group by satz.ID 
order by sammlung.Name, musikstueck.Nummer, satz.Nr

