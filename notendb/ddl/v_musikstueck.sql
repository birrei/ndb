CREATE OR REPLACE VIEW v_musikstueck AS 
select 
    sammlung.Name as Sammlung 
    , verlag.Name as Verlag 
    , standort.Name as Standort
    , sammlung.Bestellnummer
    , sammlung.Bemerkung as Sammlung_Bemerkung 
    , musikstueck.Nummer AS Musikstueck_Nr
    , musikstueck.Name
    , musikstueck.Opus 
    , komponist.Name as Komponist 
    , musikstueck.Bearbeiter
    , epoche.Name as Epoche 
    , gattung.Name as Gattung 
    , musikstueck.JahrAuffuehrung
    , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen   
    , GROUP_CONCAT(DISTINCT verwendungszweck.Name order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke  
    , GROUP_CONCAT(DISTINCT satz.Nr order by satz.Nr SEPARATOR ', ') Satznummern      
    , musikstueck.ID 
   FROM 
    sammlung 
    INNER JOIN musikstueck on  musikstueck.SammlungID = sammlung.ID     
    LEFT join verlag on sammlung.VerlagID = verlag.ID  
    LEFT JOIN standort on sammlung.StandortID = standort.ID 
    LEFT join v_komponist as komponist on musikstueck.KomponistID = komponist.ID 
    LEFT JOIN gattung on gattung.ID = musikstueck.GattungID 
    LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID     
    LEFT JOIN musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
    left JOIN besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
    left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID 
    left join verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID
    LEFT join satz  on musikstueck.ID = satz.MusikstueckID 
   
group by musikstueck.ID 
order by sammlung.Name, musikstueck.Nummer





