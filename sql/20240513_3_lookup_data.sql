
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Verwendungszweck', 'musikstueck') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Besetzung', 'musikstueck') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Epoche', 'musikstueck') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Gattung', 'musikstueck') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Erprobt', 'satz') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Notenwert', 'satz') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Schwierigkeitsgrad', 'satz') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Strichart', 'satz') ;
-- -- INSERT INTO lookup_type (Name, Relation) VALUES('Übung', 'satz') ;

INSERT INTO lookup_type (Name, Relation) VALUES('Melodische Besonderheit', 'satz') ;
INSERT INTO lookup_type (Name, Relation) VALUES('Rhythmische Besonderheit ', 'satz') ;
INSERT INTO lookup_type (Name, Relation) VALUES('Dynamische Besonderheit', 'satz') ;


select * from lookup_type; 

/*
ID	Name	Relation
1	Melodische Besonderheit	satz
2	Rhythmische Besonderheit	satz
3	Dynamische Besonderheit	satz


*/



delete from lookup; 

INSERT INTO lookup (ID, Name, LookupTypeID) 
select ID, Name, 1 as LookupTypeID
from besonderheit 
where Typ='Melodik'
; 

INSERT INTO lookup (ID, Name, LookupTypeID) 
select ID, Name, 2 as LookupTypeID
from besonderheit 
where Typ='Rythmik'
; 

INSERT INTO lookup (ID, Name, LookupTypeID) 
select ID, Name, 3 as LookupTypeID
from besonderheit 
where Typ='Dynamik'
; 


select * from lookup;
select * from besonderheit; 


INSERT INTO satz_lookup (ID, SatzID, LookupID)
select ID, SatzID, BesonderheitID from satz_besonderheit 


-----------------------------


select satz.ID
    , lookup.Name 
    , lookup_type.Name  as Typ
    , satz.Bemerkung
from satz 
left join satz_lookup on satz_lookup.SatzID = satz.ID 
left join lookup on lookup.ID = satz_lookup.LookupID 
left join lookup_type on lookup_type.ID = lookup.LookupTypeID
where satz_lookup.SatzID IS NOT nULL 
order by satz.ID, lookup.LookupTypeID

