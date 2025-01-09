
update satz 
inner join musikstueck on musikstueck.ID = satz.MusikstueckID
set satz.Orchesterbestzung = 'VL1, VL2, VLA (alt. VL3), VC und KB und PNO' -- XX 
where musikstueck.SammlungID = 282    -- XX

