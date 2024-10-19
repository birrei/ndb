/*
Korrektur Musikstück Name 
*/

update musikstueck 
set Name = REPLACE(Name, 'Abschnitt ', '')
where SammlungID = 282 
and Name LIKE 'Abschnitt%'
