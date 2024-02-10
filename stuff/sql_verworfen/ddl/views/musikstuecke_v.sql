CREATE OR REPLACE VIEW musikstuecke_v AS 
select 
/* musikstueck */
	m.Name AS Name
	,m.Nummer AS Nr
    , m.Opus 
	, CONCAT(k.Vorname, ' ', k.Nachname) as Komponist /* komponist */
	, sa.Name AS Sammlung /* sammlung */ 
	, v.Name AS Verlag /* verlag */
    , m.Bearbeiter
    , m.Epoche
    , m.Verwendungszweck
    , m.Gattung
    , b.Name as Besetzung /* besetzung */

 /* satz */     
    , s.Name as Satz 
    , s.Nr as SatzNr
    , s.Tonart 
    , s.Taktart
    , s.Tempobezeichnung
    , s.Spieldauer
    , s.Schwierigkeitsgrad
    , s.Lagen 
    , s.Stricharten 
    , s.Erprobt 
    , s.Notenwerte

/* ids */
    , sa.ID AS SammlungID 
    , k.ID AS KomponistID
    , b.ID as BesetzungID
    , v.ID as VerlagID 
	, m.ID as MusikstueckID
    , m.ID 
   FROM 
    musikstueck  AS m 
    LEFT join  satz  AS s on m.ID = s.MusikstueckID    
    LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
    LEFT join  komponist  AS k on m.KomponistID = k.ID 
    LEFT join  verlag  AS v on sa.VerlagID = v.ID 
    left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
    left join besetzung b on mb.BesetzungID = b.ID

