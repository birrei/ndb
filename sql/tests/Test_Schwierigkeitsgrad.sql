
/* 
Test: 
Besetzung: "Violine und Klavier" 
Bei Schwierigkeitsgrad "Instrument" gibt es kein Klavier  


 */ 


select s.Name as Sammlung

        , m.Name as Musikstueck
        , sa.Nr 
        , sa.Name as Satz_Name 
   
       , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen     
       , GROUP_CONCAT(DISTINCT instrument.Name order by instrument.Name SEPARATOR ', ') as SG_Instrumente 
       , sa.ID                   
    from musikstueck m 
    inner join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = m.ID 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
    left join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = sa.ID 
        -- and satz_schwierigkeitsgrad.InstrumentID = 5 -- Klavier
    left join instrument on instrument.ID =  satz_schwierigkeitsgrad.InstrumentID
where musikstueck_besetzung.BesetzungID = 1 -- Violine und Klavier
-- ANd satz_schwierigkeitsgrad.ID is NULL
group by m.ID, sa.ID 
order by m.ID DESC