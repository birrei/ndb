


-- select * from lookup_type;
-- select * from lookup;
-- select * from strichart;
-- select * from notenwert;
-- select * from uebung;
-- -- XXX Lagen ... 





/* A: Metadaten übernehmen */

/* A1) lookup_type */
insert into lookup_type (Name, Relation,type_key) 
values('Stricharten', 'satz', 'besstrich');  

insert into lookup_type (Name, Relation,type_key) 
values('Notenwerte', 'satz', 'besnot');  

insert into lookup_type (Name, Relation,type_key) 
values('Uebung', 'satz', 'besueb');  



--------------------

/* A2) lookup */

--- Stricharten 

select * from lookup_type; 
-- LookupTypeID= 5 


insert into lookup (Name, LookupTypeID)
select Name, 5 as LookupTypeID from strichart --- LookupTypeID vor prod anpassen! 
; 
select * from strichart order by Name;
select * from lookup where LookupTypeID=5 order by Name; 


--- Notenwerte  

select * from lookup_type; 
-- LookupTypeID= 9 

insert into lookup (Name, LookupTypeID)
select Name, 9 as LookupTypeID from notenwert 

select * from notenwert order by Name;
select * from lookup where LookupTypeID=9 order by Name; 


--- Übung  

select * from lookup_type; 
-- LookupTypeID= 10 

insert into lookup (Name, LookupTypeID)
select Name, 10 as LookupTypeID from uebung 
; 

select * from uebung order by Name;
select * from lookup where LookupTypeID=10 order by Name; 


/* B: Migrations-Sichten erstellen */

-- strichart 
create or replace View v_tmp_satz_strichart_lookup as 
select distinct satz.ID 
    , satz.Name as Satz
    , strichart.ID as StrichartID 
    , strichart.Name as Strichart_Name
    , lookup.Name as Lookup_Name
    , lookup.ID as LookupID 
    , lookup.LookupTypeID
    , lookup_type.Name as LookupType 
from satz 
inner join satz_strichart 
    on satz_strichart.SatzID = satz.ID 
inner join strichart 
    on strichart.ID = satz_strichart.StrichartID
inner join lookup   
    on strichart.Name = lookup.Name
inner join lookup_type 
    on lookup_type.ID = lookup.LookupTypeID 
where lookup.LookupTypeID=5 
order by strichart.Name

; 
select * from  v_tmp_satz_strichart_lookup;


-- notenwerte  
create or replace View v_tmp_satz_notenwert_lookup as 
select distinct satz.ID 
    , satz.Name as Satz
    , notenwert.ID as NotenwertID 
    , notenwert.Name as Notenwert_Name
    , lookup.Name as Lookup_Name
    , lookup.ID as LookupID 
    , lookup.LookupTypeID
    , lookup_type.Name as LookupType 
from satz 
inner join satz_notenwert
    on satz_notenwert.SatzID = satz.ID 
inner join notenwert 
    on notenwert.ID = satz_notenwert.NotenwertID 
inner join lookup   
    on notenwert.Name = lookup.Name
inner join lookup_type 
    on lookup_type.ID = lookup.LookupTypeID 
where lookup.LookupTypeID=9  
order by notenwert.Name
; 

select * from v_tmp_satz_notenwert_lookup
;

-- Übung  
create or replace View v_tmp_satz_uebung_lookup as 
select distinct satz.ID 
    , satz.Name as Satz
    , uebung.ID as UebungID 
    , uebung.Name as Uebung_Name
    , lookup.Name as Lookup_Name
    , lookup.ID as LookupID 
    , lookup.LookupTypeID
    , lookup_type.Name as LookupType 
from satz 
inner join satz_uebung
    on satz_uebung.SatzID = satz.ID 
inner join uebung 
    on uebung.ID = satz_uebung.UebungID 
inner join lookup   
    on uebung.Name = lookup.Name
inner join lookup_type 
    on lookup_type.ID = lookup.LookupTypeID 
where lookup.LookupTypeID=10      
order by uebung.Name
; 

select * from  v_tmp_satz_uebung_lookup;

-------------------------

select * from v_tmp_satz_strichart_lookup;
; 
select * from v_tmp_satz_notenwert_lookup
;
select * from v_tmp_satz_uebung_lookup
;

-------------------------


insert into satz_lookup (SatzID, LookupID) 
select ID, LookupID from v_tmp_satz_strichart_lookup;

insert into satz_lookup (SatzID, LookupID) 
select ID, LookupID from v_tmp_satz_notenwert_lookup;

insert into satz_lookup (SatzID, LookupID) 
select ID, LookupID from v_tmp_satz_uebung_lookup;







-- -- Sichtprüfung: wo werden allte lookups auf mehrere neue lookup-Typen gemappt? 
-- -- aus einem der Lookup-Typen muss der Eintrag entfernt werden 
-- -- falls einer der zuvielenen Typen der Typ "Übung" ist, dann diesen entfernen 

-- -- falls in der Anwendung  die Zuordnungen schon doppelt sind, dann dort auch bereinigen. 

-- select Name, count(distinct LookupTypeID)  anz_typen 
-- from v_lookups
-- group by Name  
-- having count(distinct LookupTypeID) > 1

-- -- Name	anz_typen
-- -- 	2
-- -- 	2
-- -- Pralltriller	2
-- -- Punktierte Achtel	2
-- -- Punktierte Halbe	2
-- -- Punktierte Viertel	2
-- -- Taktwechsel	2
-- -- Triller	2
-- -- Viertel	2
-- -- Viertelpausen	2


-- -- select * from v_lookups where Name ='Spiccato';
-- -- select * from v_lookups where Name ='Betonungen';
-- -- select * from v_lookups where Name ='Doppelklänge';
-- select * from v_lookups where Name ='Halbe';


-- -- clearing dev: 
-- delete from lookup where ID=145 -- spiccato aus "Übung" entfernen, da schon in "Stricharten"
-- delete from lookup where ID=129 -- Betonungen aus "Übung" entfernen, da schon in "Stricharten"
-- delete from lookup where ID=134 -- Doppelklänge aus "Übung" entfernen, da schon in "Melodische Besonderheiten"



/*******************************************/

-- select StrichartID, Strichart_Name
-- , COUNT(distinct LookupTypeID) anzahl_typen
--  from v_tmp_satz_strichart_lookup
-- group by StrichartID, Strichart_Name
-- having COUNT(distinct LookupTypeID) > 1
-- order by Strichart_Name; 

-- -- select * from v_tmp_satz_strichart_lookup where StrichartID in (5,18)

-- select NotenwertID, Notenwert_Name
-- , COUNT(distinct LookupTypeID) anzahl_typen
--  from v_tmp_satz_Notenwert_lookup
-- group by NotenwertID, Notenwert_Name
-- having COUNT(distinct LookupTypeID) > 1
-- order by Notenwert_Name; 


select * from v_tmp_satz_strichart_lookup;
; 

select * from v_tmp_satz_notenwert_lookup
;

select * from v_tmp_satz_uebung_lookup
;





