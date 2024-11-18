
-- Anpassungen bei "XX"

-- Neu / Überschreiben 
update satz 
inner join musikstueck on musikstueck.ID = satz.MusikstueckID
set satz.Bemerkung = ' mit Akkordsymbolen' -- XX 
where musikstueck.SammlungID = 296 -- XX


-- Ergänzung ev. vorhandenen Bemerkungstextes: 
update satz 
inner join musikstueck on musikstueck.ID = satz.MusikstueckID
set satz.Bemerkung = concat(satz.Bemerkung, ' ', ', mit Akkordsymbolen') -- XX 
where musikstueck.SammlungID = 11 -- XX 