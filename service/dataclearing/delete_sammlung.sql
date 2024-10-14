/****** Eine Sammlung mit allen Untereinheiten löschen    *******/
/* Stand Mai 2024, ggf. noch ergänzen! */ 

/* Satz und Verknüpfungen */
delete from satz_notenwert USING 
satz_notenwert
inner join satz on satz.ID= satz_notenwert.SatzID
inner join musikstueck on musikstueck.ID = satz.MusikstueckID
where musikstueck.SammlungID = 149
; 

delete from 
satz_strichart USING 
satz_strichart
inner join satz 
    on satz.ID= satz_strichart.SatzID
inner join musikstueck 
    on musikstueck.ID = satz.MusikstueckID
where musikstueck.SammlungID = 149
; 

delete from 
satz USING 
satz inner join musikstueck 
    on musikstueck.ID = satz.MusikstueckID
where musikstueck.SammlungID = 149
; 

delete from 
musikstueck_besetzung USING 
musikstueck_besetzung inner join musikstueck 
    on musikstueck.ID = musikstueck_besetzung.MusikstueckID
where musikstueck.SammlungID = 149
;

delete from 
musikstueck_verwendungszweck USING 
musikstueck_verwendungszweck inner join musikstueck 
    on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID
where musikstueck.SammlungID = 149
;

delete from musikstueck where SammlungID = 149
;

delete from sammlung where ID = 149
;