CREATE OR REPLACE VIEW v_uebung AS 
SELECT 
    uebung.ID
    , schueler.Name as Schueler
    , uebungtyp.Name as Typ    
    , uebung.Name 
    , uebung.Datum
    , uebung.Anzahl
    , uebung.Bemerkung
    , uebung.UebungtypID
FROM  uebung 
     left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
     left join schueler on schueler.ID=uebung.SchuelerID  