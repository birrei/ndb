CREATE OR REPLACE VIEW v_uebung AS 
SELECT 
    uebung.ID
    , schueler.Name as Schueler
    , uebungtyp.Name as Typ    
    , uebung.Name as `Uebung Inhalt`  
    , uebung.Datum
    , uebung.Anzahl
    , uebungtyp.Einheit
    , uebung.Bemerkung
	, CONCAT(
	        sammlung.Name, ' - ', 
	          -- musikstueck.Nummer, ' - ', 
	          musikstueck.Name, ' - Satz Nr. ',  
	          satz.Nr
	          ) Notenstueck  	          
    , uebung.UebungtypID
FROM  uebung 
    INNER join schueler on schueler.ID=uebung.SchuelerID
                    and schueler.Aktiv=1
    left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
    left join satz  on satz.ID=uebung.SatzID 
    left join musikstueck on satz.MusikstueckID = musikstueck.ID
    left JOIN sammlung on sammlung.ID = musikstueck.SammlungID      

