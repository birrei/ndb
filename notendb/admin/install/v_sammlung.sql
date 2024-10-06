create or replace view v_sammlung as
select sammlung.ID
    , sammlung.Name
    , verlag.Name as Verlag
    , standort.Name as Standort
    , sammlung.Bemerkung
    , v_sammlung_lookuptypes.LookupList as Besonderheiten       
   -- , sammlung.Bestellnummer   
   , sammlung.StandortID  
from sammlung 
    left join verlag  on sammlung.VerlagID = verlag.ID 
    left join standort on sammlung.StandortID = standort.ID
    LEFT JOIN sammlung_lookup on sammlung_lookup.SammlungID = sammlung.ID       
    LEFT JOIN v_sammlung_lookuptypes on v_sammlung_lookuptypes.SammlungID = sammlung.ID         


group by sammlung.ID 