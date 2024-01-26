CREATE  OR REPLACE VIEW musikstuecke_v AS 
   SELECT 
	m.Name AS Name
	,m.Nummer AS Nr
    , m.Opus 
	,CONCAT(k.Vorname, ' ', k.Nachname) as Komponist
	,sa.Name AS Sammlung
	,v.Name AS Verlag
    , m.Bearbeiter
    , m.Epoche
    , m.Verwendungszweck
    , m.Gattung
    , m.Besetzung 
    , sa.ID AS SammlungID 
    , k.ID AS KomponistID
	, m.ID
   FROM 
      musikstueck  AS m 
      LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
      LEFT join  komponist  AS k on m.KomponistID = k.ID 
      LEFT join  verlag  AS v on sa.VErlagID = v.ID 
