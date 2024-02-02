CREATE  OR REPLACE VIEW saetze_v AS 

SELECT 
    sz.Name as Satz 
   , m.Name as Musikstueck 
   , sz.Tonart
   , sz.Taktart
   , sz.Tempobezeichnung
   , sz.Spieldauer
   , sz.Schwierigkeitsgrad
   , sz.Lagen
   , sz.Stricharten
   , sz.Erprobt
   , sz.Bemerkung
   , sz.Nr as SatzNr 
   , sz.Notenwerte

	, CONCAT(k.Vorname, ' ', k.Nachname) as Komponist
	, sa.Name AS Sammlung
	, v.Name AS Verlag

   
 /* ids */ 
   , sz.ID 
   , sz.MusikstueckID
   , m.SammlungID
   , sa.VerlagID
   , m.KomponistID
   
FROM satz sz
LEFT JOIN musikstueck m 
on sz.MusikstueckID = m.ID
LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
LEFT join  komponist  AS k on m.KomponistID = k.ID 
LEFT join  verlag  AS v on sa.VerlagID = v.ID 


