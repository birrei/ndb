CREATE OR REPLACE VIEW musikstuecke2_v AS 


select 
	m.Name AS Name
	,m.Nummer AS Nr
    , m.Opus 
	, k.Name 
	, sa.Name AS Sammlung
	, v.Name AS Verlag
    , m.Bearbeiter
    , m.Epoche
    -- , m.Verwendungszweck
    , m.Gattung
    , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen  
	, m.ID
   FROM 
    musikstueck  AS m 
    LEFT join  satz  AS s on m.ID = s.MusikstueckID    
    LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
    LEFT join  v_select_komponist  AS k on m.KomponistID = k.ID 
    LEFT join  verlag  AS v on sa.VerlagID = v.ID 
    left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
    left join besetzung b on mb.BesetzungID = b.ID
 group by m.ID 








/* 
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
    , s.Bemerkung as Satz_Bemerkung     
    , sa.ID AS SammlungID 
    , k.ID AS KomponistID
*/



/******************************/
CREATE OR REPLACE VIEW v_musikstueck AS 



SELECT  
	 sa.Name AS Sammlung /* sammlung */ 

	, m.Name AS Name
	, m.Nummer AS Nr
    -- , m.Opus 
	, CONCAT(COALESCE(k.Vorname, '') , ' ', COALESCE(k.Nachname, '')) as Komponist /* komponist */

	, v.Name AS Verlag /* verlag */
    , m.Bearbeiter
    , m.Epoche
    , vz.Name as Verwendungszweck 
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
/*    --  , s.Stricharten */
    , st.Name as Strichart 
    , s.Erprobt 
    , s.Notenwerte
/* ids */
    , sa.ID AS SammlungID 
    , k.ID AS KomponistID
    , b.ID as BesetzungID
    , vz.ID as VerwendungszweckID
    , v.ID as VerlagID 
    , s.ID as SatzID 
    , ss.ID as StrichartID 
    , m.ID 
   FROM 
    musikstueck  AS m 
    LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
    LEFT join  komponist  AS k on m.KomponistID = k.ID 
    LEFT join  verlag  AS v on sa.VerlagID = v.ID 
    left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
    left join besetzung b on mb.BesetzungID = b.ID
    left join musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
    left join verwendungszweck vz on mv.VerwendungszweckID=vz.ID 

Order by m.ID DESC 

; 

CREATE OR REPLACE VIEW v_satz AS 

SELECT  
	 sa.Name AS Sammlung /* sammlung */ 
	, m.Name AS Musikstueck
	, m.Nummer AS MusikstückNr

 /* satz */     
    , s.Name as Satz 
    , s.Nr as SatzNr
    , s.Tonart 
    , s.Taktart
    , s.Tempobezeichnung
    , s.Spieldauer
    , s.Schwierigkeitsgrad
    , s.Lagen 
    , s.Erprobt 
    , s.Notenwerte
-- /* ids */
--     , sa.ID AS SammlungID 
--     , k.ID AS KomponistID
--     , b.ID as BesetzungID
--     , vz.ID as VerwendungszweckID
--     , v.ID as VerlagID 
    , s.ID as SatzID 
    , m.ID 
   FROM 
    musikstueck  AS m 
    LEFT join  satz  AS s on m.ID = s.MusikstueckID    
    LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
    LEFT join  komponist  AS k on m.KomponistID = k.ID 
-- where m.ID=1
order by sa.ID, m.Nummer, s.Nr 
; 

