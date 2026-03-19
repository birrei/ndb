SELECT 
      uebung.ID
      , uebungtyp.Name as Typ    
      -- , uebung.Name 
      , year(uebung.Datum) as Jahr
      , month(uebung.Datum) as Monat 
      , SUM(uebung.Anzahl) as Summe_Anzahl 
      , uebungtyp.Einheit 
      , uebung.SchuelerID
      , uebung.UebungtypID
  FROM  uebung 
      left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
      left join satz  on satz.ID=uebung.SatzID 
      left join musikstueck on satz.MusikstueckID = musikstueck.ID
      left JOIN sammlung on sammlung.ID = musikstueck.SammlungID      
      left join material  on material.ID=uebung.MaterialID
      left JOIN materialtyp on materialtyp.ID = material.MaterialtypID      
      left join sammlung as sammlung2  on sammlung2.ID=material.SammlungID
where uebung.SchuelerID = 9
and UebungtypID  is not null 
GROUP by uebung.SchuelerID
	, uebung.UebungtypID
	, uebungtyp.Einheit
	,  year(uebung.Datum)
	,  month(uebung.Datum) 
	
              