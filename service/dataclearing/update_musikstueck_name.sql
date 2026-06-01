/*
Korrektur Musikstück Name 
*/

update musikstueck 
set Name = REPLACE(Name, 'Abschnitt ', '')
where SammlungID = 282 
and Name LIKE 'Abschnitt%'


update musikstueck set Name = REPLACE(Name, 'Open Strings and first Finger', 'Open Strings')
select * from musikstueck 
where SammlungID = 1334 
and Nummer BETWEEN 1 AND 10 
and Name LIKE 'Open Strings and first Finger:%'


update musikstueck set Name = REPLACE(Name, 'Open Strings and first Finger', '1st finger')
-- select * from musikstueck 
where SammlungID = 1334 
and Nummer BETWEEN 12 AND 21  
and Name LIKE 'Open Strings and first Finger%'










   