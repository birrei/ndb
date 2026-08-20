-- 1055	Melodie in der Lehrer- und/oder in der Klavierstimme

INSERT INTO satz_lookup (SatzID, LookupID) 
SELECT satz.ID, 1055 as LookupID 
FROM satz 
WHERE satz.Bemerkung LIKE '%Melodie in der Lehrer-Stimme bzw. in der Klavierstimme%'


-- 1054	Klavier spielt Melodie mit

INSERT INTO satz_lookup (SatzID, LookupID) 
SELECT satz.ID, 1054 as LookupID 
FROM satz 
WHERE satz.Bemerkung LIKE '%Klavier spielt Melodie der Schülerstimme mit%'

-------------------------

UPDATE satz
SET Bemerkung = REPLACE(Bemerkung, 'Melodie in der Lehrer-Stimme bzw. in der Klavierstimme', '')
WHERE satz.Bemerkung LIKE '%Melodie in der Lehrer-Stimme bzw. in der Klavierstimme%'


UPDATE satz
SET Bemerkung = REPLACE(Bemerkung, 'Klavier spielt Melodie der Schülerstimme mit', '')
WHERE satz.Bemerkung LIKE '%Klavier spielt Melodie der Schülerstimme mit%'

