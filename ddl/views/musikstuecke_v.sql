CREATE  OR REPLACE VIEW musikstuecke_v AS 
   SELECT 
	m.Name AS Name
	,m.Nummer AS Nr
    , m.Opus 
	, CONCAT(k.Vorname, ' ', k.Nachname) as Komponist
	, sa.Name AS Sammlung
	,v.Name AS Verlag
    , m.Bearbeiter
    , m.Epoche
    , m.Verwendungszweck
    , m.Gattung
    -- , m.Besetzung 
    , s.Name as SAtz 
    , s.Nr as SatzNr
    , s.Tonart 
    , s.Taktart
    , s.Tempobezeichnung
    , s.Spieldauer
    , s.Schwierigkeitsgrad
    , s.Lagen 
    , S.Stricharten 
    , s.Erprobt 
    , s.Notenwerte
    , s.Bemerkung as Satz_Bemerkung     

    , sa.ID AS SammlungID 
    , k.ID AS KomponistID
	, m.ID
   FROM 
      musikstueck  AS m 
      LEFT join  satz  AS s on m.ID = s.MusikstueckID    
      LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
      LEFT join  komponist  AS k on m.KomponistID = k.ID 
      LEFT join  verlag  AS v on sa.VerlagID = v.ID 




