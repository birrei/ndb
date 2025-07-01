select ID, Name, ts_update, 'sammlung' as tab  from sammlung order by ts_update desc ;
select ID, Name, ts_insert , 'sammlung' as tab  from sammlung order by ts_insert desc ;

-- select * from sammlung order by ts_insert desc ;
-- select * from schueler_satz order by ts_insert desc ;