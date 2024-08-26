

delete from 
musikstueck_besetzung USING 
musikstueck_besetzung 
inner join musikstueck 
on musikstueck.ID = musikstueck_besetzung.MusikstueckID
inner join sammlung 
on musikstueck.SammlungID = sammlung.ID 
where musikstueck.SammlungID = :SammlungID 
and musikstueck_besetzung.BesetzungID=:BesetzungID  
