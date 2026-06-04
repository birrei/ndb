select verwendungszweck.Name as Verwendungszweck 
	, status.Name as STatus 
	, musikstueck.Name as Musikstueck 
	, musikstueck.ID as MusikstueckID 
	, satz.Name as Satz 
	-- update schueler_satz  
    --  SELECT count(DISTINCT schueler_satz.ID )

UPDATE schueler_satz 
inner join status on status.ID = schueler_satz.StatusID 
inner join satz on schueler_satz.SatzID = satz.ID 
inner join musikstueck  on satz.MusikstueckID = musikstueck.ID
inner join  musikstueck_verwendungszweck on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
INNER JOIN verwendungszweck  ON verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID 
SET schueler_satz.StatusID=7 
WHERE verwendungszweck.ID = 152
and schueler_satz.StatusID=3
