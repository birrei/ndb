
/* 
Für "Abfragen", Typ "Nachbearbeitung" 

Test: Fehlende "*Griffart*"-Angabe fehlt. 
Bedingung: Sätze, bei denen Besonderheiten-Einträge grundsätzlich gepflegt sind (das ist nicht immer der Fall). 
= Sätze, bei denen mind. 1 BEsonderheit-Eintrag (vom fraglichen Typ) vorhanden ist (fraglicher Typ ist in diesem Fall "Übung Sonst")


*/ 


select s.Name as Sammlung

        , m.Name as Musikstueck
        , sa.Nr SatzNr
       , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen     
       , GROUP_CONCAT(DISTINCT instrument.Name order by instrument.Name SEPARATOR ', ') as SG_Instrumente 
       , sa.ID                   
    from musikstueck m 
    inner join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = m.ID 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
    left join satz_lookup on satz_lookup.SatzID = sa.ID 
    left join lookup on lookup.ID = satz_lookup.LookupID 
-- ANd satz_schwierigkeitsgrad.ID is NULL
group by m.ID, sa.ID 
order by m.ID DESC