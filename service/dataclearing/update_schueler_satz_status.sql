/* Schüler x Satz -> Änderung Status */

-- 1) StatusID ermitteln: Anzeige der Tabelle 
select * from status order by Name; 

-- 2) SatzID ermittlen (-> Formular) 

-- 3) update durchführen 
UPDATE schueler_satz 
SET StatusID=7 
WHERE SatzID=2853
AND StatusID=3 



