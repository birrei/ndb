
/* 1) Test: 
Anzahl Musikstück-Nummern stimmt nicht mit höchster Musikstück-Nummer überein 
Ergebnis eines alten Fehlers bei Funktion "Musikstück kopieren" (Hochzählung wurde nicht berücksichtigt)

Korrekturen: 
2) Update
Hinweis: ROW_NUMBER() nicht verfügbar in MySQL 5.X und älter 
Verfügbar in MariaDB 

*/ 

select musikstueck.SammlungID, sammlung.Name 
-- , count(*) anz_nr, max(Nr) max_nr
from musikstueck 
inner join sammlung on sammlung.ID=musikstueck.SammlungID 
where musikstueck.Nummer > 0 -- Fälle mit Nummer "-1" ausschließen 
group by musikstueck.SammlungID
having max(Nummer) < count(Nummer)  


-- MariaDB, MYSQL ab Version  8 
update musikstueck m 
inner join 
(
SELECT SammlungID, ID, Nummer, 
    ROW_NUMBER() OVER (ORDER BY ID) AS Nummer_Neu 
FROM musikstueck
) m_ref 
on m_ref.ID = m.ID 
set m.Nummer = m_ref.Nummer_Neu
where m.SammlungID=460 -- XXX ! 
and m.Nummer <> m_ref.Nummer_Neu 


-- MySQL 5.7: via SQL-Lists.xlsx / Blatt "update musikstueck nr"
select concat(' WHERE SammlungID=', musikstueck.SammlungID, ' AND ID=', musikstueck.ID, ' AND Nummer=', musikstueck.Nummer) as sql1
from musikstueck 
inner join 
(
select musikstueck.SammlungID, sammlung.Name 
-- , count(*) anz_nr, max(Nr) max_nr
from musikstueck 
inner join sammlung on sammlung.ID=musikstueck.SammlungID 
group by musikstueck.SammlungID
having max(Nummer) < count(Nummer)  
) m_ref 
on musikstueck.SammlungID= m_ref.SammlungID 
where musikstueck.SammlungID =1246
order by musikstueck.Name
