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


