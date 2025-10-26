/* Schüler x Satz -> Änderung Status */

-- 1) StatusID ermitteln: Anzeige der Tabelle 
select * from status order by Name; 

-- 2) SAtzID ermittlen (-> Formular) 

-- 3) update durchführen 
UPDATE schueler_satz 
SET StatusID=7 -- neue Status ID 
WHERE SatzID=2853 -- SatzID 
AND StatusID=3 -- alte StatusID 



