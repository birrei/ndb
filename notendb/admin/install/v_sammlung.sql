create or replace view v_sammlung as
select sammlung.ID
    , sammlung.Name
    , v_sammlung_standorte.Standorte     
    , verlag.Name as Verlag
    , sammlung.Bemerkung
    , v_sammlung_lookuptypes.LookupList as Besonderheiten       
   , Erfasst  
from sammlung 
    left join verlag  on sammlung.VerlagID = verlag.ID 
    LEFT JOIN v_sammlung_standorte ON v_sammlung_standorte.SammlungID=sammlung.ID 
    LEFT JOIN sammlung_lookup on sammlung_lookup.SammlungID = sammlung.ID       
    LEFT JOIN v_sammlung_lookuptypes on v_sammlung_lookuptypes.SammlungID = sammlung.ID         
group by sammlung.ID 