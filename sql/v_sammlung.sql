create or replace view v_sammlung as
select s.ID
    , s.Name
    , v.Name as Verlag
    , st.Name as Standort
    , s.Bestellnummer
    , s.Bemerkung 
from sammlung s
        left join verlag v on s.VerlagID = v.ID 
        left join standort st on s.StandortID = st.ID


