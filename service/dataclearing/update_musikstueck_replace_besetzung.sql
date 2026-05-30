/*
In einer definierten Sammlung soll bei allen Musikstücken eine bestimmte Besetzung 
durch eine bestimmte andere Besetzung ersetzt werden. 
*/
-------------------------------------
-- "Viola und Klavier" -> "Violine und Klavier" 
-- select ID, Name from besetzung where Name IN ('Viola und Klavier', 'Violine und Klavier')
-- 1	Violine und Klavier
-- 130	Viola und Klavier

update musikstueck_besetzung  
inner join musikstueck on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
set BesetzungID =1 -- Violine und Klavier 
where musikstueck.SammlungID=1334     
and musikstueck_besetzung.BesetzungID = 130  -- Viola und Klavier 

-------------------------------------
-- "2 Violen und Klavier" -> "2 Violinen und Klavier" 
-- select ID, Name from besetzung where Name IN ('2 Violen und Klavier', '2 Violinen und Klavier')

-- 104	2 Violinen und Klavier
-- 192	2 Violen und Klavier

update musikstueck_besetzung  
inner join musikstueck on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
set BesetzungID =104
where musikstueck.SammlungID=1334     
and musikstueck_besetzung.BesetzungID = 192  



-------------------------------------
-- "3 Violen und Klavier" -> "3 Violinen und Klavier" 
-- select ID, Name from besetzung where Name IN ('3 Violen und Klavier', '3 Violinen und Klavier')
-- 129	3 Violinen und Klavier
-- 193	3 Violen und Klavier


update musikstueck_besetzung  
inner join musikstueck on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
set BesetzungID =129
where musikstueck.SammlungID=1334     
and musikstueck_besetzung.BesetzungID = 193  

-------------------------------------
-- "Viola" -> "Violine" 
-- select ID, Name from besetzung where Name IN ('Viola', 'Violine')

-- 2	Violine
-- 146	Viola

update musikstueck_besetzung  
inner join musikstueck on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
set BesetzungID =2
where musikstueck.SammlungID=1334     
and musikstueck_besetzung.BesetzungID = 146  





