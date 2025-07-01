 select 
      schueler.ID 
    , schueler.Name
    , schueler.Bemerkung       
	, v_schueler_instrumente.Instrumente  
   , GROUP_CONCAT(DISTINCT 
            IF(sm.ID is not null
                   , CONCAT('* ', sm.Name, ': ', material.Name)
                   , CONCAT('* ', material.Name)
                  ) 
            order by 
                IF(sm.ID is not NULL, CONCAT(sm.Name, ': ', material.Name), material.Name)
            SEPARATOR '<br />') as Materialien
     , GROUP_CONCAT(
            DISTINCT concat('* ', sammlung.Name, ' / ', musikstueck.Name, 
                        IF(satz.Name <> '', CONCAT(' / ', satz.Name), ''), 
                        IF(schueler_satz.Bemerkung <> '', CONCAT(' / ', schueler_satz.Bemerkung), '')
            )  
            order by sammlung.Name, musikstueck.Nummer 
            SEPARATOR '<br />') as Noten 
    from schueler 
        left join schueler_material on schueler_material.SchuelerID = schueler.ID
        left join material on material.ID = schueler_material.MaterialID 
        left join sammlung sm on sm.ID=material.SammlungID 
        left join schueler_satz on schueler_satz.SchuelerID  = schueler.ID 
        left join satz on satz.ID = schueler_satz.SatzID 
        left join musikstueck on musikstueck.ID = satz.MusikstueckID
        left join sammlung on sammlung.ID = musikstueck.SammlungID    
		left join v_schueler_instrumente on v_schueler_instrumente.SchuelerID = schueler.ID 
    -- where schueler.ID=64
    group by schueler.ID 
    order by schueler.Name 