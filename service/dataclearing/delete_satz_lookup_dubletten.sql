
-- Dublette C-Dur 
-- Falsch: ID 608	C-Dur (unter Taktart reingerutscht)
-- Korrekt: ID 651 C-Dur 
-- Finden und löschen: Zeilen in satz_lookup, wo es für eine SatzID beide Zuordnungen gibt 


SELECT * 
-- delete satz_lookup 
FROM satz_lookup 
inner join 
(
select distinct ID 
from satz_lookup
WHERE 1=1 
AND SatzID IN (SELECT SatzID from satz_lookup WHERE LookupID IN (651)) 
AND SatzID IN (SELECT SatzID from satz_lookup WHERE LookupID IN (608)) 
) satz_lookup_ref 
on satz_lookup_ref.ID = satz_lookup.ID 
WHERE satz_lookup.LookupID = 608 


-- Update für den Rest 
update satz_lookup set LookupID=651 WHERE LookupID = 608


---------------------------------------------------------------------



-- Korrektur Dublette "Betonungen"

-- Lösche alle Verknüpfung von Sätzen mit ID 30 (Betonungen) für die SatzIDs, die bereits eine 
-- Verknüpfung mit ID 104 (Betonung) haben 

select * 
from satz_lookup 
where LookupID=30 
and SatzID in (select distinct SatzID from satz_lookup where LookupID=104);

--------------------------------

-- delete from 
-- satz_lookup where LookupID=30 
-- and SatzID in (select distinct SatzID from satz_lookup where LookupID=104);

-- SQLSTATE[HY000]: General error: 1093 You can't specify target table 'satz_lookup' for update in FROM clause


-- delete from  
-- satz_lookup USING 
-- satz_lookup  where LookupID=30 
-- and SatzID in (select distinct SatzID from satz_lookup where LookupID=104);

-- SQLSTATE[HY000]: General error: 1093 You can't specify target table 'satz_lookup' for update in FROM clause

------------------- 

-- Ausweg: 
-- WHERe 2.  Zeile kann wegglassen werden, das Ergebnis ist (in diesem Fall) das Gleiche 

delete from satz_lookup where LookupID=30


