-- ALTER TABLE abfrage DROP IF EXISTS ts_update;
-- ALTER TABLE abfragetyp DROP IF EXISTS ts_update;
-- ALTER TABLE auto_update DROP IF EXISTS ts_update;
-- ALTER TABLE besetzung DROP IF EXISTS ts_update;
-- ALTER TABLE epoche DROP IF EXISTS ts_update;
-- ALTER TABLE erprobt DROP IF EXISTS ts_update;
-- ALTER TABLE gattung DROP IF EXISTS ts_update;
-- ALTER TABLE instrument DROP IF EXISTS ts_update;
-- ALTER TABLE komponist DROP IF EXISTS ts_update;
-- ALTER TABLE link DROP IF EXISTS ts_update;
-- ALTER TABLE link_tmp DROP IF EXISTS ts_update;
-- ALTER TABLE linktype DROP IF EXISTS ts_update;
-- ALTER TABLE lookup DROP IF EXISTS ts_update;
-- ALTER TABLE lookup_type DROP IF EXISTS ts_update;
-- ALTER TABLE musikstueck DROP IF EXISTS ts_update;
-- ALTER TABLE musikstueck_besetzung DROP IF EXISTS ts_update;
-- ALTER TABLE musikstueck_verwendungszweck DROP IF EXISTS ts_update;
-- ALTER TABLE sammlung DROP IF EXISTS ts_update;
-- ALTER TABLE sammlung_lookup DROP IF EXISTS ts_update;
-- ALTER TABLE satz DROP IF EXISTS ts_update;
-- ALTER TABLE satz_erprobt DROP IF EXISTS ts_update;
-- ALTER TABLE satz_lookup DROP IF EXISTS ts_update;
-- ALTER TABLE satz_schwierigkeitsgrad DROP IF EXISTS ts_update;
-- ALTER TABLE schwierigkeitsgrad DROP IF EXISTS ts_update;
-- ALTER TABLE standort DROP IF EXISTS ts_update;
-- ALTER TABLE verwendungszweck DROP IF EXISTS ts_update;	


ALTER TABLE abfrage  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE abfragetyp  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE auto_update  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE besetzung  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE epoche  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE erprobt  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE gattung  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE instrument  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE komponist  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE link  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE link_tmp  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE linktype  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE lookup  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE lookup_type  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE musikstueck  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE musikstueck_besetzung  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE musikstueck_verwendungszweck  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE sammlung  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE sammlung_lookup  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE satz  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE satz_erprobt  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE satz_lookup  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE satz_schwierigkeitsgrad  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE schwierigkeitsgrad  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE standort  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 
ALTER TABLE verwendungszweck  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 

