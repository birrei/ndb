
/* Test: Anzahl Satz-Nummern stimmt nicht mit höchster Satz-Nummer überein 
Ergebnis eines alten Fehlers bei Funktion "Satz kopieren" (Hochzählung wurde nicht berücksichtigt)
(im konkreten FAll manuelle Korrektur, da nur wenige Fälle)
*/ 

select sammlung.ID, sammlung.Name, musikstueck.ID  
from musikstueck 
inner join sammlung on sammlung.ID = musikstueck.SammlungiD 
where musikstueck.ID in 
( 
select MusikstueckID
-- , count(*) anz_nr, max(Nr) max_nr
from satz 
group by MusikstueckID
having max(Nr) < count(*)  
-- order by anz_nr desc 
) 
