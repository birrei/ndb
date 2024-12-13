
/* 

Auftrag 10.10.2024

Satz, Besonderheiten: Fehlender Griffart-Eintrag   

Bedingung: Nur Sätze, bei denen Besonderheiten-Einträge grundsätzlich gepflegt sind, 
das ist nicht immer der Fall! (DEf. "Besonderheiten-Einträge sind grundsätzlich gepflegt: 
es ist mind. 1 (beiliebiger/weiterer) Besonderheit-Eintrag vorhanden) 

Kategorie: Fachlicher Test -> in "Abfragen" bereitstellen 

*/ 

select distinct 
    s.Name as Sammlung
    , sa.Nr as SatzNr 
    , sa.ID
    , s.ID as SammlungID 
    , m.ID as MusikstueckID 
from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
    inner join satz_lookup on satz_lookup.SatzID = sa.ID 
    inner join lookup on lookup.ID = satz_lookup.LookupID 
where 1=1 
    -- and s.ID = 22 and m.ID = 103 -- Tester 
    and sa.ID NOT IN (
        Select satz_lookup.SatzID from satz_lookup inner join lookup on lookup.ID = satz_lookup.LookupID 
        where lookup.Name LIKE '%Griffart%'
    )
order by s.StandortID, s.ID, m.ID, sa.ID

/*
Tester sammlung.ID 22 
Beschreibung: 

Musikstück ID= 103

3 Sätze: 
110: 2 Besonderheiten, 1 x Griffart -> also OK 
111: 1 Besonderheiten, keine Griffart -> Fehler! 
112: keine Besonderheiten  -> OK, nicht relevant 
111 und 112 haben keine Griffart 

Der Test soll Satz ID 111 ausgeben. SatzID 112 soll nicht ausgegeben werden, 
da dieser gar keine Besonderheit hat - hier geht man davon aus, dass Besonderheiten gar keine Rolle spielen 
(nur als  TEst - in der Praxis ist unwahrscheinlich, dass unter mehreren Sätzen mit Besonderheiten 
innerhalb eines Musikstück es einen Satz gibt, der keine BEsonderheiten hat/haben soll)    

*/
