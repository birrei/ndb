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
; 

/* Testviews */


create OR REPLACE view test_musikstueck_ohne_Besetzung_v 
AS 
select m.* 
from musikstueck m 
left join musikstueck_besetzung mb 
on m.ID = mb.MusikstueckID 
where mb.ID is null 
; 

CREATE OR REPLACE VIEW test_musikstueck_ohne_komponist_v AS
select m.* 
from musikstueck m 
left join komponist k 
on m.KomponistID = k.ID
where k.ID is null 
; 

CREATE  OR REPLACE VIEW test_musikstueck_ohne_satz_v 
AS 
select m.*
from  musikstueck m 
left join satz s 
on s.MusikstueckID = m.ID 
where s.ID is null 

;

CREATE OR REPLACE VIEW test_sammlung_ohne_verlag_v AS 
select s.* 
from sammlung s 
left join verlag v on s.VerlagID = v.ID
where v.ID is null 

;

CREATE  OR REPLACE VIEW test_satz_ohne_musikstueck_v AS 
select s.*
from satz s 
left join musikstueck m 
on s.MusikstueckID = m.ID 
where m.ID is null 


