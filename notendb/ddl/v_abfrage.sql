create or replace view v_abfrage as
select abfrage.ID
    , abfrage.Name
    , abfrage.Beschreibung
    , abfragetyp.Name as Abfragetyp
    , abfragetyp.ID as AbfragetypID
from abfrage 
     LEFT JOIN 
     abfragetyp on abfrage.AbfragetypID = abfragetyp.ID 